<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradingTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = config('grading_templates', []);

        foreach ($templates as $key => $data) {
            \App\Models\GradingTemplate::updateOrCreate(
                ['template_key' => $key],
                [
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'periods' => $data['periods'],
                    'components' => $data['components'],
                    'is_active' => true,
                ]
            );
        }
    }
}
