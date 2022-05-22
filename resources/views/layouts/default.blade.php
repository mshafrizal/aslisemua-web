<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <title>@yield('page-title') {{config('app.name')}}</title>

  <!-- Fonts -->
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }
  </style>
  <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{config('midtrans.client_key')}}"></script>
  @yield('head-resources')
</head>

<body class="antialiased h-full">
  {{--@if (Route::has('login'))--}}
  {{-- <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">--}}
  {{-- @auth--}}
  {{-- <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>--}}
  {{-- @else--}}
  {{-- <a href="{{ route('signin') }}" class="text-sm text-gray-700 underline">Login</a>--}}

  {{-- @if (Route::has('register'))--}}
  {{-- <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>--}}
  {{-- @endif--}}
  {{-- @endauth--}}
  {{-- </div>--}}
  {{--@endif--}}
  {{--@include('partials.navbar')--}}
  {{--<main class=" pb-10 border-b border-gray-700" id="userApp">--}}
  {{-- <div class="flex flex-col container mx-auto">--}}
  {{-- @yield('content')--}}
  {{-- </div>--}}
  {{--</main>--}}

  {{--@section('footer')--}}
  {{--<section class="flex flex-row justify-between container mx-auto py-10">--}}
  {{-- <div class="w-1/2 flex flex-col text-center">--}}
  {{-- <h2 class="font-serif text-3xl mb-3">Consign With Us</h2>--}}
  {{-- <p class="mb-3">Receive up to 75% if each item's sale price</p>--}}
  {{-- <a href="#" class="uppercase border border-gray-300 rounded p-2 mx-auto">CONSIGN</a>--}}
  {{-- </div>--}}
  {{-- <div class="w-1/2 flex flex-col text-center">--}}
  {{-- <h2 class="font-serif text-3xl mb-3">Got Questions?</h2>--}}
  {{-- <p class="mb-3">Email us at</p>--}}
  {{-- <a href="mailto:aslisemua55@gmail.com" class="underline lowercase text-red-700">aslisemua55@gmail.com</a>--}}
  {{-- </div>--}}
  {{--</section>--}}

  <main id="userApp">
  </main>
  @yield('footer')

  <script src="{{asset('js/app.js')}}"></script>
  @yield('bottom-resources')
</body>

</html>