<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['area_id', 'name', 'locale'];
}
