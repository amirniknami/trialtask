<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            // As in hte trial pdf explained i add foreign key constrained
            // here in the shifts table because for example user can
            // have multiply shifts but a shift only have one user
            // One to many  entity relationship except for departments
            $table->id();
            $table->foreignId("user_id")
                  ->constrained();
            $table->foreignId("location_id")
                  ->constrained();
            $table->foreignId('event_id')
                  ->nullable()
                  ->constrained();

            $table->string('type');
            $table->timestamp("start");
            $table->timestamp("end");
            $table->float('charge',8,1)
                  ->nullable();
            $table->float('rate',8,1)
                  ->nullable();
            $table->string('area')
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
