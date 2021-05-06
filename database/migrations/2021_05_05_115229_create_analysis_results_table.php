<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TomHart\SentimentAnalysis\Analyser\Analyser;

class CreateAnalysisResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'analysis_results',
            function (Blueprint $table) {
                $table->id();
                $table->text('sentence');
                $table->unsignedBigInteger('user_id')->index();
                $table->enum('result', Analyser::VALID_TYPES)->index();
                $table->float('accuracy');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('analysis_results');
    }
}
