<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * Define the relationship with the Listadd model.
     * Each Liste can have many Listadd entries (movies).
     */
    public function movies()
    {
        return $this->hasMany(Listadd::class, 'liste_id');
    }
}
