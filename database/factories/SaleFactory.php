<?php

namespace Database\Factories;

use App\Models\Airline;
use App\Models\FlightType;
use App\Models\Sale;
use App\Models\Portal;
use App\Models\ServiceType;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'issue_date' => $this->faker->date(),
            'issued_portal' => Portal::inRandomOrder()->value('name'),
            'service_type' => ServiceType::inRandomOrder()->value('name'),
            'gds_pnr' => $this->faker->bothify('PNR###'),
            'airline_pnr' => $this->faker->bothify('AIR###'),
            'agent_fare' => $this->faker->randomFloat(2, 10, 2000),
            'customer_fare' => $this->faker->randomFloat(2, 10, 2500),
            'customer_payment' => $this->faker->randomFloat(2, 0, 2500),
            'segment' => $this->faker->word(),
            'last_date_of_payment' => $this->faker->date(),
            'airline' => Airline::inRandomOrder()->value('name'),
            'flight_type' => FlightType::inRandomOrder()->value('name'),
            'trip' => Trip::inRandomOrder()->value('name'),
            'pax_name' => $this->faker->name(),
            'tkt_number' => $this->faker->bothify('TKT######'),
            'passport_nid' => $this->faker->bothify('ID########'),
            'flight_date' => $this->faker->date(),
            'return_date' => $this->faker->date(),
            'flight_status' => $this->faker->randomElement(['scheduled','cancelled','done']),
            'top_balance' => $this->faker->randomFloat(2, 0, 10000),
            'current_balance' => $this->faker->randomFloat(2, 0, 10000),
            'agent_price' => $this->faker->randomFloat(2, 0, 1000),
            'sell_price' => $this->faker->randomFloat(2, 0, 1500),
            'profit' => $this->faker->randomFloat(2, 0, 500),
            'segment_fare' => $this->faker->randomFloat(2, 0, 500),
            'contact_no' => $this->faker->phoneNumber(),
        ];
    }
}
