<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, "role_id", "id");
    }
}
//a user can have one role
//a role belong to many user
