<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioVideos extends Model
{
    use HasFactory;

    public $table = 'portfolio_videos';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'video',
        'created_at',
        'updated_at',
    ];

}
