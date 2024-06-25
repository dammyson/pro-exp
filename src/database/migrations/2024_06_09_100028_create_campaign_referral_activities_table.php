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
        Schema::create('campaign_referral_activities', function (Blueprint $table) {
            $table->id();
            // I believe this is attributed to a particular campaign 
            // however going by this relationship it means a campaign can have many referent_id

            // second thought I think it means the person being referred (this make more sense)
            $table->uuid('referent_id');
            $table->uuid('campaign_id');
            $table->uuid('campaign_referral_id');
            $table->boolean('is_activated')->default(false);
            $table->boolean('is_activation_point_redeemed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_referral_activities');
    }
};
