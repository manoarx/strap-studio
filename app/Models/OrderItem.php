<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    
    public function product(){
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function workshop(){
        return $this->belongsTo(Workshops::class,'product_id','id');
    }

    public function servicepackage(){
        return $this->belongsTo(ServicePackages::class,'product_id','id');
    }

    public function studiorental(){
        return $this->belongsTo(StudioRentals::class,'product_id','id');
    }

    public function option(){
        return $this->belongsTo(ServicePackageOptions::class,'option_id','id');
    }

    public function addon(){
        return $this->belongsTo(ServicePackageAddons::class,'addon_id','id');
    }
}
