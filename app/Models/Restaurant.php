<?php

namespace App\Models;

use App\Traits\ModelBootingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, ModelBootingTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'location'
    ];

    public function menuItems(): HasMany{
        return $this->hasMany(MenuItem::class);
    }

    public function orders(): HasManyThrough{
        return $this->hasManyThrough(Order::class, MenuItem::class);
    }
}
