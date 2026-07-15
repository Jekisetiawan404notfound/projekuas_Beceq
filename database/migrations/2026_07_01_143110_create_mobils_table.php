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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id('id_mobil');
            $table->unsignedBigInteger('id_kategori');
            $table->string('merek');
            $table->string('model');
            $table->integer('harga');
            $table->integer('stok');
            $table->timestamps();
            
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_mobils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
