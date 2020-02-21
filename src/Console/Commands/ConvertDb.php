<?php
namespace Crisjohn02\Sqlconverter\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConvertDb extends Command
{
    protected $signature = "convert:db";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (file_exists(base_path('database/database.sqlite'))) {
            $this->error('Sqlite database already exists in database/ folder');
        } else {
            $exported = storage_path('app/tmp/'.env('DB_DATABASE').'.sql');
            Storage::makeDirectory('tmp');
            $s = shell_exec('mysqldump --skip-extended-insert --compact --user '. env('DB_USERNAME') .' --password='. env('DB_PASSWORD') .' ' . env('DB_DATABASE') . ' > ' . $exported . ' 2> /dev/null');
            Log::info(base_path('vendor/crisjohn02/sqlconverter/src/lib/mysql2sqlite') . " " . storage_path('app/tmp/'.env('DB_DATABASE').'.sql') . " | " . "sqlite3 " . base_path('database/database.sqlite'));
            $v = shell_exec(base_path('vendor/crisjohn02/sqlconverter/src/lib/mysql2sqlite') . " " . storage_path('app/tmp/'.env('DB_DATABASE').'.sql') . " | " . "sqlite3 " . base_path('database/database.sqlite'));
            Storage::deleteDirectory('tmp');

            $this->info("Conversion successful. File generated to /database folder");
        }

    }
}
