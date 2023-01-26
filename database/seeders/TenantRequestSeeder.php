<?php

namespace Database\Seeders;

use App\Models\TenantRequest;
use Illuminate\Database\Seeder;

class TenantRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TenantRequest::factory()
            ->count(5)
            ->create();
    }
}
