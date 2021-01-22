<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['created_at' => $this->faker->dateTimeBetween( '-30 years', 'now',  null)]),
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'posted_by' => $this->faker->safeEmail,
            'created_at' => $this->faker->dateTimeBetween( '-30 years', 'now',  null)
        ];
    }
}
