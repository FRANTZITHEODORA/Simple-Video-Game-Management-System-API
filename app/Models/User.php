<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Game; // ✅ Πρόσθεσε αυτό για να αναγνωρίζει το Game model

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Τα πεδία που μπορούν να αντιστοιχιστούν μέσω μαζικής αναθέσεως
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Τα πεδία που πρέπει να κρύβονται στη διαδικασία σειριοποίησης
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Τα πεδία που πρέπει να μετατραπούν σε τύπους δεδομένων
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Σχέση με το Game model (ένα προς πολλά)
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}