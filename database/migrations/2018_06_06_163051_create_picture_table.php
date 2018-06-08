<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('img_category_id')->unsigned()->index();
            $table->string('title')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('thumbnail')->nullable();
            $table->longText('content')->nullable();
            $table->longText('json_pack')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('view_count')->unsigned()->default(0);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures');
    }
}
