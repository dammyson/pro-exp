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
        Schema::create('campaign_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->index();
            $table->uuid('question_id')->index();
            $table->boolean('is_data_collection')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_questions');
    }
};
