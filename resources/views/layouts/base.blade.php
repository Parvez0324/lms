<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'KAN LMS'))</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter (English) | Cairo & Tajawal (Arabic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700;1,800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', '"Cairo"', '"Tajawal"', 'system-ui', 'sans-serif'],
                        arabic: ['"Cairo"', '"Tajawal"', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js for Dashboards & Reports -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html[dir="rtl"] * {
            font-family: 'Cairo', 'Tajawal', system-ui, -apple-system, sans-serif !important;
        }
        html[dir="ltr"] * {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        input, textarea, select {
            font-weight: 400 !important;
        }
        input::placeholder, textarea::placeholder {
            font-weight: 400 !important;
        }
        /* Hide scrollbar utility */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Clean Smooth Scrollbar for main content */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full antialiased text-slate-900 bg-slate-50 selection:bg-brand-500 selection:text-white">
    
    <!-- Flash Messages / Toast Alerts -->
    <div class="fixed top-4 right-4 z-50 flex flex-col space-y-2 max-w-md w-full" x-data="{ show: true }">
        @if(session('success'))
            <div x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="bg-emerald-600 text-white p-4 rounded-2xl shadow-xl flex items-center justify-between transition-all transform ease-out duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/50 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-200 hover:text-white ml-3">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-show="show" x-init="setTimeout(() => show = false, 6000)" 
                 class="bg-rose-600 text-white p-4 rounded-2xl shadow-xl flex items-center justify-between transition-all transform ease-out duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-500/50 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-rose-200 hover:text-white ml-3">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div x-show="show" x-init="setTimeout(() => show = false, 7000)" 
                 class="bg-amber-600 text-white p-4 rounded-2xl shadow-xl flex items-start justify-between transition-all transform ease-out duration-300">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Please check the errors below:</p>
                        <ul class="text-xs mt-1 list-disc list-inside space-y-0.5 text-amber-100">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button @click="show = false" class="text-amber-200 hover:text-white ml-3">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
    </div>

    @yield('body')

    <!-- Lucide Icon Initializer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
        document.addEventListener('alpine:initialized', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
