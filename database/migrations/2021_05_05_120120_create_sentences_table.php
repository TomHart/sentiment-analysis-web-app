<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TomHart\SentimentAnalysis\Analyser\Analyser;

class CreateSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'sentences',
            function (Blueprint $table) {
                $table->id();
                $table->text('sentence');
                $table->enum('sentiment', Analyser::VALID_TYPES)->index();
                $table->unsignedBigInteger('brain_id')->index();
                $table->timestamps();

                $table->foreign('brain_id')->references('id')->on('brains');
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
        Schema::dropIfExists('sentences');
    }
}
