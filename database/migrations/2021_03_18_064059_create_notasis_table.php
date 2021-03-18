<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notasi', function (Blueprint $table) {
            $table->id();
            $table->string("notation")->nullable();
            $table->string("read")->nullable();
            $table->string("description")->nullable();
            $table->string("audio_path")->nullable();
            $table->string("deleted_at")->nullable();
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
        Schema::dropIfExists('notasi');
    }
}
