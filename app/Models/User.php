<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /* Relacionamento de USER(PROPRIETÀRIO) com EVENTOS: */
    /* No plural, porque os USERS podem ser proprietários de vários eventos. */
    /* Relacionamento ONE to MANY */
    public function events()
    {  /* Um USER(PROPRIETÀRIO) pode ter vários eventos */
        return $this->hasMany('App\Models\Event');
    }

    /* Relacionamento de USERS com EVENTOS: */
    /* No plural, porque os USERS podem ter vários EVENTOS. */
    public function eventsAsParticipant()
    {  /* Um USER pode ter vários EVENTOS */
        return $this->belongsToMany('App\Models\Event');
    }
}
