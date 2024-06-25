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
        Schema::create('green_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('audience_id');
            $table->string('campaign_id');
            $table->string('campaign_subscription_plan_id');
            $table->string('ticket_number');
            $table->date('date');
            $table->boolean('status')->default(true);
            $table->boolean('open_to_pool')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('green_cards');
    }
};
