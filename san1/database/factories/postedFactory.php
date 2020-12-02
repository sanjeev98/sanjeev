<?php

namespace Database\Factories;

use App\Models\posted;
use Illuminate\Database\Eloquent\Factories\Factory;

class postedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = posted::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description'=>$this->faker->text,
            'posted_by' => $this->faker->unique()->safeEmail,

        ];
    }
}
