<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('venue_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_live')->default(false);
            $table->date('scheduled_for')->nullable();
            $table->string('starting_time')->nullable();
            $table->boolean('is_paused')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->unsignedTinyInteger('duration')->nullable();
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
        Schema::dropIfExists('shows');
    }
}
