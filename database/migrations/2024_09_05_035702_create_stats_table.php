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
        Schema::create('stats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('min');
            $table->integer('pts');
            $table->integer('reb');
            $table->integer('ast');
            $table->integer('blk');
            $table->integer('stl');
            $table->timestamps();

            $table->foreignUuid('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreignUuid('match_team_id')->references('id')->on('match_team')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
