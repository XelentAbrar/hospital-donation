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
        if(file_exists(base_path('config/hrms.php'))) {
            Schema::table('donor_funds', function (Blueprint $table) {
                $table->boolean('is_printed')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(file_exists(base_path('config/hrms.php'))) {
            Schema::table('donor_funds', function (Blueprint $table) {

                $table->dropColumn('is_printed');

            });
        }
    }
};
