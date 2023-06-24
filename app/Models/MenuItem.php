<?php

namespace App\Models;

use App\Traits\ModelBootingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;

class MenuItem extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, ModelBootingTrait, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'restaurant_id',
        'name',
        'price',
        'description',
    ];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('image')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')
            ->performOnCollections('image')
            ->fit(Manipulations::FIT_STRETCH, 200, 200)->sharpen(10);
    }

    public function restaurant(): BelongsTo{
        return  $this->belongsTo(Restaurant::class);
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class);
    }
}
