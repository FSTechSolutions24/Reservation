<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'enabled'];

    public function scopeInstalledByName($query, $name)
    {
        return $query->where('name', $name)->where('enabled', 1);
    }

    public function scopeUninstalledByName($query, $name)
    {
        return $query->where('name', $name)->where('enabled', 0);
    }

}
