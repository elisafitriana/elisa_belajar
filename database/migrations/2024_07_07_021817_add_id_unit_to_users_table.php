<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUnitToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_unit']); // Menghapus foreign key constraint
            $table->dropColumn('id_unit'); // Menghapus kolom id_unit
        });
    }
}
