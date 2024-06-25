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
        Schema::table('campaign_leaderboard_rewards', function (Blueprint $table) {
            $table->integer("player_position")->default(0)->change();
            $table->integer("top_players_start")->default(0);
            $table->integer("top_players_end")->default(0);
            $table->integer("top_players_revenue_share_percent")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_leaderboard_rewards', function (Blueprint $table) {
            //
        });
    }
};
