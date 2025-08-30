<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'category_id' => 1, // 後でシーダーで上書き
            'first_name'  => $this->faker->firstName(),
            'last_name'   => $this->faker->lastName(),
            'gender'      => $this->faker->randomElement([1,2,3]),
            'email'       => $this->faker->safeEmail(),
            'tel'         => $this->faker->numerify('0#-####-####'),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'detail'      => $this->faker->text(80),
        ];
    }
}
