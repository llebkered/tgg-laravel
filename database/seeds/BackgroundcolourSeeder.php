<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BackgroundColour;

class BackgroundcolourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['background' => 'has-text-white', 'css' => 'has-background-dark-green'],
            ['background' => 'has-text-black', 'css' => 'has-background-light-green'],
            ['background' => 'has-text-black', 'css' => 'has-background-tgg-accent1'],
            ['background' => 'has-text-black', 'css' => 'has-background-tgg-accent2'],
            ['background' => 'has-text-black', 'css' => 'has-background-off-white'],
            ['background' => 'has-text-black', 'css' => 'has-background-slate-grey'],
            ['background' => 'has-text-white', 'css' => 'has-background-trans-dark'],
            ['background' => 'has-text-black', 'css' => 'has-background-trans-light'],
            ['background' => 'has-text-black', 'css' => 'has-background-white'],
            ['background' => 'has-text-white', 'css' => 'has-background-black'],
            ['background' => 'has-text-white', 'css' => 'has-background-dark'],
            ['background' => 'has-text-white', 'css' => 'has-background-primary'],
            ['background' => 'has-text-white', 'css' => 'has-background-link'],
            ['background' => 'has-text-white', 'css' => 'has-background-info'],
            ['background' => 'has-text-white', 'css' => 'has-background-success'],
            ['background' => 'has-text-white', 'css' => 'has-background-warning'],
            ['background' => 'has-text-white', 'css' => 'has-background-danger'],

        ];

        foreach ($items as $item) {
            Backgroundcolour::create($item);
        }
    }
}
