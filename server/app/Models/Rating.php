<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'movie_id', 'rate'];

    // Define the relationship to the User model (a rating belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
