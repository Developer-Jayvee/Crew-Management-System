<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_files';
    
    public function up()
    {
        Schema::connection($this->connection)->create('tblCrewDocuments', function (Blueprint $table) {
            $table->id('ID');
            $table->integer('UserID');
            $table->binary('FileData');
            $table->string('FileName',200);
            $table->string('mime_type',100);
            $table->enum('FileType', ['pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg']);
            $table->dateTime('DateCreated');
            $table->dateTime('DateUpdated');
            $table->string('UploadedBy',100);
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('tblCrewDocuments');
    }
};