<?php

namespace Modules\Acl\Console;

use Illuminate\Console\Command;
use Illuminate\Validation\Rule;
use Modules\Acl\Actions\User\CreateSuperUserAction;
use Modules\Acl\Models\User;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

#[AsCommand('stodio:user:create', 'Create a super user')]
class CreateUserCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $user = app(CreateSuperUserAction::class)->handle($this->getUserData());

            $this->components->info(sprintf(
                'Super user %s has been created. You can login at %s',
                $user->email ?? $user->username,
                route('admin.login')
            ));

            return self::SUCCESS;
        } catch (\Exception $exception) {
            $this->components->error('User could not be created.');
            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }
    }

    protected function getUserData(): array
    {
        return [
            'first_name' => text(
                label: 'First name',
                required: true,
                validate: ['required', 'min:2', 'max:60']
            ),
            'last_name' => text(
                label: 'Last name',
                required: true,
                validate: ['required', 'min:2', 'max:60']
            ),
            'email' => text(
                label: 'Email address',
                required: true,
                validate: [
                    'email',
                    'max:60',
                    Rule::unique((new User)->getTable(), 'email'),
                ]
            ),
            'username' => text(
                label: 'Username',
                required: true,
                validate: [
                    'min:4',
                    'max:60',
                    Rule::unique((new User)->getTable(), 'username'),
                ]
            ),
            'password' => password(
                label: 'Password',
                required: true,
                validate: ['min:6', 'max:60']
            ),
        ];
    }
}
