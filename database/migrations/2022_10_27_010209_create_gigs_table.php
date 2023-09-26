<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('venue_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('winner_id')->nullable();
            $table->unsignedSmallInteger('set_limit')->nullable();
            $table->unsignedSmallInteger('set_counter')->default(0);
            $table->unsignedSmallInteger('current_set_limit')->nullable();
            $table->boolean('set_is_full')->default(false);
            $table->unsignedSmallInteger('repeat_limit')->nullable();
            $table->unsignedSmallInteger('songs_limit')->nullable();
            $table->unsignedSmallInteger('songs_limit_per_user')->nullable();
            $table->boolean('has_ratings')->default(false);
            $table->boolean('participates_in_chat')->default(true);
            $table->boolean('is_live')->default(false);
            $table->date('scheduled_for')->nullable();
            $table->string('starting_time')->nullable();
            $table->boolean('is_paused')->default(false);
            $table->boolean('is_private')->default(false);
            $table->boolean('is_test')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->unsignedTinyInteger('duration')->nullable();
            $table->json('excluded_songs')->nullable();
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
        Schema::dropIfExists('gigs');
    }
}
