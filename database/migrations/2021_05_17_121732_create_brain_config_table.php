<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateBrainConfigTable
 */
class CreateBrainConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('brain_config', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brain_id')->index();
            $table->unsignedBigInteger('setting_id')->index();
            $table->text('value');

            $table->timestamps();

            $table->foreign('brain_id')->references('id')->on('brains');
            $table->foreign('setting_id')->references('id')->on('brain_config_settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('brain_config');
    }
}
