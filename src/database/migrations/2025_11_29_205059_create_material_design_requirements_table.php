<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_design_requirements', function (Blueprint $table) {
            $table->id();

            $table->string('colorCode');
            $table->string('colorGroupCode');

            $table->string('sizeCode');
            $table->string('sizeGroupCode');

            $table->boolean('status')->default(true);

            $table->string('providerCode')->nullable();
            $table->string('providerName')->nullable();

            $table->timestamps();

            // 外键（完全照搬你 size/color 的风格）
            $table->foreign('colorCode')
                ->references('colorCode')
                ->on('colors')
                ->onDelete('no action');

            $table->foreign('colorGroupCode')
                ->references('colorGroupCode')
                ->on('color_groups')
                ->onDelete('no action');

            $table->foreign('sizeCode')
                ->references('sizeCode')
                ->on('sizes')
                ->onDelete('no action');

            $table->foreign('sizeGroupCode')
                ->references('sizeGroupCode')
                ->on('size_groups')
                ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_design_requirements');
    }
};
