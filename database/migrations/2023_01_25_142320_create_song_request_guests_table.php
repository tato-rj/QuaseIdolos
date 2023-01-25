<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongRequestGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_request_guests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('song_request_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->unique(['song_request_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song_request_guests');
    }
}
