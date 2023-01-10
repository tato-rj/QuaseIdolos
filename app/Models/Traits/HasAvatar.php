<?php

namespace App\Models\Traits;

trait HasAvatar
{
    public function coverImage($name = 'image_path')
    {
        return asset('storage/' . $this->$name);
    }
}
