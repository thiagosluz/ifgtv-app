<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *Example:
     text' => 'Publicações',
    'url'  => 'publications',
    'icon' => 'fas fa-fw fa-tv',
    'icon_color' => 'primary',
    'classes'  => 'text-yellow',
    'active' => ['publications*', 'regex:@^content/[0-9]+$@'],
    'label'       => 4,
    'label_color' => 'danger',
    'can'  => 'super-admin',
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('url');
            $table->string('icon');
            $table->integer('order');
            $table->string('icon_color')->nullable()->default(null);
            $table->string('classes')->nullable()->default(null);
            $table->string('can')->nullable()->default(null);
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
        Schema::dropIfExists('pages');
    }
};
