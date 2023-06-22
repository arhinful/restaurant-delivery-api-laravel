<?php

namespace App\Models;

use App\Traits\ModelBootingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes, ModelBootingTrait, HasSlug;

    protected $fillable = [
        'restaurant_id',
        'name',
        'price',
        'description',
    ];
}
