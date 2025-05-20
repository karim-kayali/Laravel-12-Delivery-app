<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $fillable = ['delivery_id', 'deliveryStatus', 'token'];

    public function deliveries() {
        return $this->belongsTo(Delivery::class, "delivery_id", "id");
    }
}
