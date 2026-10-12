<?php

namespace Modules\Acl\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if ($user === null) {
            return false;
        }

        return $user->hasPermission('acl.permissions.edit');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $permission = $this->route('permission');

        $permissionId = is_object($permission) ? $permission->getKey() : $permission;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permissionId)],
            'module' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
