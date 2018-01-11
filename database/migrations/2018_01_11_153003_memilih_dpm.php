<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemilihDpm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memilih_dpm', function (Blueprint $table){
            $table->integer('calon_dpm_id');
            $table->foreign('calon_dpm_id')
                ->references('id')
                ->on('calon_dpm')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string('mahasiswa_id');
            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('mahasiswa')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
        //
    }
}
