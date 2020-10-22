<?php

namespace Database\Seeders;

use App\Models\Textcolour;
use Illuminate\Database\Seeder;

class TextcolourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['background' => 'has-background-black', 'css' => 'has-text-white'],
            ['background' => 'has-background-white', 'css' => 'has-text-black'],
            ['background' => 'has-background-white', 'css' => 'has-text-dark-green'],
            ['background' => 'has-background-black', 'css' => 'has-text-light-green'],
            ['background' => 'has-background-black', 'css' => 'has-text-tgg-accent1'],
            ['background' => 'has-background-black', 'css' => 'has-text-tgg-accent2'],
            ['background' => 'has-background-black', 'css' => 'has-text-off-white'],
            ['background' => 'has-background-black', 'css' => 'has-text-slate-grey'],
            ['background' => 'has-background-white', 'css' => 'has-text-trans-dark'],
            ['background' => 'has-background-black', 'css' => 'has-text-trans-light'],
            ['background' => 'has-background-white', 'css' => 'has-text-dark'],
            ['background' => 'has-background-white', 'css' => 'has-text-primary'],
            ['background' => 'has-background-white', 'css' => 'has-text-link'],
            ['background' => 'has-background-white', 'css' => 'has-text-info'],
            ['background' => 'has-background-white', 'css' => 'has-text-success'],
            ['background' => 'has-background-white', 'css' => 'has-text-warning'],
            ['background' => 'has-background-white', 'css' => 'has-text-danger'],

        ];

        foreach ($items as $item) {
            Textcolour::create($item);
        }
    }
}
