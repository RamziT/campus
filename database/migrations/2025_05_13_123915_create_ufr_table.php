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
        Schema::create('ufr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universite_id')->constrained('universites')->onDelete('cascade')->onUpdate('cascade');
            $table->string('libelle');
            $table->string('abreviation')->nullable();
            $table->string('responsable_id')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->enum('statut', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

            $table->unique(['libelle', 'universite_id', 'statut']);
            $table->unique(['abreviation', 'universite_id', 'statut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ufrs');
    }
};
