<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PemilihanBemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilihan_bem', function (Blueprint $table){
            $table->integer('calon_bem_id');
            $table->foreign('calon_bem_id')
                ->references('id')
                ->on('calon_bem')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string('mahasiswa_id')->unique();
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
