<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Column name is role and the value should be a string
            $table->string('role')
            // The field can be null
            ->nullable()
            // The default value is null
            ->default(null)
            // The new row should come after the location field
            ->after('location');
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
            // Dropping the row column
            $table->dropColumn(
                'role'
            );
        });
    }
}
