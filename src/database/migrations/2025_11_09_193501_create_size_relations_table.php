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
        Schema::create('size_relations', function (Blueprint $table) {
            $table->id();
            $table->string('sizeGroupCode');
            $table->string('sizeCode');
            $table->timestamps();
            $table->foreign('sizeGroupCode')->references('sizeGroupCode')->on('size_groups')->onDelete('no action');
            $table->foreign('sizeCode')->references('sizeCode')->on('sizes')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_relations');
    }
};
