<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseName extends Migration
{
    public function up()
    {
        // Create the database if it doesn't exist
        DB::statement('CREATE DATABASE IF NOT EXISTS DBCrew CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('CREATE DATABASE IF NOT EXISTS DBCrewFiles CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('CREATE DATABASE IF NOT EXISTS DBCrewUsers CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    public function down()
    {
        
        DB::statement('DROP DATABASE IF EXISTS DBCrew');
        DB::statement('DROP DATABASE IF EXISTS DBCrewFiles');
        DB::statement('DROP DATABASE IF EXISTS DBCrewUsers');
    }
}