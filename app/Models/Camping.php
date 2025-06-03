<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camping extends Model
{
    // Tabla asociada (opcional si el nombre es 'campings')
    protected $table = 'campings';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'name',
        'location',
        'description',
        'rating_avg',
    ];

    // Casts para convertir automáticamente tipos al acceder
    protected $casts = [
        'rating_avg' => 'float',
        'images' => 'array',
    ];

    // Relación con el usuario creador (si aplica)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con reservas (si las hay)
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    public function accommodations()
    {
        return $this->hasMany(\App\Models\Accommodation::class);
    }
}
