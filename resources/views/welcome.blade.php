<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Point of Sale modern untuk mengelola toko Anda dengan mudah. Mulai jualan dalam hitungan menit.">
    <title>TOKO RIZQI - Point of Sale Modern & Mudah Digunakan</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    {{-- Vite CSS & JS (must load first for Tailwind) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Flowbite CSS (load after Tailwind) --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    
    {{-- Additional styles for smooth scroll --}}
    <style>
        html {
            scroll-behavior: smooth;
        }
        /* Ensure backdrop-blur works */
        .backdrop-blur-md {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 antialiased">
    {{-- Navigation --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('/images/marketplace.png') }}" class="h-8 w-8 transition-transform group-hover:scale-110" alt="TOKO RIZQI Logo">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">TOKO RIZQI</span>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Beranda</a>
                    <a href="#features" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Fitur</a>
                    <a href="#how-it-works" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Cara Kerja</a>
                    <a href="#benefits" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Keuntungan</a>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex items-center space-x-3">
                    @guest
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Mulai Sekarang
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-500 dark:hover:bg-green-600">
                            Dashboard
                        </a>
                    @endauth
                    
                    {{-- Mobile Menu Button --}}
                    <button data-collapse-toggle="mobile-menu" type="button" class="md:hidden inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Buka menu</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
                <a href="#home" class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Beranda</a>
                <a href="#features" class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Fitur</a>
                <a href="#how-it-works" class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cara Kerja</a>
                <a href="#benefits" class="block px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Keuntungan</a>
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-blue-600 dark:text-blue-400">Masuk</a>
                @endguest
            </div>
        </div>
    </nav>

    <main>
        {{-- Hero Section --}}
        <section id="home" class="relative pt-24 pb-16 sm:pt-32 sm:pb-24 lg:pt-40 lg:pb-32 overflow-hidden">
            {{-- Background Gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmOWZhZmIiIGZpbGwtb3BhY2l0eT0iMC40Ij48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIi8+PC9nPjwvZz48L3N2Zz4=')] opacity-40 dark:opacity-10"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                    {{-- Content --}}
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl lg:text-7xl">
                            <span class="block">Kelola Toko Anda</span>
                            <span class="block text-blue-600 dark:text-blue-400 mt-2">Dengan Mudah</span>
                        </h1>
                        <p class="mt-6 text-lg text-gray-600 dark:text-gray-300 sm:text-xl max-w-2xl mx-auto lg:mx-0">
                            Aplikasi Point of Sale modern yang memudahkan Anda mengelola produk, transaksi, dan laporan penjualan. Mulai jualan dalam hitungan menit.
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            @guest
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:-translate-y-0.5">
                                    Mulai Gratis
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                                <a href="#features" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Pelajari Lebih Lanjut
                                </a>
                            @endguest
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform hover:-translate-y-0.5">
                                    Buka Dashboard
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            @endauth
                        </div>
                        {{-- Trust Indicators --}}
                        <div class="mt-12 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Mudah Digunakan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>100% Gratis</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Responsive</span>
                            </div>
                        </div>
                    </div>

                    {{-- Hero Image --}}
                    <div class="relative lg:block hidden">
                        <div class="relative z-10">
                            <img
                                src="{{ asset('images/hero_img.png') }}"
                                alt="TOKO RIZQI Point of Sale Dashboard"
                                class="w-full h-auto rounded-2xl shadow-2xl"
                                loading="eager"
                            />
                        </div>
                        {{-- Decorative Elements --}}
                        <div class="absolute -top-4 -right-4 w-72 h-72 bg-blue-200 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-xl opacity-30 animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-72 h-72 bg-indigo-200 dark:bg-indigo-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section id="features" class="py-24 sm:py-32 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-base font-semibold text-blue-600 dark:text-blue-400">Fitur Unggulan</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Semua yang Anda Butuhkan untuk Mengelola Toko
                    </p>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                        Aplikasi lengkap dengan fitur-fitur canggih yang memudahkan operasional toko Anda
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    {{-- Feature 1 --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Mudah Digunakan</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Tampilan yang simpel dan intuitif, mudah digunakan bahkan untuk pemula. Tidak perlu pelatihan khusus.
                        </p>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Manajemen Produk</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Kelola produk dengan mudah. Tambah, edit, hapus, dan kategorikan produk dengan beberapa klik saja.
                        </p>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008ZM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0012 2.25z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Kalkulasi Otomatis</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Sistem menghitung total belanjaan dan uang kembalian secara otomatis. Tidak perlu kalkulator manual.
                        </p>
                    </div>

                    {{-- Feature 4 --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Sistem Terintegrasi</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Dibangun dengan teknologi terbaru untuk keamanan dan performa optimal. Data Anda aman dan terjamin.
                        </p>
                    </div>

                    {{-- Feature 5 --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Riwayat Penjualan</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Catat dan kelola semua transaksi penjualan. Filter berdasarkan tanggal dan cari dengan mudah.
                        </p>
                    </div>

                    {{-- Feature 6 --}}
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:shadow-lg group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Responsive Design</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Akses dari desktop, tablet, atau smartphone. Tampilan optimal di semua perangkat.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- How It Works Section --}}
        <section id="how-it-works" class="py-24 sm:py-32 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-base font-semibold text-blue-600 dark:text-blue-400">Cara Kerja</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Mulai dalam 3 Langkah Sederhana
                    </p>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                        Proses yang cepat dan mudah untuk memulai menggunakan aplikasi
                    </p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                        {{-- Step 1 --}}
                        <div class="relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white text-2xl font-bold shadow-lg">
                                    1
                                </div>
                                <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Daftar Akun</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Buat akun gratis dalam hitungan detik. Tidak perlu kartu kredit atau biaya tersembunyi.
                                </p>
                            </div>
                            <div class="hidden lg:block absolute top-8 left-full w-full h-0.5 bg-gradient-to-r from-blue-600 to-blue-400 transform translate-x-4"></div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white text-2xl font-bold shadow-lg">
                                    2
                                </div>
                                <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Tambah Produk</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Mulai tambahkan produk Anda dengan mudah. Isi nama, kategori, dan harga produk.
                                </p>
                            </div>
                            <div class="hidden lg:block absolute top-8 left-full w-full h-0.5 bg-gradient-to-r from-blue-600 to-blue-400 transform translate-x-4"></div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="relative">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white text-2xl font-bold shadow-lg">
                                    3
                                </div>
                                <h3 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">Mulai Jualan</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Proses transaksi penjualan dengan cepat. Sistem menghitung total dan kembalian otomatis.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Benefits Section --}}
        <section id="benefits" class="py-24 sm:py-32 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                    <div>
                        <h2 class="text-base font-semibold text-blue-600 dark:text-blue-400">Mengapa Pilih Kami?</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                            Solusi Terbaik untuk Toko Anda
                        </p>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            Kami memahami kebutuhan bisnis Anda dan menyediakan solusi yang tepat untuk mengoptimalkan operasional toko.
                        </p>

                        <dl class="mt-10 space-y-6">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-base font-semibold text-gray-900 dark:text-white">100% Gratis</dt>
                                    <dd class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        Tidak ada biaya bulanan atau tersembunyi. Gunakan semua fitur tanpa batasan.
                                    </dd>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-base font-semibold text-gray-900 dark:text-white">Mudah & Cepat</dt>
                                    <dd class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        Setup dalam hitungan menit. Tidak perlu instalasi atau konfigurasi rumit.
                                    </dd>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-base font-semibold text-gray-900 dark:text-white">Aman & Terpercaya</dt>
                                    <dd class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        Data Anda aman dengan teknologi enkripsi terbaru dan backup otomatis.
                                    </dd>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-base font-semibold text-gray-900 dark:text-white">Dukungan Penuh</dt>
                                    <dd class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        Tim support siap membantu Anda kapan saja. Dokumentasi lengkap tersedia.
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                    <div class="relative lg:block hidden">
                        <div class="relative z-10 bg-gradient-to-br from-blue-50 to-indigo-50 dark:bg-gray-800 rounded-2xl p-8 border border-gray-200 dark:border-gray-700 shadow-lg dark:shadow-2xl">
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-600 dark:bg-blue-500 text-white flex items-center justify-center font-bold shadow-md dark:shadow-lg">1</div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Daftar Gratis</h4>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Cukup 30 detik</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-600 dark:bg-blue-500 text-white flex items-center justify-center font-bold shadow-md dark:shadow-lg">2</div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Setup Produk</h4>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Tambah produk pertama</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-600 dark:bg-blue-500 text-white flex items-center justify-center font-bold shadow-md dark:shadow-lg">3</div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Mulai Jualan</h4>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Proses transaksi pertama</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <section class="py-24 sm:py-32 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
                        Siap Memulai?
                    </h2>
                    <p class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                        Bergabunglah dengan ribuan toko yang sudah menggunakan TOKO RIZQI untuk mengelola bisnis mereka dengan lebih mudah dan efisien.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        @guest
                            <a href="{{ route('login') }}" class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transform hover:-translate-y-0.5">
                                Mulai Gratis Sekarang
                                <svg class="ml-2 w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                            <a href="#features" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-800 border-2 border-blue-600 dark:border-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                Pelajari Lebih Lanjut
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('dashboard') }}" class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transform hover:-translate-y-0.5">
                                Buka Dashboard
                                <svg class="ml-2 w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 dark:bg-black border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('/images/marketplace.png') }}" class="h-8 w-8" alt="TOKO RIZQI Logo">
                        <span class="text-xl font-bold text-white">TOKO RIZQI</span>
                    </div>
                    <p class="text-sm text-gray-400">
                        Aplikasi Point of Sale modern untuk mengelola toko Anda dengan mudah dan efisien.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-sm text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#features" class="text-sm text-gray-400 hover:text-white transition-colors">Fitur</a></li>
                        <li><a href="#how-it-works" class="text-sm text-gray-400 hover:text-white transition-colors">Cara Kerja</a></li>
                        <li><a href="#benefits" class="text-sm text-gray-400 hover:text-white transition-colors">Keuntungan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Akun</h3>
                    <ul class="space-y-2">
                        @guest
                            <li><a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Daftar</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} TOKO RIZQI. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- Flowbite JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    
    {{-- Smooth Scroll Script --}}
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Close mobile menu if open
                        const mobileMenu = document.getElementById('mobile-menu');
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });

            // Active navigation link on scroll
            window.addEventListener('scroll', () => {
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('nav a[href^="#"]');
                
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (window.pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('text-blue-600', 'dark:text-blue-400', 'font-semibold');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.add('text-blue-600', 'dark:text-blue-400', 'font-semibold');
                    }
                });
            });
        });
    </script>
</body>
</html>