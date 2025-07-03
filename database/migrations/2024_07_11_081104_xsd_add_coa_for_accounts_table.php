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
        if(file_exists(base_path('config/accounts.php'))) {
            Schema::table('donors', function (Blueprint $table) {
                $table->bigInteger('coa_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(file_exists(base_path('config/accounts.php'))) {
            Schema::table('donors', function (Blueprint $table) {
                $table->dropColumn('coa_id');
            });
        }
    }
};
