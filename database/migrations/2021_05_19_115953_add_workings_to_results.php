<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddWorkingsToResults
 */
class AddWorkingsToResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('analysis_results', static function (Blueprint $table) {
            $table->json('workings')->after('positive_accuracy');
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
            $table->dropColumn('workings');
        });
    }
}
