@extends('layouts.default')

@section('page-title', 'Home - Shop products')

@section('content')
  <section id="header" class="mb-10 text-center">
    <h2 class="text-3xl">ALL CATEGORIES</h2>
  </section>
  <div class="flex flex-row">
    <section id="filter-shop" class="hidden md:block border border-gray-300 p-4 flex-shrink-0">
      <div id="filter-shop-categories border-b">
        <h5 class="font-bold mb-3">All Categories</h5>
        <ul>
          @foreach($categories as $category)
            <li class="pl-4 py-1"><a class="block" href="#">{{$category->name}}</a></li>
          @endforeach
        </ul>
      </div>
      <form action="">
        @csrf
        <div id="filter-shop-price" class="flex flex-col py-3">
          <h5 class="font-bold mb-3">Price Range</h5>
          <input type="number" name="min_price" placeholder="Minimum price" class="input border border-gray-400 appearance-none w-full px-3 py-3 pt-2 pb-2 focus focus:border-gray-600 focus:outline-none active:outline-none active:border-gray-600">
          <input type="number" name="max_price" placeholder="Maximum price" class="input border border-gray-400 appearance-none w-full px-3 py-3 pt-2 pb-2 focus focus:border-gray-600 focus:outline-none active:outline-none active:border-gray-600 mt-2">
        </div>
        <div id="filter-shop-brand" class="flex flex-col">
          <h5 class="font-bold mb-3">Brand</h5>
          @foreach($brands as $brand)
            <div class="inline-block">
              <input type="checkbox">
              <label for="checkbox" class="ml-2">{{$brand->name}}</label>
            </div>
          @endforeach
        </div>
      </form>
    </section>
    <div class="flex flex-col flex-grow ml-5">
      <section id="sort-section" class="flex flex-row-reverse mb-3">
        <div>
          <label for="sort">Sort by</label>
          <select name="sort" id="sort" class="p-2 border border-gray-300 ml-3">
            <option value="newest">Newest First</option>
            <option value="asc">Price: Low - High</option>
            <option value="desc">Price: High - Low</option>
          </select>
        </div>
      </section>
      <section id="filter-attribute" class="mb-4 border-b border-gray-800 inline-block">
        <select name="size" id="size-filter" class="py-2 focus:outline-none focus:border focus:border-gray-300 hover:border hover:border-gray-300 w-20">
          <option value="">Size</option>
          <option value="s">S</option>
          <option value="m">M</option>
          <option value="l">L</option>
          <option value="xl">XL</option>
        </select>
        <select name="Color" id="size-filter" class="ml-5 py-2 focus:outline-none focus:border focus:border-gray-300 hover:border hover:border-gray-300 w-20">
          <option value="">Color</option>
          <option value="s">Red</option>
          <option value="m">Green</option>
          <option value="l">Blue</option>
          <option value="xl">Black</option>
          <option value="xl">White</option>
          <option value="xl">Gray</option>
          <option value="xl">Yellow</option>
          <option value="xl">Blue</option>
          <option value="xl">Purple</option>
        </select>
      </section>
      <section id="products" class="flex flex-col">
        <div class="grid grid-cols-4 gap-2">
          @if($data->count() > 0)
            @foreach($data as $product)
              <div class="flex flex-col relative">
                <button class="focus:outline-none absolute flex justify-center items-center top-0 right-0" style="height: 32px; width: 32px;">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 m-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
                <div class="mb-3">
                  <img src="{{ URL::asset('storage/'.$product->image_path) }}" alt="" class="w-full" style="aspect-ratio: 2 / 3">
                </div>
                <div>
                  <a href="/product/{{$product->id}}/detail" class="block">
                    <h5 class="font-bold text-center text-xl">{{$product->brand->name}}</h5>
                    <p class="mt-2 mb-0 text-center text-sm">{{$product->name}}</p>
                    <p class="mt-2 mb-0 text-center text-sm">{{$product->size}}</p>
                    <p class="mt-2 mb-0 text-center text-yellow-500 text-sm">Rp {{number_format($product->final_price, 0, ',', '.')}}</p>
                  </a>
                </div>
              </div>
            @endforeach
          @else
            <h5 class="text-xl text-center">No Data Available</h5>
          @endif
        </div>
        @if($data->count() > 0)
          <div></div>
        @endif
      </section>
    </div>
  </div>

  </section>
@endsection
