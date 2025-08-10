<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_main')->create('tblDocumentTypes', function (Blueprint $table) {
            $table->id('ID');
            $table->char('Code', 10);
            $table->string('Description', 150);
            $table->dateTime('CreatedAt');
            $table->dateTime('UpdatedAt');
        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_main')->dropIfExists('tblDocumentTypes');
    }
}