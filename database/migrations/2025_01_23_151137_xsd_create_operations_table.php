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
        if(file_exists(base_path('config/ot.php'))) {
            Schema::table('operations', function (Blueprint $table) {
                $table->string('donor_fee')->nullable();
                $table->string('zf_fee')->nullable();
                $table->unsignedBigInteger('careoff_id')->nullable();

                $table->foreign('careoff_id')->references('id')->on('donors')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(file_exists(base_path('config/ot.php'))) {
            Schema::dropIfExists('operations');
        }
    }
};
