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
        Schema::create('campaign_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('campaign_id')->index();
            $table->uuid('audience_id')->index();
            $table->uuid('campaign_subscription_plan_id')->index();
            $table->string('payment_reference');
            $table->integer('allocated_game_plays');
            $table->integer('available_game_plays');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_subscriptions');
    }
};
