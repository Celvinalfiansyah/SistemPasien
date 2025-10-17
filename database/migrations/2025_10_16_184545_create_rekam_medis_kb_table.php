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
        Schema::create('rekam_medis_kb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->date('tanggal_datang');
            $table->date('hpht')->nullable();
            $table->float('berat_badan')->nullable();
            $table->string('tensi')->nullable();
            $table->text('komplikasi')->nullable();
            $table->text('kegagalan')->nullable();
            $table->text('pemeriksaan_dan_tindakan')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis_kb');
    }
};
