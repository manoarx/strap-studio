<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;

    public $table = 'schools';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'school_name',
        'slug',
        'address',
        'email',
        'contact_number',
        'image',
        'created_at',
        'updated_at',
    ];

    public function student()
    {
        return $this->hasMany(Students::class, 'school_id');
    }

}
