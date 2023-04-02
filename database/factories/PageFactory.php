<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'author_id' => $this->faker->numberBetween(1, 10),
            'title' => $title,
            'excerpt' => $this->faker->paragraph,
            'body' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->imageUrl(),
            'slug' => Str::slug($title),
            'meta_description' => $this->faker->sentence,
            'meta_keywords' => $this->faker->words(5, true),
            'status' => $this->faker->boolean,
        ];
    }
}
