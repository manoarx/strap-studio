<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Services extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'services';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'code',
        'short_title',
        'main_image',
        'portfolio_url',
        'created_at',
        'updated_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(500)->height(70);
        $this->addMediaConversion('medium')->width(800);
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

    public function ServicePackages()
    {
        return $this->belongsTo(ServicePackages::class, 'service_id');
    }

    public function ServicePackageAddons()
    {
        return $this->belongsTo(ServicePackageAddons::class, 'service_id');
    }

    public function ServicePackageOptions()
    {
        return $this->belongsTo(ServicePackageOptions::class, 'service_id');
    }
}
