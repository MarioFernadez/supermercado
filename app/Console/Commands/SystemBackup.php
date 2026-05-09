<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full backup of the system (Database + Files)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting system backup...');

        // 1. Prepare Paths
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "backup_{$timestamp}";
        $sqlFile = "{$backupPath}/{$filename}.sql";
        $zipFile = "{$backupPath}/{$filename}.zip";

        // 2. Database Backup
        $this->info('Backing up database...');
        
        $dbHost = config('database.connections.pgsql.host');
        $dbPort = config('database.connections.pgsql.port');
        $dbName = config('database.connections.pgsql.database');
        $dbUser = config('database.connections.pgsql.username');
        $dbPass = config('database.connections.pgsql.password');

        // Attempt to find pg_dump
        $pgDumpPath = env('PG_DUMP_PATH', 'pg_dump'); // Use .env or default
        
        $possiblePaths = [
            $pgDumpPath,
            'C:\Program Files\PostgreSQL\17\bin\pg_dump.exe',
            'C:\Program Files\PostgreSQL\16\bin\pg_dump.exe',
            'C:\Program Files\PostgreSQL\15\bin\pg_dump.exe',
            'C:\Program Files\PostgreSQL\14\bin\pg_dump.exe',
            'C:\Program Files\PostgreSQL\13\bin\pg_dump.exe',
        ];

        // Check if pg_dump is in PATH (simple check) or check explicit paths
        // For Windows, setting PGPASSWORD env var is needed
        
        $envPrefix = "set PGPASSWORD={$dbPass}&&";
        $cmd = "{$envPrefix} \"{$pgDumpPath}\" -h {$dbHost} -p {$dbPort} -U {$dbUser} -F p -b -v -f \"{$sqlFile}\" {$dbName}";

        // Try execution. If it fails, try absolute paths.
        $this->info("Executing dump...");
        
        // Simple exec wrapper to catch failure
        $returnVar = null;
        $output = [];
        exec($cmd, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->warn('Standard pg_dump failed. Trying to locate executable...');
            $foundPath = false;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $pgDumpPath = $path;
                    $foundPath = true;
                    break;
                }
            }

            if ($foundPath) {
                $cmd = "{$envPrefix} \"{$pgDumpPath}\" -h {$dbHost} -p {$dbPort} -U {$dbUser} -F p -b -v -f \"{$sqlFile}\" {$dbName}";
                exec($cmd, $output, $returnVar);
            }
        }

        if ($returnVar !== 0) {
            $this->error('Database backup failed. Could not find pg_dump or access denied.');
            $this->error('Please install PostgreSQL tools or add pg_dump to your PATH.');
            return 1;
        }

        // 3. File Backup (Zip)
        $this->info('Compressing files...');
        
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            // Add SQL file
            $zip->addFile($sqlFile, "database.sql");

            // Add Storage Files (Public Uploads)
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(public_path('storage')),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = 'files/' . substr($filePath, strlen(public_path('storage')) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            
            // Add .env (Optional/Sensitive - maybe ask user? safer to exclude for now unless requested)
            // $zip->addFile(base_path('.env'), '.env.backup');

            $zip->close();
            
            // Cleanup SQL file
            unlink($sqlFile);
            
            $this->info("Backup completed successfully: {$zipFile}");
        } else {
            $this->error('Failed to create Zip archive.');
            return 1;
        }
    }
}
