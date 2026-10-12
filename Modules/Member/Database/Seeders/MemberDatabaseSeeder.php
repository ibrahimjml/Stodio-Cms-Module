<?php

namespace Modules\Member\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Member\Models\Member;

class MemberDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Member::factory(10)->create();
    }
}
