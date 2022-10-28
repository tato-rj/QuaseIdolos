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
            $table->unsignedInteger('artist_id');
            $table->string('name');
            $table->string('tags')->nullable();
            $table->text('lyrics');
            $table->unsignedTinyInteger('duration');
            $table->string('level');
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
