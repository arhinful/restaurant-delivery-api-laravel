<?php

namespace App\Models;

use App\Traits\ModelBootingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, ModelBootingTrait, SoftDeletes;

    protected $fillable = [
        'menu_item_id',
        'user_id',

        'quantity',
        'location',
        'gps',
        'mobile_number',
        'delivery_status',
        'payment_status',
        'payment_channel',
        'price',
    ];

    public function menuItem(): BelongsTo{
        return $this->belongsTo(MenuItem::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
