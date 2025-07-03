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
            Schema::create('donors', function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->enum("type", ["care_off", "zf"])->nullable();
                $table->text("description", 1000)->nullable();
                $table->text("address", 1000)->nullable();
                $table->timestamps();
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
            Schema::dropIfExists('donors');
        }
    }
};
