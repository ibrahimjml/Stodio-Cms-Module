<?php

namespace Modules\Member\Services\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Member\Actions\CreateMemberAction;
use Modules\Member\Dto\Auth\RegisterDto;
use Modules\Member\Exceptions\RegisterException;

class RegisterService
{
    protected $factory;
  public function __construct(
    protected CreateMemberAction $createMemberAction
  ) {
  }
  public function register(RegisterDto $dto): array
  {
    try {
      $user = DB::transaction(function () use ($dto) {
        $user = $this->createMemberAction->execute($dto);


        return $user;
      });

    } catch (\Throwable $e) {
      Log::error('User registration failed.', [
        'email' => $dto->email,
        'username' => $dto->username,
        'exception' => $e,
      ]);

      throw new RegisterException();
    }
    
      return [
        'user' => $user,
        'message' => 'Your account has been registered, we will email you once activated.',
      ];
  }
}
