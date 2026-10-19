<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveCardapioIndexes extends Migration
{
    protected $indexes = [
        'song_requests' => [
            ['gig_id', 'finished_at', 'order'],
            ['gig_id', 'user_id', 'song_id', 'created_at'],
            ['gig_id', 'song_id'],
            ['user_id', 'finished_at'],
            ['song_id'],
        ],
        'participants' => [['user_id', 'gig_id']],
        'sets' => [['gig_id', 'created_at']],
        'invitations' => [['user_id', 'confirmed_at']],
        'favorites' => [['user_id', 'created_at']],
        'ratings' => [['song_request_id']],
        'songs' => [['genre_id']],
        'gig_users' => [['gig_id', 'user_id']],
    ];

    public function up()
    {
        foreach ($this->indexes as $table => $indexes) {
            Schema::table($table, function (Blueprint $table) use ($indexes) {
                foreach ($indexes as $columns)
                    $table->index($columns);
            });
        }
    }

    public function down()
    {
        foreach ($this->indexes as $table => $indexes) {
            Schema::table($table, function (Blueprint $table) use ($indexes) {
                foreach ($indexes as $columns)
                    $table->dropIndex($columns);
            });
        }
    }
}
