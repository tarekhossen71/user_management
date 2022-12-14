<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insert([
            [
                'name'  => 'Bangladesh',
                'status'    =>'1',
            ],
            [
                'name'  => 'India',
                'status'    =>'1',
            ],
        ]);
    }
}
