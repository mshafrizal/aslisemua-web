@extends('layouts.user')

@section('content')
    <div class="flex flex-col">
      <div class="border-b-2 pb-2 mb-4">
        <h1 class="text-3xl font-serif">Hello, Jonathan Morningstar</h1>
        <p class="text-lg">Member since 2020</p>
      </div>

      <div class="flex flex-row">
        <ul class="">
          <li class="text-lg font-bold pr-4 py-2"><a href="{{route('profile.personal-info')}}">Personal Info</a></li>
          <li class="text-lg pr-4 py-2"><a href="{{route('profile.my-purchases')}}">My Purchases</a></li>
          <li class="text-lg pr-4 py-2"><a href="{{route('profile.track-shipment')}}">Track Shipment</a></li>
          {{-- <li class="text-lg pr-4 py-2"><a href="{{route('profile.consign')}}">Consign</a></li> --}}
          <li class="text-lg pr-4 py-2"><a href="{{route('profile.address')}}">Address</a></li>
        </ul>
      </div>
      
    </div>
@endsection