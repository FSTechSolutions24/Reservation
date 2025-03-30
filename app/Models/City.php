<?php

namespace App\Models;

use App\Models\CityTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{

    use HasFactory;
    
    protected $fillable = [];

    public function translations()
    {
        return $this->hasMany(CityTranslation::class);
    }

    public function translation($locale = null)
    {
        return $this->hasOne(CityTranslation::class)
            ->where('locale', $locale ?? app()->getLocale());
    }
}
