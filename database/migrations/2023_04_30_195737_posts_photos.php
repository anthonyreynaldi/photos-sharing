<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('posts_photos', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('id_post');
            $table->uuid('id_photos');
            $table->foreign('id_post')->references('id')->on('posts');
            $table->foreign('id_photo')->references('id')->on('photos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('posts_photos');
    }
};
