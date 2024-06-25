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

        Schema::create('campaign_game_plays', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->index();
            $table->uuid('audience_id')->index();
            $table->uuid('campaign_subscription_id')->index()->nullable();
            $table->double('durations')->default(0);
            $table->double('points')->default(0);
            $table->uuid('referrer_id')->nullable();
            $table->uuid('campaign_game_id')->nullable();
            $table->timestamp('paused_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_game_plays');
    }
};
