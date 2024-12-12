<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackageAddons extends Model
{
    use HasFactory;

    public $table = 'service_package_addons';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'service_id',
        'service_package_id',
        'addon_name',
        'addon_price',
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
