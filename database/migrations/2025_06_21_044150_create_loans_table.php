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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique loan code
            $table->date('borrowed_at'); // tanggal_pinjam
            $table->date('due_at'); // tanggal_wajib_kembali
            $table->date('returned_at')->nullable(); // tanggal_dikembalikan
            $table->unsignedBigInteger('user_id'); // peminjam
            $table->decimal('fine', 10, 2)->default(0)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
