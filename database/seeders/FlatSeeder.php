<?php

namespace Database\Seeders;

use App\Models\Flat;
use App\Models\Project;
use Illuminate\Database\Seeder;

class FlatSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::query()->pluck('id');

        if ($projects->isEmpty()) {
            return;
        }

        foreach ($projects as $projectId) {
            Flat::factory()->count(4)->state([
                'project_id' => $projectId,
            ])->create();
        }
    }
}
