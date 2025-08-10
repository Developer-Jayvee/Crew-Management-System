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
        Schema::connection('mysql_users')->create('tblUserTypes', function (Blueprint $table) {
            $table->id('ID');
            $table->char('CODE',5);
            $table->string('UserType', 100);
            $table->dateTime('DateCreated')->useCurrent(); 
            $table->dateTime('DateUpdated')->useCurrent();
            
           
        });

        DB::connection('mysql_users')->table('tblUserTypes')->insert([
            ['CODE' => 'G','UserType' => 'Admin'],
            ['CODE' => 'G', 'UserType' => 'Guest'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_users')->dropIfExists('tblUserTypes');
    }
};