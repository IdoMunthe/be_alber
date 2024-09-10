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
        Schema::create('albers', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_alber');
            $table->string('no_order');
            $table->string('pekerjaan');
            $table->string('kapal')->nullable();
            $table->string('no_palka')->nullable();
            $table->string('kegiatan')->nullable();
            $table->string('area')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('status_time')->nullable();
            $table->integer('no_lambung')->nullable();
            $table->string('operator')->nullable();
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
        Schema::dropIfExists('albers');
    }
};
