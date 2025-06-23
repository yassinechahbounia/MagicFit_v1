<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::create('suivis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relation utilisateur
        $table->date('date');
        $table->integer('poids')->nullable(); // ou float si nécessaire
        $table->integer('repetitions');
        $table->text('commentaire')->nullable();
        $table->timestamps();
    });
        
    }

    public function down(): void {
        Schema::dropIfExists('suivis');

        Schema::table('suivis', function (Blueprint $table) {
            $table->dropColumn('poids');
        });
    }
};

