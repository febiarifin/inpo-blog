<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $user = User::factory()->create();
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(640, 480),
            'status' => 1,
            'published_at' => date('Y-m-d H:i:s'),
            'user_id' => 1
        ];
    }
}