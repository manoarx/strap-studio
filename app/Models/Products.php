<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Products extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'student_id',
        'school_id',
        'title',
        'slug',
        'hard_copy_amount',
        'digital_title',
        'digital_amount',
        'desc',
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

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
