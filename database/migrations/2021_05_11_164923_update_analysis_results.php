<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class UpdateAnalysisResults
 */
class UpdateAnalysisResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('analysis_results', static function (Blueprint $table) {
            $table->dropForeign('analysis_results_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('analysis_results', static function (Blueprint $table) {
            $table->unsignedBigInteger('brain_id')->index()->after('sentence')->default(3);
            $table->foreign('brain_id')->references('id')->on('brains');

            $table->dropColumn('accuracy');
            $table->float('positive_accuracy', 20, 10)->default(0)->after('result');
            $table->float('negative_accuracy', 20, 10)->default(0)->after('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('analysis_results', static function (Blueprint $table) {
            $table->dropForeign('analysis_results_brain_id_foreign');
            $table->dropColumn('brain_id');
        });

        Schema::table('analysis_results', static function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->after('sentence')->default(1);
            $table->foreign('user_id')->references('id')->on('users');

            $table->dropColumn('positive_accuracy');
            $table->dropColumn('negative_accuracy');
            $table->float('accuracy')->after('result');
        });
    }
}
