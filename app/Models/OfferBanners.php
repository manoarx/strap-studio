<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferBanners extends Model
{
    use HasFactory;

    public $table = 'offer_banners';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'image',
        'created_at',
        'updated_at',
    ];
}
