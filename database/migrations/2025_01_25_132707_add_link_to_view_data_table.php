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
        Schema::table('view_data', function (Blueprint $table) {
            $table->string('link')->nullable()->after('content'); // Adiciona o campo 'link' após o campo 'content'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('view_data', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};
