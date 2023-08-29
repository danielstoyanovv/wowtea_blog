<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\TestCardsFactory;

class TestCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestCardsFactory::new([
            'card_number' => 'test_4111111111111111',
            'expiry_month' => 'test_03',
            'expiry_year' => 'test_2030',
            'security_code' => 'test_737',
            'holder_name' => 'Test Test',
            'provider' => 'Adyen'
        ])->create();
    }
}
