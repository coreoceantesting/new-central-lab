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
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->unsignedTinyInteger('interval_type')->after('units')->nullable();
            $table->string('from_range')->after('interval_type')->nullable();
            $table->string('to_range')->after('from_range')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('interval_type');
            $table->dropColumn('from_range');
            $table->dropColumn('to_range');
        });
    }
};
