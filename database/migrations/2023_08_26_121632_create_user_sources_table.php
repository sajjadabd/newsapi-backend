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
        Schema::create('user_sources', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('source_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            /*
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('source_id');
            $table->foreign('source_id')->refrences('id')->on('sources');
            $table->timestamps();
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sources');
    }
};
