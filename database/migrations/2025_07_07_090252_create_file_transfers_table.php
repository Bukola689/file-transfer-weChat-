<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('sender_email');
            $table->string('subject');
            $table->text('message')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('expires_at');
            $table->integer('download_limit')->default(0)->nullable();
            $table->integer('downloads')->default(0);
            $table->boolean('notify_on_download')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_transfers');
    }
}
