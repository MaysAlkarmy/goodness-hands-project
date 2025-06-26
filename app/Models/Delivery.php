<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable= ['governorate', 'city', 'street', 'building_number', 'delivery_time'];


    protected $table= 'info_delivery';

    public function user()
{
    return $this->belongsTo(User::class);
}
}
