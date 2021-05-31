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
                <h1 class="title-font sm:text-3xl text-3xl mb-4 font-medium	 text-black">CHECKOUT</h1>
            </div>
            <!-- /title -->

            <div class="h-full">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 sm:col-span-12 md:col-span-7 lg:col-span-8 xxl:col-span-8">
                        <h4 class="py-4 px-8  my-4 mx-8 text-xl font-semibold mb-2">Select Shipping Address</h4>
                        <div class="bg-white py-4 px-4  my-4 mx-4">
                            <div class="flex justify-between px-4">
                                <div id="header" class="flex">
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio h-20 w-20" name="radio-sizes" value="" checked>
                                        <div id="body" class="flex flex-col ml-5">
                                            <h4 id="destName" class="text-xl font-semibold">Jonathan Liandi</h4>
                                            <p id="destPhone" class="text-gray-800">081298429811</p>
                                            <p id="destAddr" class="text-gray-800">Jl. Asia Afrika No.1, RT.1/RW.3, Gelora, Tanah Abang, Central Jakarta City, Jakarta 10270</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white py-4 px-4  my-4 mx-4">
                            <div class="flex justify-between px-4">
                                <div id="header" class="flex">
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio h-20 w-20" name="radio-sizes" value="">
                                        <div id="body" class="flex flex-col ml-5">
                                            <h4 id="destName" class="text-xl font-semibold">Adam</h4>
                                            <p id="destPhone" class="text-gray-800">082308239123</p>
                                            <p id="destAddr" class="text-gray-800">Jl. Kyai Maja, RT.11/RW.7, Gunung, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12120</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-4 xxl:col-span-4">
                        <div class="bg-white py-4 px-4 shadow-xl rounded-lg my-4 mx-4">
                            <div class="flex justify-between pt-4 ">
                                <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
                                    <p>Total Item</p>
                                </div>
                                <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
                                    <p id="totalItem">Rp.34.800.000</p>
                                </div>
                            </div>
                            <div class="flex justify-between pt-4">
                                <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-red-600">
                                    Discount
                                </div>
                                <div id="totalDisc" class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-red-600">
                                    Rp.3.000.000
                                </div>
                            </div>
                            <div class="flex justify-between pt-4 border-t">
                                <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
                                    Total
                                </div>
                                <div id="grandTotal" class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
                                    Rp.31.800.000
                                </div>
                            </div>
                        </div>

                        <div class="my-4 mx-4">
                            <a href="#">
                                <button class="flex justify-center w-full px-10 py-3 mt-6 font-medium text-white uppercase bg-gray-800  shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                                    <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor" d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z" />
                                    </svg>
                                    <span class="ml-2 mt-5px">Checkout</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-full">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 sm:col-span-12 md:col-span-7 lg:col-span-8 xxl:col-span-8">
                        <h4 class="py-4 px-8  my-4 mx-8 text-xl font-semibold mb-2">Product</h4>
                        <div class="bg-white py-4 px-4  my-4 mx-4 border-b">
                            <div class="flex justify-between px-4">
                                <div id="header" class="flex">
                                    <img alt="brandImage" class="flex-shrink-0 rounded-lg w-32 h-32 object-cover object-center sm:mb-0 mb-4" src="https://storage.seikowatches.com/image/2020/11/19044955398717/0/SPB053J1.png" />
                                    <div id="body" class="flex flex-col ml-5">
                                        <h4 id="brandName" class="text-xl font-semibold mt-2">Seiko Watch</h4>
                                        <p id="brandDesc" class="text-gray-800 mt-1">SPB053J1</p>
                                        <p id="brandPrice" class="text-gray-800 mt-1">Rp.15.000.000</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="bg-white py-4 px-4  my-4 mx-4 border-b">
                            <div class="flex justify-between px-4">
                                <div id="header" class="flex">
                                    <img alt="brandImage" class="flex-shrink-0 rounded-lg w-32 h-32 object-cover object-center sm:mb-0 mb-4" src="https://images.tokopedia.net/img/cache/700/product-1/2019/6/24/67875778/67875778_4a098925-2a79-41cc-adf3-17bf2b6d2f44_1080_1080.jpg" />
                                    <div id="body" class="flex flex-col ml-5">
                                        <h4 id="brandName" class="text-xl font-semibold mt-2">Seven Friday</h4>
                                        <p id="brandDesc" class="text-gray-800 mt-1">M2B/01 Official Jam Tangan Pria Revolution M-Series</p>
                                        <p id="ifBrandDisc" class="text-red-600 line-through mt-1">Rp19.800.000</p>
                                        <p id="brandPrice" class="text-gray-800 mt-1">Rp16.800.000</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-4 xxl:col-span-4">



                    </div>
                </div>
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



    @include('partials.footer')
</body>

</html>