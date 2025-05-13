<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('no_telepon', 15)->unique();
            $table->timestamp('tanggal_daftar')->default(now());
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('pasien');
    }
};
