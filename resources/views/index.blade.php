@extends('layouts.default')

@section('page-title', 'Home - ')

@section('content')
  <section id="carousel" class="text-center mb-20">
    <img class="w-full" src="{{asset('/images/Slider.png')}}" alt="Aslisemua banner">
  </section>

  <section id="sale-banner" class=" mb-20">
    <img src="{{asset('/images/sale-banner.png')}}" class="w-full" alt="sale banner">
  </section>

  <section id="categories" class="flex flex-col text-center mb-20">
    <h2 class="font-serif text-3xl mb-10">CATEGORIES</h2>
    <div class="flex flex-row flex-wrap justify-between mb-5">
      @for ($i = 0; $i < 6; $i++)
        <div class="flex flex-col">
          <a href="#" class="">
            <img src="https://via.placeholder.com/200" class="mb-2" alt="categories">
            <div class="uppercase font-bold underline">Handbags</div>
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
@endsection
