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
            $users = User::factory()->create(),
            'user_id' => $users->id,
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'posted_by' => $this->faker->safeEmail,
        ];
    }
}
