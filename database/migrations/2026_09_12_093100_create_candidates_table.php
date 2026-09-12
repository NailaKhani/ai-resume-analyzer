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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The candidate user
            $table->foreignId('job_posting_id')->nullable()->constrained('job_postings')->onDelete('cascade'); // The job they applied for
            $table->string('resume_path')->nullable();
            $table->json('parsed_skills')->nullable();
            $table->decimal('match_score', 5, 2)->nullable(); // 0 to 100 percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
