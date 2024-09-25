<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlberVisualizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { {
            $data = [
                ['alber_id' => 'wd1', 'color' => '#F0D800'],
                ['alber_id' => 'wd2', 'color' => '#F0D800'],
                ['alber_id' => 'wd3', 'color' => '#F0D800'],
                ['alber_id' => 'wd4', 'color' => '#F0D800'],
                ['alber_id' => 'wd5', 'color' => '#F0D800'],
                ['alber_id' => 'wd6', 'color' => '#F0D800'],
                ['alber_id' => 'exc1', 'color' => '#F0D800'],
                ['alber_id' => 'exc2', 'color' => '#F0D800'],
                ['alber_id' => 'exc3', 'color' => '#F0D800'],
                ['alber_id' => 'exc4', 'color' => '#F0D800'],
                ['alber_id' => 'exc5', 'color' => '#F0D800'],
                ['alber_id' => 'exc6', 'color' => '#F0D800'],
                ['alber_id' => 'fo1', 'color' => '#F0D800'],
                ['alber_id' => 'fo2', 'color' => '#F0D800'],
            ];

            DB::table('alber_visualization')->insert($data);
        }
    }
}
