<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabaseCommand extends Command
{
    protected $signature = 'db:export {--file=database_backup.sql : Output filename} {--raw-mysqldump : Force external mysqldump binary instead of clean PHP generator}';
    protected $description = 'Export the corporate-cms database to a 100% cPanel/MariaDB compatible SQL file';

    public function handle(): int
    {
        $filename = $this->option('file') ?: 'database_backup.sql';
        $outputPath = base_path($filename);

        $dbName = config('database.connections.mysql.database');
        $this->info("Exporting database [{$dbName}] for cPanel/phpMyAdmin compatibility...");

        if ($this->option('raw-mysqldump')) {
            $mysqldumpPath = $this->findMysqldumpPath();
            if ($mysqldumpPath && file_exists($mysqldumpPath)) {
                $dbUser = config('database.connections.mysql.username');
                $dbPass = config('database.connections.mysql.password');
                $dbHost = config('database.connections.mysql.host', '127.0.0.1');
                $dbPort = config('database.connections.mysql.port', '3306');

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
                    $this->info("✓ Database exported via mysqldump to: {$filename} ({$sizeKb} KB)");
                    return Command::SUCCESS;
                }
            }
        }

        // Default & Recommended: Clean, 100% cPanel MariaDB & phpMyAdmin compatible SQL dump
        $sql = static::generateSqlDump();
        file_put_contents($outputPath, $sql);

        $sizeKb = round(filesize($outputPath) / 1024, 2);
        $this->info("✓ Clean cPanel/phpMyAdmin compatible SQL dump successfully generated: {$filename} ({$sizeKb} KB)");

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
        $pdo = DB::connection()->getPdo();

        $out = "-- ========================================================\n";
        $out .= "-- Nordroy Corporate CMS - cPanel & phpMyAdmin Compatible Dump\n";
        $out .= "-- Target Compatibility: MariaDB 10.x+, MySQL 5.7+, MySQL 8.x, MySQL 9.x\n";
        $out .= "-- Generated at: " . date('Y-m-d H:i:s') . "\n";
        $out .= "-- Host: " . config('database.connections.mysql.host') . "\n";
        $out .= "-- Database: " . $dbName . "\n";
        $out .= "-- ========================================================\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $out .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $out .= "SET AUTOCOMMIT = 0;\n";
        $out .= "START TRANSACTION;\n";
        $out .= "SET time_zone = \"+00:00\";\n\n";

        foreach ($tables as $tObj) {
            $table = array_values((array)$tObj)[0];

            // Table Structure (guaranteed to use standard MySQL backticks)
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
                        $vals = array_map(function ($val) use ($pdo) {
                            if ($val === null) {
                                return 'NULL';
                            }
                            if (is_int($val) || is_float($val)) {
                                return (string)$val;
                            }
                            return $pdo->quote((string)$val);
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

