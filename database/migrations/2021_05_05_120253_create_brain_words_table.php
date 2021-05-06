<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrainWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'brain_word',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('brain_id')->index();
                $table->unsignedBigInteger('word_id')->index();
                $table->timestamps();

                $table->foreign('brain_id')->references('id')->on('brains');
                $table->foreign('word_id')->references('id')->on('words');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brain_words');
    }
}
