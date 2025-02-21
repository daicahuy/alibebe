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
            CategorySeeder::class,
            BrandSeeder::class,
            TagSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            PaymentSeeder::class,
            OrderStatusSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

        // Fake User                -> OK
        // Fake Categories          -> OK
        // Fake Brands              -> OK
        // Fake Tags                -> OK
        // Fake Attributes          -> OK
        // Fake Attribute Values    -> OK
        // Fake Payments            -> OK
        // Fake Order Status        -> OK  
        // Fake Products               
        // Fake Orders              
    }

    private function truncateAllTable()
    {
        Schema::disableForeignKeyConstraints();

        $dbName = env('DB_DATABASE');
        $tables = DB::table('information_schema.tables')
            ->where('table_schema', $dbName)
            ->pluck('table_name');

        foreach ($tables as $tableName) {
            if ($tableName !== 'migrations') {
                DB::table($tableName)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }

}
