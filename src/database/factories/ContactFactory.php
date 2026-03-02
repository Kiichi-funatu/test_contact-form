<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->numerify('0##########'), // ハイフンなし
            'address' => $this->faker->address(), // 自然な住所
            'building' => $this->faker->secondaryAddress(), // 自然な建物名
            'detail' => $this->faker->realText(50), // 50文字程度の文章
        ];
    }
}
