<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('supply_date')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('material')->nullable();
            $table->string('physical_shape')->nullable();
            $table->string('title');
            $table->string('author');
            $table->string('edition')->nullable();
            $table->string('publication_place')->nullable();
            $table->string('publisher')->nullable();
            $table->year('year')->nullable();
            $table->string('physical_description')->nullable();
            $table->string('acquisition_source')->nullable();
            $table->string('acquisition_name')->nullable();
            $table->string('isbn')->unique()->nullable();
            $table->string('price')->nullable();
            $table->string('language')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
        });

        Schema::create('book_category', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['book_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_category');
    }
};
