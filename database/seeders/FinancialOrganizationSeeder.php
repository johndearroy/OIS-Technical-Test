<?php

namespace Database\Seeders;

use App\Models\FinancialOrganization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FinancialOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['name' => 'IFIC Bank Limited', 'short_name' => 'IFIC', 'address' => 'Dhaka'],
            ['name' => 'South East Bank Limited', 'short_name' => 'SOUTH-EAST', 'address' => 'Dhaka'],
            ['name' => 'The City Bank Limited', 'short_name' => 'CITY', 'address' => 'Dhaka']
        ];
        if (Schema::hasTable((new FinancialOrganization())->getTable())) {
            FinancialOrganization::query()->insert($banks);
        }
    }
}
