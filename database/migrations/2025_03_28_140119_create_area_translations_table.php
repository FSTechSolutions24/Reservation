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
        Schema::create('area_translations', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->string('locale', 5)->index();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('area_translations', function (Blueprint $table) {
            //
        });
    }
};
