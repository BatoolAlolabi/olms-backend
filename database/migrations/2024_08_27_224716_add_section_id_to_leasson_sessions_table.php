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
        Schema::table('leasson_sessions', function (Blueprint $table) {
            $table->integer('duaration')->nullable();
            $table->foreignId('section_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leasson_sessions', function (Blueprint $table) {
            //
        });
    }
};
