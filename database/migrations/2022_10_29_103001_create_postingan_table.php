<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postingan', function (Blueprint $table) {
				// jangan lupa mengubah id menjadi postingan_id
            $table->id();
				$table->unsignedBigInteger('id_user');
				$table->unsignedBigInteger('id_kategori');

				// mengatur relasi
				$table->foreign('id_user')->references('users')->on('id');
				$table->foreign('id_kategori')->references('kategori')->on('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postingan');
    }
};
