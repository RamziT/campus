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
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->enum('libelle', ['Licence 1',  'Licence 2',  'Licence 3',  'Master 1',  'Master 2', 'Doctorat 1', 'Doctorat 2', 'Doctorat 3']);
            $table->enum('abreviation', ['L1', 'L2', 'L3', 'M1', 'M2',  'D1', 'D2', 'D3'])->nullable();
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveaux');
    }
};
