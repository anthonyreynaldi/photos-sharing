<?php

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use HasUuids;
    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('comments', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('id_post');
            $table->uuid('id_user');
            $table->text('comment');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('id_post')->references('id')->on('posts');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('comments');
    }
};
