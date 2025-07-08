<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file_transfer_id' => \App\Models\FileTransfer::factory(),
            'email' => $this->faker->unique()->safeEmail,
            'has_downloaded' => $this->faker->boolean(50), // 50% chance of being true
            // Additional fields can be added here if needed
            // 'status' => 'pending', // Example of a default status
            // 'downloaded_at' => null, // Example of a default downloaded_at value
            // 'expires_at' => now()->addDays(7), // Example of a default expiration date
            // 'notification_sent' => false, // Example of a default notification sent status
        ];
    }
}
