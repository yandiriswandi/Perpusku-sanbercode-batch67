<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Primary key: book ID
            $table->string('title'); // Book title
            $table->string('code')->unique(); // Book title
            $table->string('author')->nullable(); // Author name
            $table->string('publisher')->nullable(); // Publisher name
            $table->year('year_published')->nullable(); // Year of publication
            $table->string('isbn')->unique()->nullable(); // ISBN number
            $table->unsignedBigInteger('category_id'); // Foreign key to categories
            $table->unsignedBigInteger('shelf_id')->nullable();    // Foreign key to shelves
            $table->integer('stock')->default(0); // Number of copies available
            $table->text('description')->nullable(); // Optional book description
            $table->string('cover_image')->nullable(); // Path to book cover image
            // $table->unsignedBigInteger('created_by')->nullable(); // Path to book cover image
            // $table->unsignedBigInteger('updated_by')->nullable(); // Path to book cover image
            $table->timestamps();
            // Define foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('shelf_id')->references('id')->on('shelfs')->onDelete('set null');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
