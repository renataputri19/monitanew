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
        Schema::create('files', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('domain_id'); // Foreign key to domains table
            $table->string('file_path'); // File path
            $table->boolean('hasil')->default(false); // Approval status
            $table->text('reasons')->nullable(); // Reasons for approval/rejection
            $table->timestamps(); // For 'Last Updated'
    
            // Foreign key constraint
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
