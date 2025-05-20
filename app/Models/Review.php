<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['rating', 'ReviewDescription', 'driver_id', 'client_id'];

   
    
    
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', "id");  
    }
 
  public function client()
  {
      return $this->belongsTo(User::class, 'client_id', "id"); 
  }
   
}
