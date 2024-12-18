<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::updateOrCreate(
            ['key_' => 'SEGMENTATION_BATCH'],
            [
                'key_' => 'SEGMENTATION_BATCH',
                'value' => 1,
            ]
        );
        Config::updateOrCreate(
            ['key_' => 'SEGMENTATION_BATCH_DELAY'],
            [
                'key_' => 'SEGMENTATION_BATCH_DELAY',
                'value' => 10,
            ]
        );
        Config::updateOrCreate(
            ['key_' => 'SEGMENTATION_BATCH_MESSAGE_DELAY'],
            [
                'key_' => 'SEGMENTATION_BATCH_MESSAGE_DELAY',
                'value' => 2,
            ]
        );

        Config::updateOrCreate(
            ['key_' => 'SEGMENTATION_BATCH_SIZE'],
            [
                'key_' => 'SEGMENTATION_BATCH_SIZE',
                'value' => 10,
            ]
        );
    }
}
