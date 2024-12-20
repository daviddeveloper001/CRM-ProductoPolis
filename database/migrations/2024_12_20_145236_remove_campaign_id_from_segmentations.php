<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('segmentations', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']); 
            $table->dropColumn('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('segmentations', function (Blueprint $table) {
            $table->foreignId('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });
    }
};
