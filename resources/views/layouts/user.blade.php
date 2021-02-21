<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <!-- Styles -->
  </head>
  <body class="antialiased flex flex-col h-full">
    {{-- Web Navbar --}}
    <nav class="bg-white border-b-2 border-gray-900 pt-5">
      <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
          <div class="flex flex-1">
            <button class="p-2 block md:hidden text-gray-900 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View shopping cart</span>
              <!-- Heroicon name: shopping-cart -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </button>
          </div>
          <div class="flex flex-2 items-center justify-center sm:items-stretch sm:justify-center">
            <h1 class="text-4xl tracking-widest font-serif">ASLISEMUA</h1>
          </div>
          <div class="inset-y-0 flex-1 right-0 flex items-center justify-end md:pr-2 sm:static sm:inset-auto sm:pr-0">
            <button class="hidden md:block text-gray-900 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View wishlist</span>
              <!-- Heroicon name: heart -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </button>
            <button class="hidden md:block text-gray-900 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-offset-gray-800 focus:ring-white ml-3">
              <span class="sr-only">View shopping cart</span>
              <!-- Heroicon name: shopping-cart -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </button>
    
            <!-- Profile dropdown -->
            <div class="md:ml-3 relative p-2">
              <div>
                <button class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu" aria-haspopup="true">
                  <span class="sr-only">Open user menu</span>
                  <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </button>
              </div>
              <!--
                Profile dropdown panel, show/hide based on dropdown state.
    
                Entering: "transition ease-out duration-100"
                  From: "transform opacity-0 scale-95"
                  To: "transform opacity-100 scale-100"
                Leaving: "transition ease-in duration-75"
                  From: "transform opacity-100 scale-100"
                  To: "transform opacity-0 scale-95"
              -->
              <div id="user-menu-list" class="origin-top-right hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-10" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
          <div class="block lg:flex flex-1 relative">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
              <!-- Mobile menu button-->
              <button id="navigation-menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <!-- Icon when menu is closed. -->
                <!--
                  Heroicon name: outline/menu
      
                  Menu open: "hidden", Menu closed: "block"
                -->
                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Icon when menu is open. -->
                <!--
                  Heroicon name: outline/x
      
                  Menu open: "block", Menu closed: "hidden"
                -->
                <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
          <div class="flex flex-2 items-center justify-center sm:items-stretch sm:justify-center">
            <div class="hidden sm:block sm:ml-6">
              <div class="flex space-x-4">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-900 " -->
                <a href="#" class="capitalize text-gray-900  text-sm ">New Arrivals</a>
                <a href="#" class="capitalize text-gray-900  text-sm ">Women</a>
                <a href="#" class="capitalize text-gray-900  text-sm ">Men</a>
                <a href="#" class="capitalize text-red-800  text-sm ">Sale</a>
                <a href="#" class="capitalize text-yellow-400  text-sm ">Sell With Us</a>
              </div>
            </div>
          </div>
          <div class="flex flex-1 items-center justify-end pr-2">
            <form method="GET">
              @csrf
              <div class="relative text-gray-400 focus-within:text-gray-900">
                <input class="w-72 px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border" type="text" name="search" id="search" placeholder="Search...">
                <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                  <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--
        Mobile menu, toggle classes based on menu state.
    
        Menu open: "block", Menu closed: "hidden"
      -->
      <div class="hidden sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-900 " -->
          <a href="#" class="bg-gray-900 text-white block  text-base ">Dashboard</a>
          <a href="#" class="text-gray-900  block  text-base ">Team</a>
          <a href="#" class="text-gray-900  block  text-base ">Projects</a>
          <a href="#" class="text-gray-900  block  text-base ">Calendar</a>
        </div>
      </div>
    </nav>

    {{-- Mobile Navbar --}}
    <div class="flex flex-col w-full py-4 mb-10 visible md:invisible">

    </div>
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
    
    <div class="container mx-auto px-2 md:px-20">
      @yield('content')
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    @yield('script')
  </body>
</html>
