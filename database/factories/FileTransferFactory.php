<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileTransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null, // Assuming user_id can be null
            'sender_email' => $this->faker->safeEmail,
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
            'password' => $this->faker->optional()->password,
            'expires_at' => now()->addDays(7), // Default to 7 days from now
            'download_limit' => $this->faker->optional()->numberBetween(1, 10),
            'notify_on_download' => $this->faker->boolean(50), // 50% chance of being true
        ];
    }
}
