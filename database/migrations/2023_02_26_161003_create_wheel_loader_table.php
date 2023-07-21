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
        Schema::create('wheel_loader', function (Blueprint $table) {
            $table->id();
            $table->string('no_order');
            $table->string('pekerjaan');
            $table->string('kapal');
            $table->string('no_palka');
            $table->string('kegiatan')->nullable();
            $table->string('area')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
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
        Schema::dropIfExists('wheel_loader');
    }
};
