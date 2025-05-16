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
        Schema::create('diplomes', function (Blueprint $table) {
            $table->id();
            $table->enum('libelle', ['Baccaulérat', 'Licence', 'Licence Professionnelle', 'Master', 'Doctorant']);
            $table->string('abreviation')->nullable();
            $table->string('serie')->nullable();
            $table->string('specialite')->nullable();
            $table->string('option')->nullable();
            $table->enum('statut', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

            $table->unique(['libelle', 'serie', 'statut']);
            $table->unique(['libelle', 'specialite', 'statut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diplomes');
    }
};
