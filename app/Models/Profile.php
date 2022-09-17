<?php

namespace App\Models;

use App\Enums\UserGenders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name',  'phone_number', 'address', 'birthday', 'gender', 'user_id'
    ];

    protected $casts = [
        'birthday' => 'datetime',
        'gender' => UserGenders::class,
    ];

    /*
   |------------------------------------------------------------------|
   |Relations
   |------------------------------------------------------------------|
   */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}

