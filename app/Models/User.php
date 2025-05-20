<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';

    protected $fillable = [
        'userName',
        'email',
        'password',
        'phoneNumber',
        'role_id',
        'vehicleType',
        'vehicleModel',
        'plateNumber',
        'startShift',
        'endShift',
        'gotRegistered',
        'email_verified_at', 'otp_code', 'otp_expires_at',

    ];





    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function roles()
    {
        return $this->belongsTo(Role::class, "role_id", "id");
    }

    public function getTotalDeliveryPriceAttribute()
    {
        return $this->deliveriesReceived->sum('totalDeliveryPrice');
    }

    public function getTotalDeliveryPriceAttributeDriver()
    {
        return $this->deliveriesMade->sum('totalDeliveryPrice');
    }
    public function cities() {
        return $this->belongsToMany(City::class, "user_cities",
            "user_id", "city_id");
    }

  /*  public function priceStructure() {
        return $this->hasMany(PriceStructure::class, "user_id", "id");
    }*/

    public function priceStructure()
    {
        return $this->hasOne(PriceStructure::class, "user_id", "id");
    }

//    public function deliveries() {
//        return $this->hasMany(Delivery::class, "user_id", "id");
//    }

    public function deliveriesReceived() {// for the client
        return $this->hasMany(Delivery::class, "deliveredTo", "id");
    }

    public function deliveriesMade() {// for the driver
        return $this->hasMany(Delivery::class, "deliveredBy", "id");
    }


    public function reviews() {
        return $this->hasMany(Review::class, "driver_id", "id");
    }

    public function avgReviews() {
        return $this->reviews()->avg("rating");
    }



    public function writtenReviews() {
        return $this->hasMany(Review::class, "client_id", "id");
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
