<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Breadcrumb;

class SeedAdminBreadcrumbs extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $breadcrumbs = [
            ['parent_id' => null, 'name' => 'Dashboard'     , 'href' => 'admin.dashboard'    , 'icon' => 'dashboard'    , 'for_admin' => true , 'level' => 0],
            ['parent_id' => 1,    'name' => 'Departments'   , 'href' => 'admin.departments'  , 'icon' => 'grid_view'    , 'for_admin' => true , 'level' => 1],
            ['parent_id' => 1,    'name' => 'Designations'  , 'href' => 'admin.designations' , 'icon' => 'badge'        , 'for_admin' => true , 'level' => 1],
            ['parent_id' => 1,    'name' => 'Structure'     , 'href' => 'admin.structure'    , 'icon' => 'account_tree' , 'for_admin' => true , 'level' => 1],
            ['parent_id' => 1,    'name' => 'Profile'       , 'href' => 'admin.profile'      , 'icon' => 'person'       , 'for_admin' => true , 'level' => 1],
            ['parent_id' => 1,    'name' => 'Employee'      , 'href' => 'admin.employee'     , 'icon' => 'groups_2'     , 'for_admin' => true , 'level' => 1],
        ];

        foreach ($breadcrumbs as $breadcrumb) {
            Breadcrumb::create($breadcrumb);
        }
    }
}
