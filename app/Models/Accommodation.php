<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'camping_id',
        'name',
        'description',
        'price',
        'type'
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
