<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');

            // Data pemeriksaan
            $table->date('tanggal_pemeriksaan');
            $table->string('umur')->nullable(); // disimpan agar tetap konsisten per pemeriksaan
            $table->float('berat_badan')->nullable();
            $table->float('tinggi_badan')->nullable();

            // Klasifikasi pasien
            $table->enum('klasifikasi', ['Ibu Hamil', 'Bayi/Anak', 'KB', 'Rawat Jalan']);

            // Pemeriksaan lanjutan
            $table->string('ttv')->nullable();
            $table->string('hpht')->nullable();
            $table->text('anamnesa')->nullable();
            $table->text('keluhan')->nullable();
            $table->string('komplikasi')->nullable();
            $table->string('kegagalan')->nullable();
            $table->text('tindakan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekam_medis');
    }
};
//