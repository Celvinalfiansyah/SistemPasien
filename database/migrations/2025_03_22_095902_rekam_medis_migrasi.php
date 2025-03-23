<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_pasien'); 
            $table->date('tanggal_periksa');
            $table->string('diagnosa');
            $table->text('tindakan');
            $table->text('resep');
            $table->timestamps(); 

            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekam_medis');
    }
};
