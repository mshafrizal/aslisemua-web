@extends('layouts.user')

@section('content')
    <div class="flex flex-col">
      <div class="border-b-2 pb-2 mb-4">
        <h1 class="text-3xl font-serif">Hello, Jonathan Morningstar</h1>
        <p class="text-lg">Member since 2020</p>
      </div>

      <div class="flex flex-col md:flex-row md:space-x-10">
        <ul class="hidden md:flex flex-col w-56">
          <li class="text-lg font-bold pr-4 py-2"><a class="block" href="{{route('profile.personal-info')}}">Personal Info</a></li>
          <li class="text-lg pr-4 py-2"><a class="block" href="{{route('profile.my-purchases')}}">My Purchases</a></li>
          <li class="text-lg pr-4 py-2"><a class="block" href="{{route('profile.track-shipment')}}">Track Shipment</a></li>
          {{-- <li class="text-lg pr-4 py-2"><a href="{{route('profile.consign')}}">Consign</a></li> --}}
          <li class="text-lg pr-4 py-2"><a class="block" href="{{route('profile.address')}}">Address</a></li>
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

        <div class="grid grid-cols-1 md:grid-cols-2 max-w-xl flex-row flex-wrap text-gray-900 gap-5">
          <div id="alert" class="hidden justify-between items-center col-span-2 border-red-700 border p-2 bg-red-500">
            <svg class="w-5 h-5 mr-1 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h2 class="text-white text-sm">Something went wrong when fetching your data. Please refresh the page.</h2>
            <button id="closeAlertBtn" onclick="closeAlert('alert')">
              <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="flex flex-col">
            <label for="name" class="mb-3 text-sm">Name</label>
            <input value="" id="name" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="email" class="mb-3 text-sm">Email</label>
            <input value="" id="email" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="gender" class="mb-3 text-sm">Gender</label>
            <input value="" id="gender" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="password" class="mb-3 text-sm">Password</label>
            <input value="" id="password" disabled type="text" value="********" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="phone" class="mb-3 text-sm">Phone Number</label>
            <input value="" id="phone" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="postal" class="mb-3 text-sm">Postal Code</label>
            <input value="" id="postal" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="city" class="mb-3 text-sm">City</label>
            <input value="" id="city" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="district" class="mb-3 text-sm">District</label>
            <input value="" id="district" disabled type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col col-span-2">
            <label for="address" class="mb-3 text-sm">Address</label>
            <textarea id="address" disabled class="w-full px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border"></textarea>
          </div>
          <button class="bg-gray-900 text-white uppercase px-5 py-2 col-span-2 md:col-span-1">
            Edit Info
          </button>
        </div>
      </div>
      
    </div>
@endsection

@section('script')
    <script>
      async function getData(url = "") {
        const response = await fetch(url, {
          method: 'GET',
          cache: 'no-cache',
          headers: {
            'Content-Type': 'application/json'
          },
          referrerPolicy: 'no-referrer'
        });
        return response.json();
      }

      getData('/api/v1/customers/1').then(result => {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const gender = document.getElementById('gender');
        const phone = document.getElementById('phone');
        const postal = document.getElementById('postal');
        const city = document.getElementById('city');
        const district = document.getElementById('district');
        const address = document.getElementById('address');

        if (result.status === 200 && result.data.length > 0) {
          let data = result.data[0];
          name.value = data.name;
          email.value = data.email;
          gender.value = data.gender;
          phone.value = data.phone;
          postal.value = data.postal;
          city.value = data.city;
          district.value = data.district;
          address.value = data.address;
        } else {
          throw new Error('Data not available')
        }
      }).catch(error => {
        showAlert('alert')
      });
    </script>
@endsection