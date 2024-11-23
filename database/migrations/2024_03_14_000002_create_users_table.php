<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_tlpn')->nullable();
            $table->string('asal_kampus')->nullable();
            $table->string('surat_kampus')->nullable();
            $table->string('surat_bakesbangpol')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('password');
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Buat foreign key dengan nama yang unik
            $table->foreign('divisi_id', 'users_divisi_foreign')
                ->references('id')
                ->on('divisis')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
