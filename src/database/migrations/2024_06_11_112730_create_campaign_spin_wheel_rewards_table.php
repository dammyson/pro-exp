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
        Schema::create('campaign_spin_wheel_rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->nullable();
            $table->uuid('audience_id')->nullable();
            $table->string('type')->nullable();
            $table->string('value')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_redeem')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_spin_wheel_rewards');
    }
};
