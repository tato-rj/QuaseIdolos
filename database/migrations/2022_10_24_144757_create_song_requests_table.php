<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_requests', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->unsignedInteger('gig_id')->nullable();
            $table->unsignedInteger('song_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->boolean('was_recommended')->default(false);
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
        Schema::dropIfExists('song_requests');
    }
}
