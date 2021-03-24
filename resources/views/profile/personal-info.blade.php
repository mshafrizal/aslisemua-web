@extends('layouts.user')

@section('content')
    <div class="flex flex-col">
      <div class="border-b-2 pb-2 mb-4">
        <h1 class="text-3xl font-serif">Hello, Jonathan Morningstar</h1>
        <p class="text-lg">Member since 2020</p>
      </div>
      @php
         {{Auth::guard('api')->check();}}   
      @endphp
      
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
            <input value="" id="name" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="email" class="mb-3 text-sm">Email</label>
            <input value="" id="email" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="gender" class="mb-3 text-sm">Gender</label>
            <input value="" id="gender" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="password" class="mb-3 text-sm">Password</label>
            <input value="" id="password" disabled type="text" placeholder="********" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="phone" class="mb-3 text-sm">Phone Number</label>
            <input value="" id="phone" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="postal" class="mb-3 text-sm">Postal Code</label>
            <input value="" id="postal" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="city" class="mb-3 text-sm">City</label>
            <input value="" id="city" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col">
            <label for="district" class="mb-3 text-sm">District</label>
            <input value="" id="district" disabled type="text" class="max-w-sm px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border">
          </div>
          <div class="flex flex-col col-span-2">
            <label for="address" class="mb-3 text-sm">Address</label>
            <textarea id="address" disabled class="w-full px-3 py-2 focus:ring-gray-900 focus:border-gray-900 block sm:text-sm border-gray-400 border"></textarea>
          </div>
          <button id="editInfoButton" class="bg-gray-900 text-white uppercase px-5 py-2 col-span-2 md:col-span-1">
            Edit Info
          </button>
        </div>
      </div>
      
    </div>
@endsection

@section('script')
    <script>
      document.getElementById('editInfoButton').addEventListener('click', () => {
        window.location.href = '{{route('profile.edit-personal-info')}}';
      });
      
      const USER_ID = localStorage.getItem('id');
      axios.get(`/api/v1/customers/${USER_ID}`).then(result => {
        if (result.status === 200) {
          const name = document.getElementById('name');
          const email = document.getElementById('email');
          const gender = document.getElementById('gender');
          const phone = document.getElementById('phone');
          const postal = document.getElementById('postal');
          const city = document.getElementById('city');
          const district = document.getElementById('district');
          const address = document.getElementById('address');
          name.value = result.data.data.name;
          email.value = result.data.data.email;
          gender.value = result.data.data.gender;
          phone.value = result.data.data.phone_number;
          postal.value = result.data.data.postal_code;
          city.value = result.data.data.city;
          district.value = result.data.data.district;
          address.value = result.data.data.address;
        } else {
          throw new Error(result.message)
        }
      }).catch(error => {
        Toastify({
          text: 'Failed to retrieve your information. Please try again.',
          duration: '3000',
          close: true,
          gravity: 'top',
          position: 'center',
          backgroundColor: '#333',
          stopOnFocus: true
        }).showToast();
      })
    </script>
@endsection