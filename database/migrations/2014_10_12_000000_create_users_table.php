<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->string('password')->nullable();
            $table->string('locale')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('has_ratings')->default(true);
            $table->boolean('participates_in_chat')->default(true);
            // FOR TESTING ONLY
            $table->text('liveGig')->nullable();
            // SOCIALMEDIA
            $table->text('avatar_url')->nullable();
            // $table->string('social_id')->nullable();
            // $table->string('social_token')->nullable();
            // $table->string('social_refresh_token')->nullable();
            // SOCIALMEDIA
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
