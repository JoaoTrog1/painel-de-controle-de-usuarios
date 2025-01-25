<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewDataTable extends Migration
{
    public function up()
    {
        Schema::create('view_data', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('content');
            $table->integer('min')->default(0);
            $table->integer('max')->default(100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('view_data');
    }
}
