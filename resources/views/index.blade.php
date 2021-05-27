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

        .hover\:grow {
            transition: all 0.3s;
            transform: scale(1);
        }

        .hover\:grow:hover {
            transform: scale(1.02);
        }

        .carousel-open:checked+.carousel-item {
            position: static;
            opacity: 100;
        }

        .carousel-item {
            -webkit-transition: opacity 0.6s ease-out;
            transition: opacity 0.6s ease-out;
        }

        #carousel-1:checked~.control-1,
        #carousel-2:checked~.control-2,
        #carousel-3:checked~.control-3 {
            display: block;
        }

        .carousel-indicators {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            bottom: 2%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        #carousel-1:checked~.control-1~.carousel-indicators li:nth-child(1) .carousel-bullet,
        #carousel-2:checked~.control-2~.carousel-indicators li:nth-child(2) .carousel-bullet,
        #carousel-3:checked~.control-3~.carousel-indicators li:nth-child(3) .carousel-bullet {
            color: #000;
            /*Set to match the Tailwind colour you want the active one to be */
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


            <section id="sale-banner" class=" mb-20">
                <div class="carousel relative container mx-auto" style="max-width:1600px;">
                    <div class="carousel-inner relative overflow-hidden w-full">
                        <!--Slide 1-->
                        <input class="carousel-open" type="radio" id="carousel-1" name="carousel" aria-hidden="true" hidden="" checked="checked">
                        <div class="carousel-item absolute opacity-0" style="height:50vh;">
                            <div class="block h-full w-full mx-auto flex pt-6 md:pt-0 md:items-center bg-cover bg-right">
                                <img src="{{asset('/images/carosel-1.jpg')}}" alt="carosel-1">
                                <div class="container mx-auto">
                                    <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                                        <p class="text-black text-2xl my-4">Your text goes here</p>
                                        <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="carousel-3" class="prev control-1 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
                        <label for="carousel-2" class="next control-1 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900 leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

                        <!--Slide 2-->
                        <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
                        <div class="carousel-item absolute opacity-0 bg-cover bg-right" style="height:50vh;">
                            <div class="block h-full w-full mx-auto flex pt-6 md:pt-0 md:items-center bg-cover bg-right">
                                <img src="{{asset('/images/carosel-2.jpg')}}" alt="carosel-2">
                                <div class="container mx-auto">
                                    <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                                        <p class="text-black text-2xl my-4">Your text goes here</p>
                                        <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <label for="carousel-1" class="prev control-2 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
                        <label for="carousel-3" class="next control-2 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

                        <!--Slide 3-->
                        <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
                        <div class="carousel-item absolute opacity-0" style="height:50vh;">
                            <div class="block h-full w-full mx-auto flex pt-6 md:pt-0 md:items-center bg-cover bg-bottom">
                                <img src="{{asset('/images/carosel-5.jpg')}}" alt="carosel-3">
                                <div class="container mx-auto">
                                    <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                                        <p class="text-black text-2xl my-4">Your text goes here</p>
                                        <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#">view product</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <label for="carousel-2" class="prev control-3 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
                        <label for="carousel-1" class="next control-3 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-gray-900  leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

                        <!-- Add additional indicators for each slide-->
                        <ol class="carousel-indicators">
                            <li class="inline-block mr-3">
                                <label for="carousel-1" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                            </li>
                            <li class="inline-block mr-3">
                                <label for="carousel-2" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                            </li>
                            <li class="inline-block mr-3">
                                <label for="carousel-3" class="carousel-bullet cursor-pointer block text-4xl text-gray-400 hover:text-gray-900">•</label>
                            </li>
                        </ol>

                    </div>
                </div>
            </section>

            <section id="categories" class="flex flex-col text-center mb-20">
                <h2 class="font-serif text-3xl mb-10">CATEGORIES</h2>
                <div class="flex flex-row flex-wrap justify-between mb-5">
                    @for ($i = 0; $i < 6; $i++) <div class="flex flex-col">
                        <a href="#" class="">
                            <img src="https://via.placeholder.com/200" class="mb-2" alt="categories">
                            <div class="uppercase font-bold underline">Handbags</div>

                            <div class="no-underline">Size : M</div>
                            <div class="text-yellow-400 line-through">Rp 13.000.000</div>
                            <div class="text-red-600 line-through">50% off - Rp 6.500.000</div>

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

    
        <!-- footer -->
        <footer class="w-full bg-gray-900 border-t">
            <div class="container mx-auto max-w-8xl h-full flex flex-wrap md:flex-no-wrap justify-between items-start text-sm p-6 pt-8 pb-4">
                <div class="mb-4 text-white">
                    <h4 class="mb-4 text-white font-bold">Company</h4>
                    <a href="#" class="block text-white mb-2">About us</a>
                    <a href="#" class="block text-white mb-2">Tern of Services</a>
                </div>
                <div class="mb-4">

                    <h4 class="mb-4 text-white font-bold">Categories</h4>
                    <a href="#" class="block text-white mb-2">Jewelry</a>
                    <a href="#" class="block text-white mb-2">Handbags</a>
                    <a href="#" class="block text-white mb-2">Shoes</a>
                    <a href="#" class="block text-white mb-2">Wathces</a>
                    <a href="#" class="block text-white mb-2">Accesories</a>
                </div>

                <div class="mb-4">

                    <h4 class="mb-4 text-white font-bold">Customer Care</h4>
                    <a href="#" class="block text-white mb-2">Contact Us</a>
                    <a href="#" class="block text-white mb-2">Term & Conditions</a>
                    <a href="#" class="block text-white mb-2">Privacy</a>
                    <a href="#" class="block text-white mb-2">Consignor Term</a>
                </div>
                
                <div class="mb-4">
                    <h4 class="mb-4 text-white font-bold">Payment Method</h4>

                   
                </div>
                <div class="mb-4">
                    <h4 class="mb-4 text-white font-bold text-4xl font-serif ">ASLISEMUA</h4>

                 
                </div>

            </div>
        </footer>
        <!-- /footer -->

        <!-- footer -->
        <footer class="w-full bg-white px-12 border-t">
            <div class="container mx-auto max-w-8xl py-6 flex flex-wrap md:flex-no-wrap justify-between items-center text-sm">
                All items are pre-owned and consigned to The RealReal. Trademarks are owned by their respective brand ownews. No Brand owner endorses or sponsors this ad or has any assosiation and/or affiliation with Aslisemua &copy;2021 
              
            </div>
        </footer>
        <!-- /footer -->
   
</body>

</html>