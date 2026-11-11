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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('lantai')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // users dibuat lebih dulu, jadi FK-nya dipasang di sini
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_departemen')->references('id')->on('departments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_departemen']);
        });
        Schema::dropIfExists('departments');
    }
};
