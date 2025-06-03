<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'password',
        'surname1'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // --- Relaciones necesarias ---

    public function reservations()
    {
        // Ajusta el modelo y la clave foránea según tu estructura
        return $this->hasMany(\App\Models\Reservation::class, 'user_id');
    }

    public function reviews()
    {
        // Ajusta el modelo y la clave foránea según tu estructura
        return $this->hasMany(\App\Models\Review::class, 'user_id');
    }

    // --- Otros métodos existentes ---

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/users')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        if (env('RESIZE_IMAGE') === true) {
            $this->addMediaConversion('resized-image')
                ->width(env('IMAGE_WIDTH', 300))
                ->height(env('IMAGE_HEIGHT', 300));
        }
    }

    // --- Accesor para mostrar un solo apellido si lo necesitas en el frontend ---
    public function getSurnameAttribute()
    {
        // Devuelve ambos apellidos juntos, o solo uno si falta el otro
        return trim($this->surname1 . ' ' . $this->surname2);
    }
}
