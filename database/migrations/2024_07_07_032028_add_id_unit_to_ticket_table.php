<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('id_unit')->nullable()->after('id'); // Menambahkan kolom id_unit
            $table->foreign('id_unit')->references('id')->on('units')->onDelete('cascade'); // Menambahkan foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['id_unit']);
            $table->dropColumn('id_unit');
        });
    }
};
