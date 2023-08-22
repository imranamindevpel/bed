<?php

namespace Database\Seeders;
use App\Models\Bed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    public function run(): void
    {        
        $bedLimit = env('MAX_BEDS_LIMIT');
        for ($i = 1; $i <= $bedLimit; $i++) {
            $beds = [
                [
                    'name' => 'Bed '.$i,
                    'status' => 'Available',
                    'type' => 'Top',
                    'daily_price' => env('TOP_BED_DAILY_PRICE'),
                    'weekly_price' => env('TOP_BED_WEEKLY_PRICE'),
                    'monthly_price' => env('TOP_BED_MONTHLY_PRICE'),
                ],
                [
                    'name' => 'Bed '.$i,
                    'status' => 'Available',
                    'type' => 'Middle',
                    'daily_price' => env('MIDDLE_BED_DAILY_PRICE'),
                    'weekly_price' => env('MIDDLE_BED_WEEKLY_PRICE'),
                    'monthly_price' => env('MIDDLE_BED_MONTHLY_PRICE'),
                ],
                [
                    'name' => 'Bed '.$i,
                    'status' => 'Available',
                    'type' => 'Bottom',
                    'daily_price' => env('BOTTOM_BED_DAILY_PRICE'),
                    'weekly_price' => env('BOTTOM_BED_WEEKLY_PRICE'),
                    'monthly_price' => env('BOTTOM_BED_MONTHLY_PRICE'),
                ],
            ];
            Bed::insert($beds);
        }
    }
}
