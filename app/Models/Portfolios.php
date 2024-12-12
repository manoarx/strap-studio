<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Portfolios extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'portfolios';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'type',
        'slug',
        'created_at',
        'updated_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(280)->height(190);
        $this->addMediaConversion('medium')->width(800);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('videos');
    }

    public function getPhotosAttribute()
    {
        $files = $this->getMedia('photos');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
        });

        return $files;
    }

    public function getVideosAttribute()
    {
        $files = $this->getMedia('videos');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
        });

        return $files;
    }

    public function portfolioVideos()
    {
        return $this->belongsTo(PortfolioVideos::class, 'portfolio_id');
    }
}
