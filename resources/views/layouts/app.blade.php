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
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
      <div class="flex justify-center">
        {{-- <div class="min-h-screen bg-white w-full sm:w-1/2 border-4 border-slate-500 rounded-lg p-1"> --}}
        <div class="min-h-screen bg-gray-100 max-w-7xl max-[320px]:w-11/12 max-[640px]:w-9/12 w-1/2 xl:w-4/12 relative">
            {{-- @include('layouts.navigation') --}}
            <!-- Page Heading -->
            <x-navigation-layout title="{{ $title ?? null }}"></x-navigation-layout>
            {{-- @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

            <!-- Page Content -->
            <main class="relative">
            {{-- <main class="h-5/6 relative"> --}}
                {{ $slot }}
            </main>

            @stack('addPost')
        </div>
      </div>
    </body>
</html>
