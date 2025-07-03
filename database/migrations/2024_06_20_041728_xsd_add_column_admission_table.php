<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(file_exists(base_path('config/hrms.php'))) {
            Schema::table('admissions', function (Blueprint $table) {
                $table->unsignedBigInteger('careoff_id')->nullable();
                $table->string('zf_fee')->nullable();
                $table->string('donor_fee')->nullable();

                $table->foreign('careoff_id')->references('id')->on('donors')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
