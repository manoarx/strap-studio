<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackageOptions extends Model
{
    use HasFactory;

    public $table = 'service_package_options';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'service_id',
        'service_package_id',
        'option_name',
        'option_price',
        'created_at',
        'updated_at',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function servicepackage()
    {
        return $this->belongsTo(ServicePackages::class, 'service_package_id');
    }
}
