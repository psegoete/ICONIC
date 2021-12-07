<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class TuningTypesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 10000; $i++) { 
                DB::table('tuning_types')->insert([
                    'label' => $faker->name,
                    'credits' => $i,
                    'company_id' => 1,
                ]);
    	}
    }
}
