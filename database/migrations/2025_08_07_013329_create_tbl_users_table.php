<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Set the connection for this migration
    protected $connection = 'mysql_users';
    
    public function up()
    {
        Schema::connection($this->connection)->create('tblUsers', function (Blueprint $table) {
            $table->id('ID');
            $table->dateTime('DateCreated');
            $table->dateTime('DateUpdated');
            $table->string('Username', 200);
            $table->string('Password', 200);
            $table->string('Email',200);
            $table->string('Usertype',5);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('TimeStamp')->nullable();
            $table->dateTime('LastLogin')->nullable();
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('tblUsers');
    }
};