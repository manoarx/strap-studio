<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Students extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'students';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'school_id',
        'user_id',
        'student_name',
        'student_last_name',
        'classe',
        'father_name',
        'last_father_name',
        'addresse_email',
        'mother_email',
        'telephone_mobile',
        'image',
        'year',
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

    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'student_id');
    }
}
