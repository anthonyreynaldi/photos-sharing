<?php

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use HasUuids;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('posts', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('id_user');
            $table->text('caption');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('posts');
    }
};
