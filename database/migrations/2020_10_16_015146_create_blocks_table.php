<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->boolean('hero')->default(0);
            $table->boolean('published')->default(1);
            $table->integer('weight')->default(0);
            $table->text('text_colour')->nullable();
            $table->text('background_colour')->nullable();
            $table->text('background_image')->nullable();
            $table->string('heading')->nullable();
            $table->text('heading_colour')->nullable();
            $table->text('content')->nullable();
            $table->text('content_width')->nullable();
            $table->text('content_position')->nullable();
            $table->string('cta_title')->nullable();
            $table->string('cta_link')->nullable();
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
        Schema::dropIfExists('blocks');
    }
}
