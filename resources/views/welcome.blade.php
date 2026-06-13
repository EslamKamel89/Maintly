<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>
        {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
    </title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

</head>

<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-white min-h-screen overflow-x-hidden">

    <!-- Background -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute top-0 left-1/2 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-primary-500/15 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-[400px] w-[400px] rounded-full bg-primary-400/10 blur-3xl"></div>
    </div>

    <!-- Navigation -->
    <header class="border-b border-gray-200/70 dark:border-gray-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-600 text-white font-bold">
                        M
                    </div>

                    <div>
                        <h1 class="font-bold text-lg">
                            {{ config('app.name') }}
                        </h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Maintenance Management System
                        </p>
                    </div>
                </div>

                @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                    <a href="{{ route('filament.dashboard.pages.dashboard') }}"
                        class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-primary-600/20 transition hover:scale-105">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-900">
                        Login
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-primary-600/20 transition hover:scale-105">
                        Get Started
                    </a>
                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative">
        <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8 lg:py-32">
            <div class="mx-auto max-w-4xl text-center">

                <div
                    class="inline-flex items-center rounded-full border border-primary-500/20 bg-primary-500/10 px-4 py-1 text-sm font-medium text-primary-600 dark:text-primary-400">
                    Modern Maintenance Operations Platform
                </div>

                <h1
                    class="mt-8 text-5xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl lg:text-7xl">
                    Manage Customers,
                    Assets &
                    Work Orders
                    <span class="text-primary-600">In One Place.</span>
                </h1>

                <p
                    class="mx-auto mt-8 max-w-2xl text-lg leading-8 text-gray-600 dark:text-gray-400">
                    Built for HVAC companies, facility management teams, maintenance contractors,
                    and service businesses. Track customers, locations, assets, technicians, and
                    work orders from a single dashboard.
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">

                    @auth
                    <a href="{{ route('filament.dashboard.pages.dashboard') }}"
                        class="rounded-2xl bg-primary-600 px-8 py-4 font-semibold text-white shadow-xl shadow-primary-600/25 transition hover:scale-105">
                        Open Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="rounded-2xl bg-primary-600 px-8 py-4 font-semibold text-white shadow-xl shadow-primary-600/25 transition hover:scale-105">
                        Start Managing Today
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-2xl border border-gray-300 px-8 py-4 font-semibold hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-900">
                        Create Organization
                    </a>
                    @endif
                    @endauth

                </div>
            </div>

            <!-- Dashboard Mockup -->
            <div class="mt-24">
                <div
                    class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900">

                    <div
                        class="flex items-center gap-2 border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <div class="h-3 w-3 rounded-full bg-red-400"></div>
                        <div class="h-3 w-3 rounded-full bg-yellow-400"></div>
                        <div class="h-3 w-3 rounded-full bg-green-400"></div>
                    </div>

                    <div class="grid gap-6 p-6 lg:grid-cols-4">
                        <div class="rounded-2xl bg-primary-50 p-6 dark:bg-primary-950/40">
                            <p class="text-sm text-gray-500">Customers</p>
                            <h3 class="mt-2 text-3xl font-bold">124</h3>
                        </div>

                        <div class="rounded-2xl bg-primary-50 p-6 dark:bg-primary-950/40">
                            <p class="text-sm text-gray-500">Locations</p>
                            <h3 class="mt-2 text-3xl font-bold">312</h3>
                        </div>

                        <div class="rounded-2xl bg-primary-50 p-6 dark:bg-primary-950/40">
                            <p class="text-sm text-gray-500">Assets</p>
                            <h3 class="mt-2 text-3xl font-bold">1,248</h3>
                        </div>

                        <div class="rounded-2xl bg-primary-50 p-6 dark:bg-primary-950/40">
                            <p class="text-sm text-gray-500">Open Work Orders</p>
                            <h3 class="mt-2 text-3xl font-bold">48</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="border-t border-gray-200 py-24 dark:border-gray-800">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="text-center">
                <h2 class="text-3xl font-bold">
                    Everything Your Maintenance Team Needs
                </h2>

                <p class="mt-4 text-gray-600 dark:text-gray-400">
                    Designed for real-world maintenance operations.
                </p>
            </div>

            <div class="mt-16 grid gap-6 md:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-3xl border border-gray-200 p-6 dark:border-gray-800">
                    <h3 class="font-semibold">Customer Management</h3>
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        Organize customers, contacts, and service history.
                    </p>
                </div>

                <div class="rounded-3xl border border-gray-200 p-6 dark:border-gray-800">
                    <h3 class="font-semibold">Location Tracking</h3>
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        Manage buildings, facilities, branches, and sites.
                    </p>
                </div>

                <div class="rounded-3xl border border-gray-200 p-6 dark:border-gray-800">
                    <h3 class="font-semibold">Asset Registry</h3>
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        Track HVAC units, generators, pumps, elevators, and more.
                    </p>
                </div>

                <div class="rounded-3xl border border-gray-200 p-6 dark:border-gray-800">
                    <h3 class="font-semibold">Work Orders</h3>
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        Assign technicians and monitor work from start to completion.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="pb-24">
        <div class="mx-auto max-w-5xl px-6">
            <div
                class="rounded-3xl bg-gradient-to-r from-primary-600 to-primary-500 px-8 py-16 text-center text-white shadow-2xl">

                <h2 class="text-4xl font-bold">
                    Ready to streamline your maintenance operations?
                </h2>

                <p class="mx-auto mt-4 max-w-2xl text-primary-100">
                    Centralize customers, locations, assets, and work orders in a single modern platform.
                </p>

                <div class="mt-8">
                    @auth
                    <a href="{{ route('filament.dashboard.pages.dashboard') }}"
                        class="inline-flex items-center rounded-2xl border border-white/20 bg-white/10 px-8 py-4 font-semibold text-white backdrop-blur-sm transition">
                        Go To Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center rounded-2xl border border-white/20 bg-white/10 px-8 py-4 font-semibold text-white backdrop-blur-sm transition ">
                        Get Started
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

</body>

</html>