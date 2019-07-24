<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qurans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reciter_id');
            $table->string('surah', 45);
            $table->string('description')->default('');
            $table->string('mp3');
            $table->string('category', 21)->nullable();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 45);
        });

        Schema::create('quran_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('quran_id');
            $table->unsignedBigInteger('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qurans');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('quran_tag');
    }
}
