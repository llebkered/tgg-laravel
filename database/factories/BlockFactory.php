<?php

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Block::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hero' => $this->faker->boolean(50),
            'published' => $this->faker->boolean(50),
            'weight' => $this->faker->numberBetween(0, 100),
            'text_colour' => $this->faker->text,
            'background_colour' => $this->faker->text,
            'background_image' => $this->faker->text,
            'background_attachment' => $this->faker->text,
            'heading' => $this->faker->text,
            'heading_colour' => $this->faker->text,
            'content' => $this->faker->text,
            'content_background' => $this->faker->text,
            'content_width' => $this->faker->text,
            'content_position' => $this->faker->text,
            'cta_title' => $this->faker->text,
            'cta_link' => $this->faker->url,
        ];
    }
}
