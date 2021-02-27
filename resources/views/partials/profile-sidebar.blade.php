<ul class="hidden md:flex flex-col w-56">
  <li class="text-lg {{ Route::currentRouteName() == 'profile.personal-info' ? 'font-bold' : 'font-normal' }} pr-4 py-2"><a class="block" href="{{route('profile.personal-info')}}">Personal Info</a></li>
  <li class="text-lg {{ Route::currentRouteName() == 'profile.my-purchases' ? 'font-bold' : 'font-normal' }} pr-4 py-2"><a class="block" href="{{route('profile.my-purchases')}}">My Purchases</a></li>
  <li class="text-lg {{ Route::currentRouteName() == 'profile.track-shipment' ? 'font-bold' : 'font-normal' }} pr-4 py-2"><a class="block" href="{{route('profile.track-shipment')}}">Track Shipment</a></li>
  {{-- <li class="text-lg pr-4 py-2"><a href="{{route('profile.consign')}}">Consign</a></li> --}}
  <li class="text-lg {{ Route::currentRouteName() == 'profile.address' ? 'font-bold' : 'font-normal' }} pr-4 py-2"><a class="block" href="{{route('profile.address')}}">Address</a></li>
</ul>

{{-- Mobile Menu --}}
<ul class="flex md:hidden flex-row justify-between w-full border-black border-b-2 mb-5">
  <li class="p-3">
    <a class="block" href="{{route('profile.personal-info')}}">
      <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
    </a>
  </li>
  <li class="p-3">
    <a class="block" href="{{route('profile.my-purchases')}}">
      <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
      </svg>
    </a>
  </li>
  <li class="p-3">
    <a class="block" href="{{route('profile.track-shipment')}}">
      <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path fill="#fff" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
      </svg>
    </a>
  </li>
  {{-- <li class="p-3"><a href="{{route('profile.consign')}}">Consign</a></li> --}}
  <li class="p-3">
    <a class="block" href="{{route('profile.address')}}">
      <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </a>
  </li>
</ul>