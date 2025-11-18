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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->date('tanggal_lahir')->nullable();

            // Relasi poli
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');

            $table->text('keluhan')->nullable();
            $table->enum('jenis_pembayaran', ['bpjs', 'umum']);

            $table->integer('nomor_antrian');

            // untuk estimasi waktu panggilan
            $table->timestamp('estimasi_waktu')->nullable();

            // status antrian: menunggu / dipanggil / selesai
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
