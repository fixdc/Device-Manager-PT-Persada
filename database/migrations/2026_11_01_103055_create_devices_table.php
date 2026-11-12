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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('kode_device')->unique(); // JenisBarang-Departemen-NoRandom
            $table->string('nama_device');
            $table->string('model')->nullable();
            $table->string('merek')->nullable();
            $table->foreignId('id_kategori')->constrained('device_categories');
            $table->string('nomor_seri')->nullable()->unique();
            $table->enum('status', ['aktif', 'perbaikan', 'rusak'])->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->datetime('tanggal_pengadaan')->nullable();
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('id_departemen')->constrained('departments');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
