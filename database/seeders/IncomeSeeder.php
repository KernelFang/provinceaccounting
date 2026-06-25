<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Flat;
use App\Models\Income;
use App\Models\PaymentMethod;
use App\Models\Project;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::query()->get();
        $clients = Client::query()->get();
        $paymentMethods = PaymentMethod::query()->get();

        if ($projects->isEmpty() || $clients->isEmpty() || $paymentMethods->isEmpty()) {
            return;
        }

        $flats = Flat::query()->get();

        foreach ($projects as $project) {
            foreach ($flats->where('project_id', $project->id)->take(2) as $flat) {
                foreach ($clients->take(2) as $client) {
                    Income::factory()->state([
                        'project_id' => $project->id,
                        'flat_id' => $flat->id,
                        'client_id' => $client->id,
                        'payment_method_id' => $paymentMethods->random()->id,
                    ])->create();
                }
            }
        }
    }
}
