<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class IndexWordsTable
 */
class IndexWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('words', static function (Blueprint $table) {
            $table->index('word');
            $table->index(['word', 'sentiment'], 'word_sentiment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('words', static function (Blueprint $table) {
            $table->dropIndex('words_word_index');
            $table->dropIndex('word_sentiment');
        });
    }
}
