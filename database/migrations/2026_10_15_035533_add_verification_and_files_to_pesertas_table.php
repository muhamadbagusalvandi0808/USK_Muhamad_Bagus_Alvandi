<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('ktp')->nullable()->after('alamat');
            $table->string('ijazah')->nullable()->after('ktp');
            $table->string('sertifikat')->nullable()->after('ijazah');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn(['ktp', 'ijazah', 'sertifikat', 'status_verifikasi']);
        });
    }
};