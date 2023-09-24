<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = Category::all()->pluck('id')->toArray();
        return [
            'category_id' => $this->faker->randomElement($id),
            'name' => $this->faker->unique()->firstName(),
            'whatsapp' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
