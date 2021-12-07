<?php

use Illuminate\Database\Seeder;
use CreatyDev\Domain\Users\Models\Permission;
use CreatyDev\Domain\Users\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'children' => [
                    [
                        'name' => 'Root',
                    ],
                ]
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $permissions = [
            [
                'name' => 'File services'
            ],
            [
                'name' => 'Customers'
            ],
            [
                'name' => 'Internal news'
            ],
            [
                'name' => 'View orders'
            ],
            [
                'name' => 'Edit orders'
            ],
            [
                'name' => 'Mail templates'
            ],
            [
                'name' => 'Sent mails'
            ],
            [
                'name' => 'Pages'
            ],
            [
                'name' => 'Invoices'
            ],
            [
                'name' => 'Buy credits'
            ],
            [
                'name' => 'Subscription'
            ],
            [
                'name' => 'View tuning credit prices'
            ],
            [
                'name' => 'Edit tuning credit prices'
            ],
            [
                'name' => 'Delete tuning credit prices'
            ],
            [
                'name' => 'Features'
            ],
            [
                'name' => 'Platform configuration'
            ],
            [
                'name' => 'View tuning types'
            ],
            [
                'name' => 'Edit tuning types'
            ],
            [
                'name' => 'Delete Tuning types'
            ],
            [
                'name' => 'View tuning groups'
            ],
            [
                'name' => 'Edit tuning groups'
            ],
            [
                'name' => 'Delete tuning groups'
            ],
            [
                'name' => 'View read methods'
            ],
            [
                'name' => 'Edit read methods'
            ],
            [
                'name' => 'Delete read methods'
            ],
            [
                'name' => 'View gearboxes'
            ],
            [
                'name' => 'Edit gearboxes'
            ],
            [
                'name' => 'Delate gearboxes'
            ],
            [
                'name' => 'View payment methods'
            ],
            [
                'name' => 'Edit payment methods'
            ],
            [
                'name' => 'Delate payment methods'
            ],
            [
                'name' => 'View transactions'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
