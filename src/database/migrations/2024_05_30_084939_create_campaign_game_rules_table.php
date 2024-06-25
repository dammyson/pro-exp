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
        Schema::create('campaign_game_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->index();
            $table->foreign('campaign_id')->references('id')->on('campaigns')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->boolean('has_leaderboard')->default(false);
            $table->integer('leaderboard_num_winners')->default(0);
            $table->integer('cut_off_mark')->default(0);
            $table->integer('maximum_game_play')->default(1);
            $table->integer('maximum_win')->default(1);
            $table->boolean('is_data_collection')->default(false);
            $table->boolean('has_free_game_play')->default(false);
            $table->integer('num_free_game_plays')->default(0);
            $table->boolean('has_referral')->default(false);
            $table->integer('referral_points')->default(0);
            $table->boolean('is_subscription_based')->default(false);
            $table->boolean('has_ad_breaker')->default(false);
            $table->integer('duration_per_game_play')->nullable();            
            $table->boolean('import_opentdb_questions')->default(false);
            $table->integer('max_questions_per_play')->default(0);
            $table->boolean('is_pay_as_you_go')->default(false);
            $table->decimal('pay_as_you_go_amount', 8,2)->default(0);
            $table->enum('payout', ['wallet', 'bank'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_game_rules');
    }
};
