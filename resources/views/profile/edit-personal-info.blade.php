@extends('layouts.user')

@section('content')
    <div class="flex flex-col">
      <div class="border-b-2 pb-2 mb-4">
        <h1 class="text-3xl font-serif">Hello, Jonathan Morningstar</h1>
        <p class="text-lg">Member since 2020</p>
      </div>

      <div class="flex flex-col md:flex-row md:space-x-10">
        @include('partials.profile-sidebar')

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
            <input value="" id="name" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="email" class="mb-3 text-sm">Email</label>
            <input value="" id="email" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="gender" class="mb-3 text-sm">Gender</label>
            <input value="" id="gender" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="password" class="mb-3 text-sm">Password</label>
            <input value="" id="password" type="text" value="********" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="phone" class="mb-3 text-sm">Phone Number</label>
            <input value="" id="phone" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="postal" class="mb-3 text-sm">Postal Code</label>
            <input value="" id="postal" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="city" class="mb-3 text-sm">City</label>
            <input value="" id="city" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="district" class="mb-3 text-sm">District</label>
            <input value="" id="district" type="text" class="max-w-smpx-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col col-span-2">
            <label for="address" class="mb-3 text-sm">Address</label>
            <textarea id="address" class="w-full px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border"></textarea>
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