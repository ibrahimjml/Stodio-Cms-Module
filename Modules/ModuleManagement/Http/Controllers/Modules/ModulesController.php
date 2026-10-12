<?php

namespace Modules\ModuleManagement\Http\Controllers\Modules;

use Ibrahimjml\LaravelModules\ModuleManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Modules\ModuleManagement\Services\ModuleActivationService;
use Modules\ModuleManagement\Services\ModuleMigrationRunner;

class ModulesController
{
    public function __construct(
        private readonly ModuleManager $modules,
        private readonly ModuleActivationService $activation,
        private readonly ModuleMigrationRunner $migrations,
    ) {}

    #[Middleware('permission:modules.view')]
    public function index(): View
    {
        $this->activation->seedActivatedModules();

        $allModules = $this->modules->all()->map(function ($module): array {

            return [
                'name' => $module->name,
                'description' => $module->description(),
                'version' => $module->version(),
                'active' => $this->activation->isActive($module->name),
                'excluded' => $this->activation->isExcluded($module->name),
                'pendingMigrations' => $this->migrations->pending($module->name),
            ];
        })->values();

        $status = request()->string('status', 'all')->toString();

        $modules = $this->filterByStatus($allModules, $status);

        return view('modulemanagement::pages.modules.index', [
            'modules' => $this->paginate($modules),
            'activeCount' => $allModules->where('active', true)->count(),
            'inactiveCount' => $allModules->where('active', false)->count(),
            'status' => $status,
        ]);
    }

    #[Middleware('permission:modules.activate')]
    public function activate(string $module): RedirectResponse
    {
        if ($this->modules->find($module) === null) {
            return $this->redirectBack()->with('error', __('Module not found.'));
        }

        $this->activation->activate($module);

        return $this->redirectBack()
            ->with('success', __('Module ":module" has been activated.', ['module' => $module]));
    }

    #[Middleware('permission:modules.deactivate')]
    public function deactivate(string $module): RedirectResponse
    {
        if ($this->modules->find($module) === null) {
            return $this->redirectBack()->with('error', __('Module not found.'));
        }

        if ($this->activation->isExcluded($module)) {
            return $this->redirectBack()->with('error', __('This module cannot be deactivated.'));
        }

        $this->activation->deactivate($module);

        return $this->redirectBack()
            ->with('success', __('Module ":module" has been deactivated.', ['module' => $module]));
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $modules
     */
    private function filterByStatus(Collection $modules, string $status): Collection
    {
        return match ($status) {
            'active' => $modules->where('active', true)->values(),
            'inactive' => $modules->where('active', false)->values(),
            default => $modules,
        };
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $modules
     */
    private function paginate(Collection $modules): LengthAwarePaginator
    {
        $perPage = 5;
        $page = Paginator::resolveCurrentPage('page');

        $paginator = new LengthAwarePaginator(
            $modules->forPage($page, $perPage)->values(),
            $modules->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ],
        );

        return $paginator->withQueryString();
    }

    #[Middleware('permission:modules.migrate')]
    public function migrate(string $module): RedirectResponse
    {
        $result = $this->migrations->run($module);

        return redirect()->route('admin.modules.index')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    #[Middleware('permission:modules.delete')]
    public function destroy(string $module): RedirectResponse
    {
        $target = $this->modules->find($module);

        if ($target === null) {
            return $this->redirectBack()->with('error', __('Module not found.'));
        }

        if ($this->activation->isExcluded($target->name)) {
            return $this->redirectBack()->with('error', __('This module cannot be removed.'));
        }

        $rollback = $this->migrations->rollback($target->name);

        if (! $rollback['success']) {
            return $this->redirectBack()->with('error', $rollback['message']);
        }

        try {
            DB::transaction(function () use ($target): void {
                if (! File::deleteDirectory($target->path())) {
                    throw new \RuntimeException(__('Failed to delete the module directory.'));
                }

                $this->activation->forget($target->name);
            });
        } catch (\Throwable $exception) {
            return $this->redirectBack()->with('error', $exception->getMessage());
        }

        return $this->redirectBack()
            ->with('success', __('Module ":module" has been removed.', ['module' => $target->name]));
    }

    private function redirectBack(): RedirectResponse
    {
        $status = request('status', 'all');

        return redirect()->route(
            'admin.modules.index',
            $status !== 'all' ? ['status' => $status] : [],
        );
    }
}
