<?php

namespace Database\Seeders;

use App\Models\Brain;
use Illuminate\Database\Seeder;

class DefaultBrain extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Brain())->where('name', 'Default Brain')->firstOrCreate(
            [
                'name' => 'Default Brain'
            ]
        );
    }
}
