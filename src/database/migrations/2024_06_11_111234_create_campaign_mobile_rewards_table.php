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
        Schema::create('campaign_mobile_rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->index();
            $table->enum('type', ["AIRTIME", "CASH", "DATA"]);
            $table->decimal("reward", 8, 2);
            $table->integer("quantity");
            $table->integer("quantity_remainder");
            $table->json('specific_days')->nullable();
            $table->string('icon_url')->nullable();
            $table->boolean('cash_reward_to_wallet')->default(false);
            $table->boolean('cash_reward_to_bank')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_mobile_rewards');
    }
};
