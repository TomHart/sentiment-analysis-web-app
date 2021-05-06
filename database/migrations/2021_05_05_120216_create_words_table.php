<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TomHart\SentimentAnalysis\Analyser\Analyser;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {

            $table->id();
            $table->string('word', 255);
            $table->enum('sentiment', Analyser::VALID_TYPES)->index();
            $table->unsignedBigInteger('sentence_id')->index();
            $table->timestamps();

            $table->foreign('sentence_id')->references('id')->on('sentences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('words');
    }
}
