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
            Schema::create('donor_funds', function (Blueprint $table) {
                $table->id();
                $table->float("charges",11,2)->nullable();
                $table->unsignedBigInteger('donor_id')->nullable();
                $table->timestamps();

                $table->foreign('donor_id')->references('id')->on('donors')->onDelete('set null');
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
        if(file_exists(base_path('config/hrms.php'))) {
            Schema::dropIfExists('donor_funds');
        }
    }
};
