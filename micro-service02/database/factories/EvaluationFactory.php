<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $uuids = [
            '034cf3e3-6c60-4f53-838b-9ee36afb27fc',
            'e5a8846a-4e97-3841-a80e-491213b0e0bf',
            '2a554a57-9d65-391d-8509-e61ea6a6aeb8',
            '805a7ac7-1e2c-3321-a4d7-cb7497e1c2b6'
            ];
        return [
            'company' => $this->faker->randomElement($uuids),
            'comment' => $this->faker->sentence(100),
            'stars' => $this->faker->randomElement([1,2,3,4,5])
        ];
    }
}
