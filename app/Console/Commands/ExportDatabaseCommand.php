<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabaseCommand extends Command
{
    protected $signature = 'db:export {--file=database_backup.sql : Output filename}';
    protected $description = 'Export the corporate-cms database to a clean SQL file';

    public function handle(): int
    {
        $filename = $this->option('file') ?: 'database_backup.sql';
        $outputPath = base_path($filename);

        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');

        $this->info("Exporting database [{$dbName}]...");

        // Try to locate mysqldump binary
        $mysqldumpPath = $this->findMysqldumpPath();

        if ($mysqldumpPath && file_exists($mysqldumpPath)) {
            $cmd = sprintf(
                '"%s" -u %s %s -h %s -P %s --set-gtid-purged=OFF %s --result-file="%s"',
                $mysqldumpPath,
                escapeshellarg($dbUser),
                $dbPass ? '-p' . escapeshellarg($dbPass) : '',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbName),
                $outputPath
            );

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
                $sizeKb = round(filesize($outputPath) / 1024, 2);
                $this->info("✓ Database successfully exported via mysqldump to: {$filename} ({$sizeKb} KB)");
                return Command::SUCCESS;
            }
        }

        // Fallback: Pure PHP SQL Exporter
        $this->warn('mysqldump binary not in PATH. Generating clean SQL dump via PHP PDO engine...');
        $sql = $this->generateSqlDump();
        file_put_contents($outputPath, $sql);

        $sizeKb = round(filesize($outputPath) / 1024, 2);
        $this->info("✓ Database successfully exported via PHP Engine to: {$filename} ({$sizeKb} KB)");

        return Command::SUCCESS;
    }

    protected function findMysqldumpPath(): ?string
    {
        $localApp = getenv('LOCALAPPDATA');
        $candidates = [
            'mysqldump',
            $localApp ? "{$localApp}\\com.tinyapp.DBngin\\Binaries\\mysql\\9.7.1\\bin\\mysqldump.exe" : null,
            $localApp ? "{$localApp}\\com.tinyapp.DBngin\\Binaries\\mysql\\8.0\\bin\\mysqldump.exe" : null,
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
        ];

        foreach ($candidates as $path) {
            if ($path && file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    public static function generateSqlDump(): string
    {
        $tables = DB::select('SHOW FULL TABLES WHERE Table_Type = "BASE TABLE"');
        $dbName = config('database.connections.mysql.database');

        $out = "-- Nordroy Corporate CMS SQL Database Dump\n";
        $out .= "-- Generated at: " . date('Y-m-d H:i:s') . "\n";
        $out .= "-- Host: " . config('database.connections.mysql.host') . "\n";
        $out .= "-- Database: " . $dbName . "\n";
        $out .= "-- --------------------------------------------------------\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $out .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $out .= "START TRANSACTION;\n";
        $out .= "SET time_zone = \"+00:00\";\n\n";

        foreach ($tables as $tObj) {
            $table = array_values((array)$tObj)[0];

            // Table Structure
            $create = DB::select("SHOW CREATE TABLE `{$table}`");
            $createSql = array_values((array)$create[0])[1] ?? '';

            $out .= "--\n-- Table structure for table `{$table}`\n--\n";
            $out .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $out .= $createSql . ";\n\n";

            // Table Data
            $rows = DB::table($table)->get();
            if ($rows->count() > 0) {
                $out .= "--\n-- Dumping data for table `{$table}`\n--\n";
                foreach ($rows->chunk(50) as $chunk) {
                    $out .= "INSERT INTO `{$table}` VALUES \n";
                    $rowStrings = [];
                    foreach ($chunk as $row) {
                        $vals = array_map(function ($val) {
                            if ($val === null) return 'NULL';
                            return "'" . addslashes((string)$val) . "'";
                        }, (array)$row);
                        $rowStrings[] = "(" . implode(', ', $vals) . ")";
                    }
                    $out .= implode(",\n", $rowStrings) . ";\n";
                }
                $out .= "\n";
            }
        }

        $out .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $out .= "COMMIT;\n";

        return $out;
    }
}
