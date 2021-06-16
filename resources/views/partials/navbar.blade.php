<div class="flex flex-col w-full py-4 border-b-4 border-gray-800 mb-10">
    <div class="flex flex-row justify-between container mx-auto mb-5">
        <div id="left" class="flex-none w-24"></div>
        <div id="center" class="flex-grow">
            <h1 id="logo" class="font-bold font-serif text-center text-4xl leading-normal">ASLISEMUA</h1>
        </div>
        <div id="right" class="flex flex-row justify-between text-right flex-none w-24">
            <div>
                <a class="block" href="/wishlist">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </a>
            </div>
            <div>
                <button>
                    <a class="block" href="/cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                </button>
            </div>
            {{-- TODO Filter menus by isLoggedIn state --}}
            <div class="group inline-block">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </button>
                <ul
                    class="bg-white border border-black transform scale-0 group-hover:scale-100 absolute
                    transition duration-150 ease-in-out origin-top min-w-32 right-5 z-10"
                >
                    <li class="px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">
                        <a class="block" href="/sign-in">
                            Login
                        </a>
                    </li>
                    <li class="px-3 py-2 text-sm hover:bg-gray-100 text-yellow-500 cursor-pointer">
                        <a class="block" href="/sign-up">
                            Register
                        </a>
                    </li>
                    <li class="px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">
                        <a class="block" href="/profile">
                            Profile
                        </a>
                    </li>
                    <li class="px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">My Purchases</li>
                    <li class="px-3 py-2 text-sm hover:bg-gray-100 text-red-500 cursor-pointer">Sign Out</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="flex flex-row justify-between container mx-auto">
        <div id="left2" class="flex-grow w-24"></div>
        <div id="center2" class="flex-grow-0">
            <ul class="flex flex-row mx-auto text-center justify-center">
                <li class="px-3 py-2"><a class="block" href="/new-arrivals">New Arrivals</a></li>
                <li class="px-3 py-2"><a class="block" href="/shop/Women">Women</a></li>
                <li class="px-3 py-2"><a class="block" href="/shop/Men">Men</a></li>
                <li class="px-3 py-2"><a class="block text-red-500 font-bold" href="/sale">Sale</a></li>
                <li class="px-3 py-2"><a class="block text-yellow-500 font-bold" href="/consign">Sell With Us</a></li>
            </ul>
        </div>
        <div id="right3" class="flex flex-row justify-between text-right flex-grow w-24">
        </div>
    </div>
</div>
