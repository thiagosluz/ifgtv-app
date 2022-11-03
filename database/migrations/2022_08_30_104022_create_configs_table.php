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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            //campo de tempo de slides
            $table->integer('slide_time')->default(20);
            //campo de frases padrão de aniversário
            $table->string('birthday_message')->default('Parabéns pelo seu aniversário!');
            //campo de quantidades de publicações nas tvs
            $table->integer('tv_posts')->default(0);
            //campo de quantidades de esperando aprovação
            $table->integer('waiting_approval')->default(0);
            //quantidade de usuarios aguardando cadastrado
            $table->integer('waiting_register')->default(0);

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
        Schema::dropIfExists('configs');
    }
};
