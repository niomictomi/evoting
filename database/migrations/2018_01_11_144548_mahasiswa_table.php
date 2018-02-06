<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table){
            $table->string('id')
                ->unique()
                ->primary();
            $table->integer('prodi_id');
            $table->foreign('prodi_id')
                ->references('id')
                ->on('prodi')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
            $table->string('nama');
            $table->string('status');
            $table->boolean('login')->default(false);
            $table->boolean('telah_login')->default(false);
            $table->boolean('hmj')->default(false);
            $table->boolean('dpm')->default(false);
            $table->boolean('bem')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->text('password')->nullable();
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
