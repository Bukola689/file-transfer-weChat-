<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       $filepath = storage_path('app/public/files');

        return [
            'file_transfer_id' => \App\Models\FileTransfer::factory(),
            'name' => $this->faker->word . '.' . $this->faker->fileExtension,
            'path' => '/storage/uploads/' . $this->faker->uuid() . '.jpg', // Example path, adjust as needed
            'mime_type' => $this->faker->mimeType,
            'size' => $this->faker->numberBetween(1024, 10485760), // Size between 1KB and 10MB
        ];
    }
}
