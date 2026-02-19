<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', '저숙련자 지원 DataPlatform ') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans antialiased selection:bg-indigo-500 selection:text-white">
    <div class="relative min-h-screen flex flex-col">
        <!-- Header -->
        <header class="container mx-auto px-6 py-6 flex justify-between items-center relative z-10">
            <div class="flex items-center">
                 <span class="text-2xl font-bold tracking-tight text-white">저숙련자 지원 DataPlatform -  (주)코탁스, (주)미래아이티, (주)프라젠</span>
            </div>
            @if (Route::has('login'))
                <nav class="flex gap-4 items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-medium hover:text-indigo-400 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium hover:text-indigo-400 transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-medium transition shadow-lg shadow-indigo-500/30">Get Started</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Hero Section -->
        <main class="flex-grow container mx-auto px-6 flex flex-col lg:flex-row items-center justify-center gap-12 py-12 lg:py-20">
            <div class="lg:w-1/2 space-y-8 text-center lg:text-left z-10">
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">
                    Unlock Real-time <br />
                    Data Insights
                </h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto lg:mx-0">
                    Transform your raw data into actionable intelligence with our advanced analytics platform. Secure, scalable, and built for teams.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-lg font-semibold transition shadow-lg shadow-indigo-500/20">Start Analyzing</a>
                    <a href="#" class="px-8 py-4 bg-gray-800 hover:bg-gray-700 rounded-xl text-lg font-semibold transition border border-gray-700">View Demo</a>
                </div>
            </div>
            <div class="lg:w-1/2 relative flex justify-center">
                <!-- Decorative blur -->
                <div class="absolute -inset-4 bg-indigo-500/20 blur-3xl rounded-full opacity-50"></div>
                 <img src="{{ asset('svg/main_cg.svg') }}" alt="Data Visualization" class="relative z-10 max-w-full h-auto hover:scale-105 transition duration-500 drop-shadow-2xl" />
            </div>
        </main>

        <!-- Features Section -->
        <section class="container mx-auto px-6 py-20 border-t border-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-gray-800/50 hover:bg-gray-800 transition border border-gray-700 hover:border-indigo-500/30 group cursor-default">
                    <div class="w-12 h-12 bg-indigo-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                         <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Real-time Analytics</h3>
                    <p class="text-gray-400 leading-relaxed">Monitor your key performance indicators in real-time with our low-latency data streaming engine.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-gray-800/50 hover:bg-gray-800 transition border border-gray-700 hover:border-indigo-500/30 group cursor-default">
                    <div class="w-12 h-12 bg-indigo-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Enterprise Security</h3>
                    <p class="text-gray-400 leading-relaxed">Bank-grade encryption and role-based access control to keep your sensitive data safe and compliant.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-gray-800/50 hover:bg-gray-800 transition border border-gray-700 hover:border-indigo-500/30 group cursor-default">
                    <div class="w-12 h-12 bg-indigo-900/50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Collaborative Workspaces</h3>
                    <p class="text-gray-400 leading-relaxed">Share insights and work together with your team in shared dashboards and reports.</p>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="container mx-auto px-6 py-8 text-center text-gray-600 text-sm">
            &copy; 2025 COTAX. All rights reserved.
        </footer>
    </div>
</body>
</html>
