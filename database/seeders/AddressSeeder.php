<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::insert([
            'user_id'      => '1',
            'country_id'   => '1',
            'state'        => 'Dhaka',
            'postal_code'  => '1200',
            'phone' => '1234567890',
            'birthday'     => '2000-09-19',
        ]);
    }
}
