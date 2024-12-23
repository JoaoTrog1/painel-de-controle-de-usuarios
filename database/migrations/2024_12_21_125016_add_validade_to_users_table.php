<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->date('validade')->nullable(); // Adiciona a coluna de validade
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('validade');
    });
}
    
};
