<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('email')->unique();
            $table->boolean("isHod")->default(false);
            $table->timestamps();
        });

        // Pivot table for staff and department
        Schema::create('department_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("staff_id");
            $table->timestamps();

            $table->unique(["department_id", "staff_id"]);

            $table->foreign('department_id')->references("id")->on("departments")->onDelete("cascade");
            $table->foreign("staff_id")->references("id")->on("staff")->onDelete("cascade");
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
