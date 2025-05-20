<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{

    protected $fillable = ['delivery_id', 'requestStatus'];

    public function delivery() {
        return $this->belongsTo(Delivery::class, "delivery_id", "id");
    }
}
