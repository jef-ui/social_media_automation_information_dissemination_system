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
        Schema::create('sms_advisories', function (Blueprint $table) {
            $table->id();
            $table->text('sms_content');
            $table->string('hazard'); // derived from PNG logic
            $table->string('prepared_by')->nullable();
            $table->text('issues_concerns')->nullable();
            $table->text('actions_taken')->nullable();
            $table->enum('posting_status', ['draft', 'posted', 'failed'])->default('draft');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_advisories');
    }
};
