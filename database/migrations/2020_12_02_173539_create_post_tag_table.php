<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->timestamps();
            // Adding new primary keys
            $table->primary(['post_id', 'tag_id']);
            //Adding new foreign keys
            $table->foreign('post_id')
            ->references('id')->on('posts') // referencing the ID field in the posts table
            ->onDelete('cascade'); // If post is deleted delete connection between post and tag
            $table->foreign('tag_id')
            ->references('id')->on('tags') // referencing the ID field in the tags table
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
