<?php

namespace App\Http\Controllers;

use App\Console\Commands\ExportDatabaseCommand;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CPanelMaintenanceController extends Controller
{
    /**
     * Check authorization via session or secret setup key.
     */
    protected function authorizeAccess(Request $request): bool
    {
        $secretKey = env('CPANEL_SETUP_KEY', 'nordroy');
        $keyParam = $request->query('key') ?: $request->header('X-CPanel-Key');

        if ($keyParam && hash_equals((string)$secretKey, (string)$keyParam)) {
            return true;
        }

        if (Auth::check() && (Auth::user()->can('settings.manage') || Auth::user()->hasRole('super-admin'))) {
            return true;
        }

        if (app()->environment('local')) {
            return true;
        }

        return false;
    }

    /**
     * cPanel Maintenance Hub Dashboard
     */
    public function index(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            return response()->view('cpanel.maintenance', [
                'authorized' => false,
                'key' => $request->query('key'),
            ], 403);
        }

        $key = $request->query('key') ?: (app()->environment('local') ? 'nordroy' : '');

        // Diagnostics
        $storageLinked = File::exists(public_path('storage'));
        $dbConnected = false;
        $dbError = null;
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Throwable $e) {
            $dbError = $e->getMessage();
        }

        $directories = [
            'storage/app/public' => is_writable(storage_path('app/public')),
            'storage/framework'  => is_writable(storage_path('framework')),
            'storage/logs'       => is_writable(storage_path('logs')),
            'bootstrap/cache'    => is_writable(base_path('bootstrap/cache')),
        ];

        $sqlBackupExists = File::exists(base_path('database_backup.sql'));
        $sqlBackupSize = $sqlBackupExists ? round(File::size(base_path('database_backup.sql')) / 1024, 1) . ' KB' : null;

        return view('cpanel.maintenance', [
            'authorized'      => true,
            'key'             => $key,
            'storageLinked'   => $storageLinked,
            'dbConnected'     => $dbConnected,
            'dbError'         => $dbError,
            'directories'     => $directories,
            'sqlBackupExists' => $sqlBackupExists,
            'sqlBackupSize'   => $sqlBackupSize,
            'phpVersion'      => PHP_VERSION,
            'laravelVersion'  => app()->version(),
        ]);
    }

    /**
     * Clear all caches (config, cache, route, view, setting).
     */
    public function clearCache(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            abort(403, 'Unauthorized access. Provide ?key=nordroy or login as administrator.');
        }

        $output = [];

        try {
            Artisan::call('optimize:clear');
            $output[] = trim(Artisan::output());

            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            
            // Clear CMS runtime settings cache
            Setting::flushCache();
            $output[] = 'CMS Settings Cache Flushed.';

            $message = 'All Application, Config, Route, View, and Settings Caches Cleared Successfully!';
            $status = 'success';
        } catch (\Throwable $e) {
            $message = 'Cache Clear Encountered an Error: ' . $e->getMessage();
            $status = 'error';
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => $status,
                'message' => $message,
                'output'  => implode("\n", $output),
            ]);
        }

        $key = $request->query('key') ?: (app()->environment('local') ? 'nordroy' : '');
        return redirect()->route('cpanel.hub', ['key' => $key])
            ->with($status, $message);
    }

    /**
     * Create storage symlink or fallback structure.
     */
    public function storageLink(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            abort(403, 'Unauthorized access. Provide ?key=nordroy or login as administrator.');
        }

        $target = storage_path('app/public');
        $link = public_path('storage');
        $messages = [];
        $status = 'success';

        try {
            if (File::exists($link)) {
                $messages[] = "The [public/storage] link or directory already exists.";
            } else {
                Artisan::call('storage:link');
                $artisanOutput = trim(Artisan::output());
                $messages[] = $artisanOutput ?: "Artisan storage:link executed.";

                // Fallback if artisan link didn't create link
                if (!File::exists($link) && function_exists('symlink')) {
                    @symlink($target, $link);
                    if (File::exists($link)) {
                        $messages[] = "Manual symlink fallback succeeded: [{$link}] -> [{$target}].";
                    }
                }
            }

            if (!File::exists($link)) {
                $status = 'warning';
                $messages[] = "Warning: [public/storage] could not be linked. Ensure symlink() is enabled in php.ini on cPanel.";
            } else {
                $messages[] = "Storage successfully connected to public web directory!";
            }
        } catch (\Throwable $e) {
            $status = 'error';
            $messages[] = 'Storage link failed: ' . $e->getMessage();
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'   => $status,
                'messages' => $messages,
            ]);
        }

        $key = $request->query('key') ?: (app()->environment('local') ? 'nordroy' : '');
        return redirect()->route('cpanel.hub', ['key' => $key])
            ->with($status, implode(' ', $messages));
    }

    /**
     * Optimize application (route, config caches).
     */
    public function optimize(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            abort(403, 'Unauthorized access. Provide ?key=nordroy or login as administrator.');
        }

        try {
            Artisan::call('optimize');
            $message = 'Application successfully optimized for production speed! ' . trim(Artisan::output());
            $status = 'success';
        } catch (\Throwable $e) {
            $message = 'Optimization failed: ' . $e->getMessage();
            $status = 'error';
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $key = $request->query('key') ?: (app()->environment('local') ? 'nordroy' : '');
        return redirect()->route('cpanel.hub', ['key' => $key])
            ->with($status, $message);
    }

    /**
     * Run database migrations safely.
     */
    public function migrate(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            abort(403, 'Unauthorized access. Provide ?key=nordroy or login as administrator.');
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $message = 'Database migrations executed: ' . (trim(Artisan::output()) ?: 'Nothing to migrate.');
            $status = 'success';
        } catch (\Throwable $e) {
            $message = 'Migration error: ' . $e->getMessage();
            $status = 'error';
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        $key = $request->query('key') ?: (app()->environment('local') ? 'nordroy' : '');
        return redirect()->route('cpanel.hub', ['key' => $key])
            ->with($status, $message);
    }

    /**
     * Download or generate SQL backup on the fly.
     */
    public function downloadSql(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            abort(403, 'Unauthorized access. Provide ?key=nordroy or login as administrator.');
        }

        $backupPath = base_path('database_backup.sql');

        // Regenerate if requested or doesn't exist
        if ($request->has('regenerate') || !File::exists($backupPath) || File::size($backupPath) === 0) {
            try {
                $sql = ExportDatabaseCommand::generateSqlDump();
                File::put($backupPath, $sql);
            } catch (\Throwable $e) {
                return response('SQL Generation Error: ' . $e->getMessage(), 500);
            }
        }

        $downloadFilename = 'corporate_cms_db_' . date('Y_m_d_His') . '.sql';

        return response()->download($backupPath, $downloadFilename, [
            'Content-Type' => 'application/sql',
        ]);
    }
}
