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
        Schema::create('siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->string('nis');
            $table->string('nama');
            $table->string('domisili');
            $table->longText('alamat');
            $table->string('agama');
            $table->string('ttl');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('anak_ke');
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
