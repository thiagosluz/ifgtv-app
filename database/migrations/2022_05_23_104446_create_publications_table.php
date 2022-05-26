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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->date('data_expiracao')->nullable();
            $table->dateTime('data_publicacao')->nullable();
            $table->text('imagem')->nullable();
            $table->text('texto')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('publicado')->default(0);
            $table->string('tipo');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('publications');
    }
};
