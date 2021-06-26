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

        .work-sans {
            font-family: 'Work Sans', sans-serif;
        }

        #menu-toggle:checked+#menu {
            display: block;
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
    <main class=" pb-10 border-b-2 border-gray-700">

        <!-- blog -->
        <div class="w-full bg-white">

            <!-- title -->
            <div class="text-center px-6 py-2 mb-6">
                <h1 class="title-font sm:text-3xl text-3xl mb-4 font-medium	 text-black">ORDER PLACED</h1>
            </div>
            <!-- /title -->

            <section class="text-black">
                <div class="container mx-auto flex px-5 py-2 items-center justify-center flex-col">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg> -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <div class="text-center lg:w-2/3 w-full">
                        <h1 class="title-font sm:text-2xl text-2xl mb-4 font-medium	 text-black font-mono">
                            Congratulation! Your order has been placed. </h1>
                        <p class="leading-relaxed mb-8 font-normal">Out team will contact you soon and your invoice will be sent to your email.
                        </p>
                        <div class="flex justify-center">
                            <button class="border-2 border-black  text-black block rounded-sm font-bold py-4 px-6 mr-2 flex items-center hover:bg-gray-900 hover:text-white transition ease-in-out duration-700">
                                Shop Again
                            </button>
                        </div>
                    </div>
                </div>
            </section>



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



    @include('partials.footer')
</body>

</html>