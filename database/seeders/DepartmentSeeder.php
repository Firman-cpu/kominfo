<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = config('diskominfo.departments');

        foreach ($departments as $dept) {
            Department::updateOrCreate(
                ['code' => $dept['code']],
                [
                    'name' => $dept['name'],
                    'sort_order' => $dept['sort_order'],
                ]
            );
        }
    }
}
