<?php

namespace App\Models;

class Admin extends BaseModel
{
    protected $casts = ['super_admin' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grant(User $user, $super_admin = false)
    {
        return Admin::updateOrCreate([
            'user_id' => $user->id
        ], [
            'super_admin' => $super_admin
        ]);
    }

    public function revoke(User $user)
    {
        Admin::where('user_id', $user->id)->delete();
    }
}
