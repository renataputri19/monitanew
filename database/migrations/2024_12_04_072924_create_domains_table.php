<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('domain'); // Domain name
            $table->string('aspek'); // Aspek name
            $table->string('indikator'); // Indikator name
            $table->json('files')->nullable(); // Store multiple files as JSON
            $table->integer('tingkat')->nullable(); // Tingkat (level/score)
            $table->boolean('disetujui')->default(false); // Approval status
            $table->timestamps(); // created_at and updated_at
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
