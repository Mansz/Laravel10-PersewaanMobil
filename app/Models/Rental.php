<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'car_id', 'start_date', 'end_date']; // Ganti user_id menjadi customer_id

    public function customer()
    {
        return $this->belongsTo(Customer::class); // Ganti User menjadi Customer
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}