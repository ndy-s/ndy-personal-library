<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArtLibrary>
 */
class ArtLibraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_en' => fake()->name,
            'title_jp' => fake()->name,
            'page' => rand(0, 1000),
            'status' => 'Not Completed',
            'type' => 'Art',
        ];
    }
}
