<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserGenderType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateAllTable();
        
        // Fake User
        $this->call([
            UserSeeder::class,
            CategorySeeder::class
        ]);

        // Fake User                -> OK
        // Fake Categories          -> OK
        // Fake Brands              -> 
        // Fake Tags                
        // Fake Attributes          
        // Fake Attribute Values    
        // Fake Payments            
        // Fake Order Status        
        // Fake Products            
        // Fake Orders              
    }

    private function truncateAllTable()
    {
        Schema::disableForeignKeyConstraints();

        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $tableKey = 'Tables_in_' . $dbName;

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            if ($tableName === 'migrations') {
                continue;
            }

            DB::table($tableName)->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }
}
