<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_relations', function (Blueprint $table) {
            $table->id();
            $table->string('colorGroupCode');
            $table->string('colorCode');
            $table->timestamps();

            $table->foreign('colorGroupCode')
                ->references('colorGroupCode')
                ->on('color_groups')
                ->onDelete('no action');

            $table->foreign('colorCode')
                ->references('colorCode')
                ->on('colors')
                ->onDelete('no action');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_relations');
    }
};
