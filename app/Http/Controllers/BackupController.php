<?php

namespace App\Http\Controllers;

use ZipArchive;

class BackupController extends Controller
{
    public function run()
    {
        // Authorization: admin only
        abort_unless(auth()->user()->can('admin'), 403);

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        // Resolve mysqldump binary path
        // Priority: 1) env variable, 2) common Windows paths, 3) system PATH
        $mysqldump = env('MYSQLDUMP_PATH', $this->findMysqldump());

        $timestamp  = now()->format('Ymd_His');
        $sqlFile    = 'backup_' . $dbName . '_' . $timestamp . '.sql';
        $zipFile    = 'backup_' . $dbName . '_' . $timestamp . '.zip';
        $sqlPath    = storage_path('app/' . $sqlFile);
        $zipPath    = storage_path('app/' . $zipFile);

        $command = sprintf(
            '%s --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s > %s 2>&1',
            escapeshellarg($mysqldump),
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($sqlPath)
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || !file_exists($sqlPath) || filesize($sqlPath) === 0) {
            @unlink($sqlPath);
            $detail = !empty($output) ? ' Detalle: ' . implode(' ', array_slice($output, 0, 2)) : '';
            return back()->with('error', 'Error al generar el backup.' . $detail);
        }

        // Compress SQL into ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            @unlink($sqlPath);
            return back()->with('error', 'Error al comprimir el backup. Verificá los permisos de storage.');
        }

        $zip->addFile($sqlPath, $sqlFile);
        $zip->close();
        @unlink($sqlPath);

        if (!file_exists($zipPath) || filesize($zipPath) === 0) {
            return back()->with('error', 'El archivo ZIP no pudo generarse correctamente.');
        }

        return response()->download($zipPath, $zipFile, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Try to find mysqldump in common installation paths on Windows/Linux.
     */
    private function findMysqldump(): string
    {
        $candidates = [
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.4\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysqldump.exe',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
        ];

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Fall back to hoping it's in PATH
        return 'mysqldump';
    }
}
