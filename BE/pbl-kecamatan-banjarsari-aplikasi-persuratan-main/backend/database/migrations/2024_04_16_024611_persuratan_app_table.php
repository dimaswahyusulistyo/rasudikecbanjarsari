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
        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->string('nama_pegawai');
            $table->integer('nip');
            $table->string('file_foto');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama_jabatan');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id('id_surat_masuk');
            $table->string('no_surat');
            $table->dateTime('tanggal_diterima');
            $table->dateTime('tanggal_agenda');
            $table->string('pengirim');
            $table->string('disposisi');
            $table->string('perihal');
            $table->string('isi_ringkas');
            $table->string('file_surat');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id('id_surat_keluar');
            $table->string('no_surat');
            $table->dateTime('tanggal_keluar');
            $table->string('tertuju_kepada');
            $table->string('perihal');
            $table->string('isi_ringkas');
            $table->string('file_surat');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('kategori_perihal', function (Blueprint $table) {
            $table->id('id_kp');
            $table->string('perihal');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('disposisi', function (Blueprint $table) {
            $table->id('id_disposisi');
            $table->string('id_pegawai');
            $table->string('pj_pegawai');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
