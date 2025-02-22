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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
			// $table->string('path');
			$table->bigInteger('user_id');
			$table->bigInteger('folder_id')->nullable();
			$table->string('type', 10)->nullable();
			$table->string('extension', 10);
			$table->integer('size')->nullable();
			$table->string('original_file', 255);
			$table->text('image_variants')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
