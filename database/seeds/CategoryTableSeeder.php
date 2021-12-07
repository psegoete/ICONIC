<?php

use Illuminate\Database\Seeder;
use CreatyDev\Domain\Ticket\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'File service',
            ],
            [
                'name' => 'General question',
            ],
        ];


        Category::insert($categories);
    }
}
