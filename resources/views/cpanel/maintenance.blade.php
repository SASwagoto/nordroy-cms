<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cPanel Maintenance & Deployment Hub | Nordroy CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-sky-600 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-sky-500/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                        cPanel Maintenance Hub
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-sky-500/10 text-sky-400 border border-sky-500/20 font-medium">Web Utility</span>
                    </h1>
                    <p class="text-xs text-slate-400">Zero-Terminal Web Route Utilities for cPanel Deployment & Server Maintenance</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-xs font-semibold px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:bg-slate-800 transition">
                    Visit Website &rarr;
                </a>
                <a href="{{ url('/admin/dashboard') }}" class="text-xs font-semibold px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-500 text-white shadow transition">
                    Admin Portal
                </a>
            </div>
        </div>

        @if(!$authorized)
            <!-- Unauthorized Alert -->
            <div class="bg-red-950/60 border border-red-500/30 rounded-2xl p-8 text-center space-y-4">
                <div class="w-14 h-14 mx-auto rounded-full bg-red-500/20 text-red-400 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-white">Access Key Required</h2>
                <p class="text-sm text-slate-300 max-w-md mx-auto">
                    This maintenance terminal is protected. To access on production without logging in, provide the security setup key parameter:
                </p>
                <div class="bg-slate-900 px-4 py-3 rounded-lg max-w-md mx-auto border border-slate-800 text-xs font-mono text-sky-400 select-all">
                    {{ url('/cpanel') }}?key=YOUR_SECRET_KEY
                </div>
                <p class="text-xs text-slate-500">Default key is configured in your <code class="text-slate-400">.env</code> as <code class="text-slate-400">CPANEL_SETUP_KEY=nordroy</code></p>
            </div>
        @else

            <!-- Alerts -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-teal-950/70 border border-teal-500/40 text-teal-200 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-teal-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <div class="font-bold text-teal-300">Operation Succeeded</div>
                        <div class="text-xs text-teal-200/90 mt-0.5">{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-950/70 border border-red-500/40 text-red-200 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <div class="font-bold text-red-300">Operation Error</div>
                        <div class="text-xs text-red-200/90 mt-0.5">{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="p-4 rounded-xl bg-amber-950/70 border border-amber-500/40 text-amber-200 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <div class="font-bold text-amber-300">Notice</div>
                        <div class="text-xs text-amber-200/90 mt-0.5">{{ session('warning') }}</div>
                    </div>
                </div>
            @endif

            <!-- System Health Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- PHP / Laravel Version -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Environment</div>
                    <div class="text-lg font-bold text-white mt-1">PHP {{ $phpVersion }}</div>
                    <div class="text-xs text-slate-500 mt-1">Laravel {{ $laravelVersion }} ({{ app()->environment() }})</div>
                </div>

                <!-- Database Status -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Database Connection</div>
                    @if($dbConnected)
                        <div class="text-lg font-bold text-emerald-400 mt-1 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span> Connected
                        </div>
                        <div class="text-xs text-slate-500 mt-1">Driver: {{ config('database.default') }}</div>
                    @else
                        <div class="text-lg font-bold text-red-400 mt-1 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Disconnected
                        </div>
                        <div class="text-xs text-red-400/80 mt-1 truncate" title="{{ $dbError }}">{{ $dbError }}</div>
                    @endif
                </div>

                <!-- Storage Link Status -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Storage Symlink</div>
                    @if($storageLinked)
                        <div class="text-lg font-bold text-emerald-400 mt-1 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Linked (OK)
                        </div>
                        <div class="text-xs text-slate-500 mt-1 font-mono">public/storage &rarr; active</div>
                    @else
                        <div class="text-lg font-bold text-amber-400 mt-1 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Missing Link
                        </div>
                        <div class="text-xs text-amber-400/80 mt-1">Click "Link Storage" below</div>
                    @endif
                </div>

                <!-- Database Backup -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">
                    <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">SQL Export File</div>
                    @if($sqlBackupExists)
                        <div class="text-lg font-bold text-sky-400 mt-1 flex items-center gap-1.5">
                            Ready ({{ $sqlBackupSize }})
                        </div>
                        <div class="text-xs text-slate-500 mt-1 font-mono">database_backup.sql</div>
                    @else
                        <div class="text-lg font-bold text-slate-400 mt-1">Not Generated</div>
                        <div class="text-xs text-slate-500 mt-1">Click "Download SQL" below</div>
                    @endif
                </div>
            </div>

            <!-- Directory Permissions Check -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    cPanel Directory Permissions Check (Must be writable for logging & caching)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($directories as $path => $writable)
                        <div class="p-3 rounded-lg border {{ $writable ? 'bg-slate-950/60 border-slate-800 text-slate-300' : 'bg-red-950/30 border-red-500/40 text-red-300' }} flex items-center justify-between text-xs">
                            <span class="font-mono">{{ $path }}</span>
                            @if($writable)
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-semibold">Writable</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-red-500/20 text-red-400 font-semibold">Read Only</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Action Hub (Zero SSH Required) -->
            <div>
                <h2 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    One-Click Server Actions (Direct Web Execution)
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <!-- Action 1: Clear All Caches -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-700 transition">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-white">Clear All Caches</h3>
                            <p class="text-xs text-slate-400">Clears application, config, route, view caches and flushes homepage settings memory cache.</p>
                            <div class="text-[11px] font-mono text-slate-500 pt-1">Route: /cpanel/clear-cache</div>
                        </div>
                        <div class="pt-4 mt-2 border-t border-slate-800">
                            <a href="{{ route('cpanel.clear-cache', ['key' => $key]) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs transition shadow">
                                Run Clear Cache
                            </a>
                        </div>
                    </div>

                    <!-- Action 2: Link Storage -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-700 transition">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-white">Storage Link</h3>
                            <p class="text-xs text-slate-400">Creates the public storage symlink (<code class="text-sky-300">public/storage</code>) so uploaded photos, media assets, and brochures load properly on the site.</p>
                            <div class="text-[11px] font-mono text-slate-500 pt-1">Route: /cpanel/storage-link</div>
                        </div>
                        <div class="pt-4 mt-2 border-t border-slate-800">
                            <a href="{{ route('cpanel.storage-link', ['key' => $key]) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs transition shadow">
                                Create Storage Link
                            </a>
                        </div>
                    </div>

                    <!-- Action 3: Optimize App -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-700 transition">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-white">Optimize Production Speed</h3>
                            <p class="text-xs text-slate-400">Pre-compiles routes, configuration, and events into cache for maximum response speed on live server.</p>
                            <div class="text-[11px] font-mono text-slate-500 pt-1">Route: /cpanel/optimize</div>
                        </div>
                        <div class="pt-4 mt-2 border-t border-slate-800">
                            <a href="{{ route('cpanel.optimize', ['key' => $key]) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs transition shadow">
                                Optimize Application
                            </a>
                        </div>
                    </div>

                    <!-- Action 4: Run Migrations -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-700 transition">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7M4 7c0-2 1.5-3 3.5-3h9c2 0 3.5 1 3.5 3M4 7h16m-8 4v6m-3-3h6"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-white">Run DB Migrations</h3>
                            <p class="text-xs text-slate-400">Safely runs <code class="text-indigo-300">php artisan migrate --force</code> on production to create/update tables without terminal.</p>
                            <div class="text-[11px] font-mono text-slate-500 pt-1">Route: /cpanel/migrate</div>
                        </div>
                        <div class="pt-4 mt-2 border-t border-slate-800">
                            <a href="{{ route('cpanel.migrate', ['key' => $key]) }}" onclick="return confirm('Run database migrations now?')" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition shadow">
                                Run Migrations
                            </a>
                        </div>
                    </div>

                    <!-- Action 5: Download Database SQL -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-700 transition">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-white">Download Database SQL</h3>
                            <p class="text-xs text-slate-400">Instantly exports and downloads complete SQL database file (.sql) with all 41 tables and initial data.</p>
                            <div class="text-[11px] font-mono text-slate-500 pt-1">Route: /cpanel/download-sql</div>
                        </div>
                        <div class="pt-4 mt-2 border-t border-slate-800 flex gap-2">
                            <a href="{{ route('cpanel.download-sql', ['key' => $key]) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow">
                                Download .SQL
                            </a>
                            <a href="{{ route('cpanel.download-sql', ['key' => $key, 'regenerate' => 1]) }}" title="Regenerate fresh dump" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition border border-slate-700">
                                Fresh Dump
                            </a>
                        </div>
                    </div>

                    <!-- Direct Shortcuts -->
                    <div class="bg-slate-900/50 border border-dashed border-slate-800 rounded-2xl p-5 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Direct URL Shortcuts</h3>
                            <p class="text-xs text-slate-500">You can also hit these clean routes directly in your browser address bar at any time:</p>
                            <ul class="text-xs space-y-1.5 font-mono text-slate-400">
                                <li class="truncate hover:text-white">&bull; <a href="{{ url('/storage-link') }}?key={{ $key }}" class="underline hover:text-sky-400">/storage-link?key={{ $key }}</a></li>
                                <li class="truncate hover:text-white">&bull; <a href="{{ url('/clear-cache') }}?key={{ $key }}" class="underline hover:text-sky-400">/clear-cache?key={{ $key }}</a></li>
                                <li class="truncate hover:text-white">&bull; <a href="{{ route('cpanel.optimize', ['key' => $key]) }}" class="underline hover:text-sky-400">/cpanel/optimize?key={{ $key }}</a></li>
                            </ul>
                        </div>
                        <div class="pt-3 text-[11px] text-slate-500">
                            Works with either logged-in admin session or secret key query parameter.
                        </div>
                    </div>

                </div>
            </div>

            <!-- Terminal Commands Card for Local/SSH users -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Terminal / Command Prompt Quick Reference
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-mono">
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 space-y-1">
                        <div class="text-slate-500 font-sans font-semibold">1. Database SQL Export (Artisan)</div>
                        <div class="text-emerald-400 select-all font-semibold">php artisan db:export</div>
                        <div class="text-slate-500 text-[11px] font-sans mt-1">Generates clean `database_backup.sql` automatically using mysqldump or PDO engine.</div>
                    </div>
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 space-y-1">
                        <div class="text-slate-500 font-sans font-semibold">2. Clear All Caches & Optimize</div>
                        <div class="text-sky-400 select-all font-semibold">php artisan optimize:clear</div>
                        <div class="text-sky-400 select-all font-semibold mt-1">php artisan optimize</div>
                    </div>
                </div>
            </div>

        @endif

        <!-- Footer -->
        <div class="text-center text-xs text-slate-500 border-t border-slate-900 pt-6">
            &copy; {{ date('Y') }} Nordroy Marine & Power Limited. Corporate CMS Deployment Utility.
        </div>
    </div>
</body>
</html>
