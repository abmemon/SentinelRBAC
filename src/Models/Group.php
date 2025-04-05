<?php

namespace ABMemon\SentinelRBAC\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'));
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
