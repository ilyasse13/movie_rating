<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Liste extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id', 'uuid'];

    // Automatically generate UUID during creation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($liste) {
            $liste->uuid = (string) Str::uuid(); // Generate UUID
        });
    }
    /**
     * Define the relationship with the Listadd model.
     * Each Liste can have many Listadd entries (movies).
     */
    public function movies()
    {
        return $this->hasMany(Listadd::class, 'liste_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
