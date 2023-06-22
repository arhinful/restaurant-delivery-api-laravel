<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;

trait ModelBootingTrait
{
    protected static function bootModelBootingTrait()
    {
        static::creating(function ($model){
            $model->added_by_id = auth()->check() ? auth()->user()->id : null;
            $model->uuid = Str::uuid()->toString();
            $model->code = generateUniqueNumber(get_called_class());
        });
        static::addGlobalScope('active', function (Builder $builder){
            $builder->whereIsActive(true);
        });
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id', 'id');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function formattedCreatedAt() : Attribute {
        return new Attribute(
            get: fn() => date('D, jS M Y',strtotime($this->created_at)),
        );
    }

    public function addedByName() : Attribute {
        return new Attribute(
            get: fn() => $this->addedBy ? $this->addedBy->name : '',
        );
    }

}


