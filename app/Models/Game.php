<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Game extends Model
{
    use HasFactory;

    // Τα πεδία που μπορούν να αντιστοιχιστούν μέσω μαζικής αναθέσεως
    protected $fillable = ['title', 'description', 'release_date', 'genre', 'user_id'];

    // Σχέση "ανήκει σε" (belongsTo) για το User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}