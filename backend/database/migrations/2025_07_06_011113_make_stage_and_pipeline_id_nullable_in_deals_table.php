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
        Schema::table('deals', function (Blueprint $table) {
            $table->string('pipeline_id')->nullable()->change();
            $table->string('stage_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('deals', function (Blueprint $table) {
            $table->string('pipeline_id')->nullable(false)->change();
            $table->string('stage_id')->nullable(false)->change();
        });
    }
};
