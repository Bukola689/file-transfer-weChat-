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
        return [
            'transfer_id' => \App\Models\FileTransfer::factory(),
            'name' => $this->faker->word . '.' . $this->faker->fileExtension,
            'path' => $this->faker->filePath(),
            'mime_type' => $this->faker->mimeType,
            'size' => $this->faker->numberBetween(1024, 10485760), // Size between 1KB and 10MB
        ];
    }
}
