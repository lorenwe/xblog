<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictureImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('picture_id')->index();
            $table->string('key')->unique();
            $table->string('uri')->nullable();
            $table->string('disk', 128)->nullable();
            $table->integer('size');
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
        Schema::dropIfExists('picture_imgs');
    }
}
