<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategoryFactory extends Factory
{
    protected $model = ProductCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'is_open' => $this->faker->boolean(),
            'description' => $this->faker->sentence(),
            'avatar' => '/photos/shares/thumbs/BELOGO.png'
        ];
    }
}
