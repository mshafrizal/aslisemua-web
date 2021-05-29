@extends('layouts.user')

@section('content')
  <div class="flex flex-col">
    <div class="border-b-2 pb-2 mb-4">
      <h1 class="text-3xl font-serif">Hello, Jonathan Morningstar</h1>
      <p class="text-lg">Member since 2020</p>
    </div>

    <div class="flex flex-col md:flex-row md:space-x-10">
      @include('partials.profile-sidebar')
      <div class="grid grid-cols-1 max-w-xl flex-row flex-wrap text-gray-900 gap-5 w-full">
        <div id="alert" class="hidden justify-between items-center border-red-700 border p-2 bg-red-500">
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
        <div class="border border-black bg-white">
          <div class="p-3 border-b border-gray-400">
            <h1 class="text-sm">01 Jan 2021</h1>
          </div>
          <div class="p-3 border-b border-gray-400 flex flex-row flex-wrap justify-between items-center text-sm">
            <div class="flex flex-col w-2/5">
              <p>Transaction ID</p>
              <p id="transactionID">INV/20210101/0000001</p>
            </div>
            <div class="flex flex-col w-1/5">
              <p>Status</p>
              <p id="transactionStatus">Order Processed</p>
            </div>
            <div class="flex flex-col w-1/5">
              <p>Total Purchases</p>
              <p id="transactionTotal">Rp 47.950.000</p>
            </div>
          </div>
          <div class="p-3 flex flex-col">
            <div class="flex flex-row flex-wrap text-sm">
              <div class="flex flex-col w-2/5">
                <p id="brand" class="font-bold">Prada</p>
                <p id="product_name">Crocodile-Trimmed Skipper Bag</p>
              </div>
              <div class="flex flex-col w-3/5">
                <p>Price</p>
                <p id="price">Rp 7.000.000</p>
              </div>
            </div>
            <div class="flex flex-row flex-wrap text-sm border-t border-gray-400 mt-3 pt-3">
              <div class="flex flex-col w-2/5">
                <p id="brand" class="font-bold">Prada</p>
                <p id="product_name">Crocodile-Trimmed Skipper Bag</p>
              </div>
              <div class="flex flex-col w-3/5">
                <p>Price</p>
                <p id="price">Rp 7.000.000</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
@endsection