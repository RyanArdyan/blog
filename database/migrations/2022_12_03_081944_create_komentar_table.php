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
		Schema::create('komentar', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id');
			// unsigned berarti larang angka negatif
			// komentarable_id berisi value dari column id milik table postinngan yg sesuai
			$table->unsignedInteger('komentarable_id');
			// berisi App\Models\Posting
			$table->string('komentarable_type');
			// untuk menjalankan fitur balas
			// nullable karena value dari column parent_id akan berisi null jika dia merupakan sebuah komentar balasan
			// jika dia merupakan komentar balasan maka valuenya akan berisi column id milik table komentar yg sesuai
			$table->unsignedInteger('parent_id')->nullable();
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
		Schema::dropIfExists('komentar');
	}
};
