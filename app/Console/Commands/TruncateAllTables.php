<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateAllTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all tables in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tắt ràng buộc khóa ngoại tạm thời
        Schema::disableForeignKeyConstraints();

        // Lấy danh sách tất cả các bảng trong database
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $tableKey = 'Tables_in_' . $dbName;

        // Lặp qua các bảng và thực hiện truncate
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            if ($tableName === 'migrations') {
                continue;
            }

            DB::table($tableName)->truncate();

            $this->info("Truncated: " . $tableName);
        }

        // Bật lại ràng buộc khóa ngoại sau khi đã truncate
        Schema::enableForeignKeyConstraints();

        $this->info('All tables truncated successfully.');
    }
}
