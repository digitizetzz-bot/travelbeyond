<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(fake()->numberBetween(2, 4), true).' National Park';

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'region' => fake()->randomElement(['Northern Safari Circuit', 'Southern Circuit', 'Zanzibar Archipelago', 'Western Circuit']),
            'category' => fake()->randomElement(['National Park', 'Conservation Area', 'Beach Island', 'Mountain']),
            'description' => fake()->paragraphs(2, true),
            'highlights' => fake()->sentence(8),
            'best_time_to_visit' => 'June to October (Dry Season)',
            'climate' => 'Warm days (25-30°C), cool nights',
            'entry_fee_info' => '$70 per adult per 24 hours',
            'photo' => null,
            'gallery' => [],
            'is_featured' => fake()->boolean(30),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
