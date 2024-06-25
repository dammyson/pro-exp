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
        Schema::create('campaign_leaderboard_rewards', function (Blueprint $table) {
            $table->id();
            $table->uuid('campaign_id')->index();
            $table->enum('type', ["AIRTIME", "CASH", "DATA", "VOUCHER"]);
            $table->integer("player_position");
            $table->string("reward");
            $table->string("description")->nullable();
            $table->enum('frequency', ["ALL-TIME", "DAILY", "WEEKLY", "MONTHLY"]);
            $table->json('specific_days')->nullable();
            $table->string('icon_url')->nullable();
            $table->boolean('cash_reward_to_wallet')->default(false);
            $table->boolean('cash_reward_to_bank')->default(false);
            $table->enum('voucher_redemption_mode', ["ONLINE", "OFFLINE"])->nullable();
            $table->string('voucher_redemption_url')->nullable();
            $table->integer('voucher_redemption_expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_leaderboard_rewards');
    }
};
