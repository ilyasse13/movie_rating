<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listadd extends Model
{
    use HasFactory;

    protected $fillable = [
        'liste_id',
        'movie_id',
    ];

    /**
     * Define the relationship with the Liste model.
     * Each Listadd belongs to one Liste.
     */
    public function liste()
    {
        return $this->belongsTo(Liste::class, 'liste_id');
    }
}
