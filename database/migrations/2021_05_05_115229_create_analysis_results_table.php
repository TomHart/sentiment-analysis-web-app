<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TomHart\SentimentAnalysis\Analyser\Analyser;

/**
 * Class CreateAnalysisResultsTable
 */
class CreateAnalysisResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'analysis_results',
            function (Blueprint $table) {
                $table->id();
                $table->text('sentence');
                $table->unsignedBigInteger('brain_id')->index();
                $table->enum('result', Analyser::VALID_TYPES)->index();
                $table->float('positive_accuracy', 20, 10)->default(0);
                $table->float('negative_accuracy', 20, 10)->default(0);
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
    public function down(): void
    {
        Schema::dropIfExists('analysis_results');
    }
}
