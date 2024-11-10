<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;


    // Allow mass assignment for user_id and movie_id
    protected $fillable = ['user_id', 'movie_id'];
}
