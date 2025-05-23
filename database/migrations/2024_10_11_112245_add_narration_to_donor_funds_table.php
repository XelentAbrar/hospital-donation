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
        Schema::table('donor_funds', function (Blueprint $table) {
            $table->text('narration')->nullable();
            $table->string('donor_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donor_funds', function (Blueprint $table) {

            $table->dropColumn('narration');
            $table->dropColumn('donor_date');

        });
    }
};
