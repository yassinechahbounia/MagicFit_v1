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
        Schema::create('exercices', function (Blueprint $table) {
            $table->id();
        
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('muscle');
            $table->string('image')->nullable();
            
            // 🔴 clé étrangère bien formée
            $table->foreignId('programme_id')->nullable()->constrained()->onDelete('cascade');


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercices');
    }
};
