<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{

    protected $fillable = [
        'deliveryDescription',
        'weightQuantity',
        'totalWeightPrice',
        'totalDistancePrice',
        'totalDeliveryPrice',
        'pickedFromX',
        'pickedFromY',
        'destinationX',
        'destinationY',
        'scheduledDeliveryDate',
        'paymentMethod',
        'discount',
        'deliveredTo',
        'deliveredBy',
    ];
//    public function users() {
//        return $this->belongsTo(User::class, "user_id", "id");
//    }

    public function deliveredToUser() {
        return $this->belongsTo(User::class, 'deliveredTo');
    }

    public function deliveredByUser() {
        return $this->belongsTo(User::class, 'deliveredBy');
    }

//    public function requests() {
//        return $this->hasMany(Request::class, "delivery_id", "id");
//    }


    public function request() {
        return $this->hasOne(Request::class, "delivery_id", "id");
    }


    public function statuses() {
        return $this->hasOne(Status::class, "delivery_id", "id");
    }
}
