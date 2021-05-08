<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddBrainToToken
 */
class AddBrainToToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('personal_access_tokens', static function (Blueprint $table) {
            $table
                ->unsignedBigInteger('brain_id')
                ->index()
                ->default(1)
                ->after('abilities');

            $table
                ->foreign('brain_id')
                ->references('id')
                ->on('brains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', static function (Blueprint $table) {
            $table->dropForeign('personal_access_tokens_brain_id_foreign');
            $table->dropColumn('brain_id');
        });
    }
}
