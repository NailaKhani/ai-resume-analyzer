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
        Schema::table('candidates', function (Blueprint $table) {
            $table->json('missing_skills')->nullable()->after('parsed_skills');
            $table->text('ai_advice')->nullable()->after('missing_skills');
            $table->string('status')->default('Pending')->after('ai_advice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['missing_skills', 'ai_advice', 'status']);
        });
    }
};
