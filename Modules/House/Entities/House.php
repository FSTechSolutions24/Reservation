<?php

namespace Modules\House\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\House\Database\Factories\HouseFactory;

class House extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'address', 'price'];

    // protected static function newFactory(): HouseFactory
    // {
    //     // return HouseFactory::new();
    // }
}
