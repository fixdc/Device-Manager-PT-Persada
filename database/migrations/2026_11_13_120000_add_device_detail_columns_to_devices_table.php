<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table): void {
            if (! Schema::hasColumn('devices', 'merek')) {
                $table->string('merek')->nullable();
            }

            if (! Schema::hasColumn('devices', 'model')) {
                $table->string('model')->nullable();
            }

            if (! Schema::hasColumn('devices', 'tanggal_pengadaan')) {
                $table->dateTime('tanggal_pengadaan')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Keep these columns on rollback: they may have existed before this
        // migration in databases created from the current base migration.
    }
};
