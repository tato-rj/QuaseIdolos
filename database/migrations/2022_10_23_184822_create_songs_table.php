<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->nullable();
            $table->unsignedInteger('artist_id');
            $table->unsignedInteger('genre_id');
            $table->string('drum_score_path')->nullable();
            $table->string('name');
            $table->unsignedSmallInteger('bpm')->nullable();
            $table->unsignedSmallInteger('time_signature')->nullable();
            $table->text('preview_url')->nullable();
            $table->text('lyrics')->nullable();
            $table->unsignedTinyInteger('duration')->nullable();
            $table->text('chords_url')->nullable();
            $table->timestamps();

            $table->unique(['artist_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
