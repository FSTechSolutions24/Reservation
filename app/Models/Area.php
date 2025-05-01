<?php

namespace App\Models;

use App\Models\AreaTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['city_id'];

    public function translations()
    {
        return $this->hasMany(AreaTranslation::class);
    }

    public function translation($locale = null)
    {
        return $this->hasOne(AreaTranslation::class)
            ->where('locale', $locale ?? app()->getLocale());
    }
}
