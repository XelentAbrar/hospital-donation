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
            Schema::table('appointments', function (Blueprint $table) {
                $table->unsignedBigInteger('careoff_id')->nullable();
                $table->unsignedBigInteger('zf_id')->nullable();
                $table->float('donor_fee',11,2)->nullable();
                $table->foreign('careoff_id')->references('id')->on('donors')->onDelete('set null');
                $table->foreign('zf_id')->references('id')->on('donors')->onDelete('set null');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(file_exists(base_path('config/hrms.php'))) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('zf_id');
                $table->dropColumn('careoff_id');
                $table->dropColumn('donor_fee');
            });
        }
    }
};
