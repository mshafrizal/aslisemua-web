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
{{--    <div class="flex flex-row flex-wrap justify-between mb-5">--}}
{{--      @for ($i = 0; $i < 6; $i++)--}}
{{--        <div class="flex flex-col">--}}
{{--          <a href="#" class="">--}}
{{--            <img src="https://via.placeholder.com/200" class="mb-2" alt="categories">--}}
{{--            <div class="uppercase font-bold underline">Handbags</div>--}}
{{--          </a>--}}
{{--        </div>--}}
{{--      @endfor--}}
{{--    </div>--}}
    <div class="grid grid-cols-6 gap-1 mb-3">
      @for($i = 0; $i < 5; $i++)
        <div class="flex flex-col p-2">
          <a class="block" href="/shop/{{$categories[$i]->slug}}">
            <img class="block mx-auto h-auto w-auto mb-3" style="max-width: 200px; max-height: 200px" src="{{ URL::asset('storage/'.$categories[$i]->file_path) }}" />
            <h5 class="text-2xl">{{$categories[$i]->name}}</h5>
          </a>
        </div>
      @endfor
    </div>

    <a href="/categories" class="uppercase mx-auto py-2 px-10 bg-gray-700 text-white">SEE ALL CATEGORIES</a>
  </section>

  <section id="new-arrivals" class="flex flex-col text-center mb-20">
    <h2 class="font-serif text-3xl mb-10">NEW ARRIVALS</h2>
    <div id="new-arrivals" class="grid grid-cols-4 gap-2">

      @foreach($newArrivalProducts as $product)
        <div class="flex flex-col p-2">
          <a href="/products/{{$product->id}}/detail" class="block">
            <img class="block mx-auto h-auto w-auto mb-3" style="max-width: 300px; max-height: 400px;" src="{{ URL::asset('storage/'.$product->image_path) }}" alt="Picture of {{$product->name}}">
            <h5 class="text-2xl mb-1">{{$product->brand->name}}</h5>
            <p class="text-lg">{{$product->name}}</p>
            <p class="text-yellow-500">Rp {{$product->final_price}}</p>
          </a>
        </div>
      @endforeach
    </div>
  </section>

  <section id="editors-pick" class="flex flex-col text-center mb-20">
    <h2 class="font-serif text-3xl mb-10">EDITOR'S PICK</h2>
    <div class="flex justify-between">
      <img src="{{asset('/images/editors-pick-1.png')}}" class="w-full mb-3" alt="Editors pick 1">
      <img src="{{asset('/images/editors-pick-2.png')}}" class="w-full mb-3" alt="Editors pick 2">
    </div>
  </section>
@endsection

@section('script')
<script>
  document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '.splide' ).mount();
  } );
</script>
@endsection
