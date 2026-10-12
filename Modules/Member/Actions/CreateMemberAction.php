<?php

namespace Modules\Member\Actions;


use Illuminate\Support\Facades\Hash;
use Modules\Member\Dto\Auth\RegisterDto;
use Modules\Member\Models\Member;

class CreateMemberAction
{
  public function execute(RegisterDto $dto): Member
  {
    return Member::create([
      ...$dto->toArray(),
      'password' => Hash::make($dto->password),
    ]);
  }
}