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
        Schema::create('campaign_vendor_spinwheel_reward', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('audience_id');
            $table->string('vendor_id');
            $table->string('type');
            $table->string('value');
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
        Schema::dropIfExists('campaign_vendor_spinwheel_reward');
    }
};
