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
        Schema::create('campaign_ad_breakers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->index();
            $table->integer('on_question_num');
            $table->string('asset_url');
            $table->string('action_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_ad_breakers');
    }
};
