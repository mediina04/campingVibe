<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'camping_id',
        'type',
        'name',
        'price_per_night',
        'capacity',
        'description',
        
        
    ];

    public function camping()
    {
        return $this->belongsTo(Camping::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
