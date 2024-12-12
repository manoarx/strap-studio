<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackages extends Model
{
    use HasFactory;

    public $table = 'service_packages';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'service_id',
        'package_name',
        'about_package',
        'price',
        'duration',
        'most_liked',
        'created_at',
        'updated_at',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function packageaddons()
    {
        return $this->hasMany(ServicePackageAddons::class, 'service_package_id');
    }

    public function packageoptions()
    {
        return $this->hasMany(ServicePackageOptions::class, 'service_package_id');
    }
}
