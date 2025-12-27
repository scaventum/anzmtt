<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $memberTypeKeys = array_keys(Member::TYPES);
        $numTypes = rand(0, count($memberTypeKeys));
        $types = $numTypes > 0
            ? $this->faker->randomElements($memberTypeKeys, $numTypes)
            : [];

        $numInterests = rand(1, 3);
        $interests = [];
        for ($i = 0; $i < $numInterests; $i++) {
            $interests[] = $this->faker->sentence(2);
        }

        return [
            'first_name' => $this->faker->firstName(),
            'email' => $this->faker->safeEmail(),
            'last_name' => $this->faker->lastName(),
            'title' => $this->faker->title(),
            'role' => $this->faker->jobTitle(),
            'organisation' => $this->faker->company(),
            'types' => $types,
            'interests' => $interests,
            'bio' => $this->faker->paragraph(),
            'last_active_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
