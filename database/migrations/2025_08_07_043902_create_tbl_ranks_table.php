<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The database connection that should be used by the migration.
     *
     * @var string
     */
    protected $connection = 'mysql_main';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblRanks', function (Blueprint $table) {
            $table->id('ID');
            $table->string('CODE', 50); 
            $table->string('RankDescription', 200); 
            $table->string('Alias', 150);
            $table->dateTime('DateCreated')->useCurrent();
            $table->dateTime('DateUpdated')->useCurrent();
            $table->index('CODE');
        });

        // Insert the rank data
        DB::connection('mysql_main')->table('tblRanks')->insert([
            ['CODE' => 'MM',    'RankDescription' => 'MASTER MARINER',           'Alias' => 'M. MARINER'],
            ['CODE' => 'CM',    'RankDescription' => 'CHIEF MATE',               'Alias' => 'C. MATE'],
            ['CODE' => '2M',    'RankDescription' => 'SECOND MATE',             'Alias' => '2. MATE'],
            ['CODE' => '3M',    'RankDescription' => 'THIRD MATE',              'Alias' => '3. MATE'],
            ['CODE' => 'CE',    'RankDescription' => 'CHIEF ENGINEER',          'Alias' => 'C. ENGINEER'],
            ['CODE' => '1AE',   'RankDescription' => 'FIRST ASSISTANT ENGINEER', 'Alias' => '1. ASSISTANT ENGINEER'],
            ['CODE' => '2AE',   'RankDescription' => 'SECOND ASSISTANT ENGINEER','Alias' => '2. ASSISTANT ENGINEER'],
            ['CODE' => '3AE',   'RankDescription' => 'THIRD ASSISTANT ENGINEER', 'Alias' => '3. ASSISTANT ENGINEER'],
            ['CODE' => 'AB',    'RankDescription' => 'ABLE SEAMAN',             'Alias' => 'A. SEAMAN'],
            ['CODE' => 'OS',    'RankDescription' => 'ORDINARY SEAMAN',         'Alias' => 'O. SEAMAN'],
            ['CODE' => 'WPR',   'RankDescription' => 'WIPER',                   'Alias' => 'WPER'],
            ['CODE' => 'BS',    'RankDescription' => 'BOSUN',                   'Alias' => 'BSN'],
            ['CODE' => 'FTR',   'RankDescription' => 'FITTER',                  'Alias' => 'FITTR'],
            ['CODE' => 'DC',    'RankDescription' => 'DECK CADET',              'Alias' => 'D. CADET'],
            ['CODE' => 'EC',    'RankDescription' => 'ENGINE CADET',            'Alias' => 'E. CADET'],
            ['CODE' => 'CCK',   'RankDescription' => 'CHIEF COOK',              'Alias' => 'C. COOK'],
            ['CODE' => '2CK',   'RankDescription' => 'SECOND COOK',             'Alias' => '2. COOK'],
            ['CODE' => 'MM',    'RankDescription' => 'MESSMAN',                 'Alias' => 'M. MAN'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblRanks');
    }
};