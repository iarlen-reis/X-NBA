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
        Schema::create('averages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('min', total: 8, places: 2);
            $table->decimal('pts', total: 8, places: 2);
            $table->decimal('reb', total: 8, places: 2);
            $table->decimal('ast', total: 8, places: 2);
            $table->decimal('stl', total: 8, places: 2);
            $table->decimal('blk', total: 8, places: 2);
            $table->uuid('player_id');
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('averages');
    }
};
