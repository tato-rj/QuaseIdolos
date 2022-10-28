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
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedSmallInteger('songs_limit')->nullable();
            $table->unsignedSmallInteger('songs_limit_per_user')->nullable();
            $table->boolean('is_live')->default(false);
            $table->date('date')->nullable();
            $table->boolean('is_paused')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
