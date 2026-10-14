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
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('id');
            $table->enum('jk', ['Laki-laki', 'Perempuan'])->nullable()->after('nama');
            $table->string('telp', 15)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn(['nik', 'jk', 'telp']);
        });
    }
};