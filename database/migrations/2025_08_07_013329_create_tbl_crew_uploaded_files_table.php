<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_main';
    
    public function up()
    {
        Schema::connection($this->connection)->create('tblCrewUploadedFiles', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('ProfileID');
            $table->integer('FileID');
            $table->string('Code', 50);
            $table->string('DocName', 150);
            $table->integer('DocCount');
            $table->date('IssuedDate');
            $table->date('ExpirationDate')->nullable();
            $table->dateTime('DateCreated');
            $table->dateTime('DateUpdated');
            $table->string('UploadedBy',100);
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('tblCrewUploadedFiles');
    }
};