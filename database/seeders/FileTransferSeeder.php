<?php

namespace Database\Seeders;

use App\Models\FileTransfer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class FileTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileTransfer::factory()
            ->count(10)
            ->create();
    }
}
