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
    Schema::create('repair_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_ticket')->unique()->constrained('tickets')->cascadeOnDelete();
        $table->text('tindakan')->nullable();
        $table->dateTime('tanggal_selesai')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('repair_histories');
}
};
