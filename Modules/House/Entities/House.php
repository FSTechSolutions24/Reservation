<?php

namespace Modules\House\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\House\Entities\HouseTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\House\Database\Factories\HouseFactory;

class House extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['gps_location', 'city_id', 'area_id', 'capacity'];

    public function translations()
    {
        return $this->hasMany(HouseTranslation::class);
    }

    public function translation($locale = null)
    {
        return $this->hasOne(HouseTranslation::class)
            ->where('locale', $locale ?? app()->getLocale());
    }
}
