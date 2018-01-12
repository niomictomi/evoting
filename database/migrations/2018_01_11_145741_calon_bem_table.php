<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CalonBemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_bem', function (Blueprint $table){
            $table->increments('id');
            $table->string('ketua_id');
            $table->foreign('ketua_id')
                ->references('id')
                ->on('mahasiswa')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string('wakil_id');
            $table->foreign('wakil_id')
                ->references('id')
                ->on('mahasiswa')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->smallInteger('nomor')->nullable();
            $table->text('dir');
            $table->text('visi');
            $table->text('misi');
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
