<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Laravel</title>

    <!-- Fonts -->

    <!-- Styles -->
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body class="antialiased h-full">
@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
        @endauth
    </div>
@endif
@include('partials.navbar')
<main class=" pb-10 border-b border-gray-700">
    <div class="flex flex-col container mx-auto">
        <section id="carousel" class="text-center mb-20">
            CAROUSEL SECTION
        </section>

        <section id="sale-banner" class=" mb-20">
            <img src="{{asset('/images/sale-banner.png')}}" class="w-full" alt="sale banner">
        </section>

        <section id="categories" class="flex flex-col text-center mb-20">
            <h2 class="font-serif text-3xl mb-10">CATEGORIES</h2>
            <div class="flex flex-row flex-wrap justify-between mb-5">
                @for ($i = 0; $i < 6; $i++)
                    <div class="flex flex-col">
                        <a href="#" class="">
                            <img src="https://via.placeholder.com/200" class="mb-2" alt="categories">
                            <div class="uppercase font-bold underline">Handbags</div>
                        </a>
                    </div>
                @endfor
            </div>
            <a href="/categories" class="uppercase mx-auto py-2 px-10 bg-gray-700 text-white">SEE ALL CATEGORIES</a>
        </section>

        <section id="new-arrivals" class="flex flex-col text-center mb-20">
            <h2 class="font-serif text-3xl mb-10">NEW ARRIVALS</h2>
            <div class="flex justify-between">SLIDER PRODUCT</div>
        </section>

        <section id="editors-pick" class="flex flex-col text-center mb-20">
            <h2 class="font-serif text-3xl mb-10">EDITOR'S PICK</h2>
            <div class="flex justify-between">
                <img src="{{asset('/images/editors-pick-1.png')}}" class="w-full mb-3" alt="Editors pick 1">
                <img src="{{asset('/images/editors-pick-2.png')}}" class="w-full mb-3" alt="Editors pick 2">
            </div>
        </section>
    </div>
</main>
<section class="flex flex-row justify-between container mx-auto py-10">
    <div class="w-1/2 flex flex-col text-center">
        <h2 class="font-serif text-3xl mb-3">Consign With Us</h2>
        <p class="mb-3">Receive up to 75% if each item's sale price</p>
        <a href="#" class="uppercase border border-gray-300 rounded p-2 mx-auto">CONSIGN</a>
    </div>
    <div class="w-1/2 flex flex-col text-center">
        <h2 class="font-serif text-3xl mb-3">Got Questions?</h2>
        <p class="mb-3">Email us at</p>
        <a href="mailto:aslisemua55@gmail.com" class="underline lowercase text-red-700">aslisemua55@gmail.com</a>
    </div>
</section>
</body>
</html>
