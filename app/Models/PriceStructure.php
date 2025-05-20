<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceStructure extends Model
{   
    protected $fillable = [
        'user_id',
        'fixedDistancePrice',
        'distancePerKm',
        'distancePrice',
        'weightQuantity', 'weightPrice',
    ];

    public function users() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}

