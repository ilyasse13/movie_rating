<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listadds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liste_id'); // Foreign key column
            $table->string('movie_id'); // Movie ID as a string
            $table->timestamps();
            
            // Define foreign key constraint
            $table->foreign('liste_id')
                  ->references('id')
                  ->on('listes')
                  ->onDelete('cascade'); // Cascade delete when a referenced liste is deleted
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listadds');
    }
};
