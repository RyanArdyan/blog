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
				$table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
				$table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete()->cascadeOnUpdate();
				$table->string('gambar');
				$table->string('judul')->unique();
				$table->string('slug')->unique();
				$table->text('isi');
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
