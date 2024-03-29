<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Icon -->
        <link rel="stylesheet" href="{{ url('/css/icon.css') }}">

        <style>
          .dump_red{
            border: 1px solid red !important;
          }
          .dump_blue{
            border: 1px solid blue !important;
          }
        </style>
        @auth
        <script>sessionStorage.setItem('auth_username', '{{ Auth::user()->username }}')</script>
        @endauth

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- @stack('comment') --}}
        {{ $additional_script ?? '' }}
        <script type="module" defer>
          Alpine.start();
        </script>

    </head>
    <body class="relative font-sans antialiased">
      <div class="flex justify-center">
        <div class="h-screen bg-gray-1 max-w-7xl max-[320px]:w-11/12 max-[640px]:w-10/12 w-3/4 xl:w-6/12 relative">
        {{-- <div class="h-screen bg-gray-1 00 max-w-7xl max-[320px]:w-11/12 max-[640px]:w-9/12 w-1/2 xl:w-4/12 relative overflow-hidden"> --}}
            <!-- Page Heading -->
            <x-navigation-layout title="{{ $title ?? null }}"></x-navigation-layout>
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="relative" style="height: calc(100% - 4rem)">
                {{ $slot }}
            </main>
        </div>
        <div id="modal" active="none">
          <x-search-modal/>
          <x-location-modal/>
        </div>
      </div>
    </body>
</html>
