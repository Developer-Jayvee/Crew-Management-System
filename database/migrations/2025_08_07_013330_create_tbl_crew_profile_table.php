<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_main';
    
    public function up()
    {
        Schema::connection($this->connection)->create('tblCrewProfile', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('UserID');
            $table->string('LName', 150);
            $table->string('FName', 150);
            $table->string('MName', 150)->nullable();
            $table->integer('Age');
            $table->date('BDate');
            $table->float('Weight');
            $table->float('Height');
            $table->char('Rank',5);
            $table->string('Usertype',5);
            $table->string('Address', 300);
            $table->string('Email', 150);
            $table->dateTime('DateCreated');
            $table->dateTime('DateUpdated');
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('tblCrewProfile');
    }
};