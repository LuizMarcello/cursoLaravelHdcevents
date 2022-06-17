<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $casts = ['items' => 'array'];

    protected $dates = ['date'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'user_id', 'description', 'city', 'private', 'image', 'items', 'date'];

    /* Ao contrário do $fillable acima, desta maneira todos os campos poderão ser alterados */
    /* protected $guarded = [];
    */

    /* Relacionamento de EVENTOS com USER( PROPRIETÀRIO ): */
    /* No singular, porque os EVENTOS podem ter um só USER( PROPRIETÀRIO ) */

    public function user()
    {
        /* Um EVENTO pertence a um USER( PROPRIETÀRIO ) */
        return $this->BelongsTo('App\Models\User');
    }

    /* Relacionamento de EVENTOS com USERS: */
    /* No plural, porque os EVENTOS podem ter vários USERS */
    /* Relacionamento MANY to MANY */
    public function users()
    {
        /* Um EVENTO pode ter vários USERS */
        return $this->belongsToMany('App\Models\User');
    }
}






