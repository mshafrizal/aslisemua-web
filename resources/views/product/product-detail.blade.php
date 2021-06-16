@extends('layouts.default')

@section('page-title', 'Home - Product Detail')

@section('content')
  <div class="flex flex-row justify-between mb-10">
    {{--IMAGE--}}
    <div class="flex flex-row w-8/12">
      <div class="flex flex-col w-2/12">
        @foreach($data->productImage as $image)
          <div class="my-0 mx-auto thumbnail-img-frame">
            <img class="thumbnail-img" src="{{ URL::asset('storage/'.$image->image_path) }}" alt="{{$image->image_name}}">
          </div>
        @endforeach
      </div>
      <div class="flex flex-col w-10/12">
        <div class="my-0 mx-auto product-img-frame magnifier">
          <img id="product-img" class="product-img" src="{{ URL::asset('storage/'.$data->image_path) }}" alt="">
        </div>
      </div>
    </div>
    {{--DETAIL--}}
    <div class="flex flex-col relative w-4/12">
      <div class="flex flex-row flex-nowrap mb-3">
        <div class="flex flex-col flex-grow">
          <h5 class="text-2xl font-serif">{{$data->brand->name}}</h5>
          <p class="mb-0 mt-2 text-sm">{{$data->name}}</p>
          <p class="mb-0 mt-2 text-sm">Size: {{$data->size}}</p>
          @if($data->discount_price > 0)
          <p class="mb-0 mt-2 line-through">Rp {{number_format($data->base_price, 0, ',', '.')}}</p>
          @endif
          <p class="mb-0 mt-2 text-yellow-500">Rp {{number_format($data->final_price, 0, ',', '.')}}</p>
        </div>
        <button id="add-to-wishlist-button" class="focus:outline-none flex justify-center items-center flex-grow-0" style="width: 36px; height: 36px">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 hover:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </button>
      </div>
      <button id="add-to-cart-button" class="w-full mb-5 bg-gray-900 py-3 text-white uppercase focus:outline-none hover:bg-gray-700">Add To Cart</button>
      <h6 class="font-bold text-sm mb-2">Description</h6>
      <div>
        {!! $data->description !!}
      </div>
      <hr class="my-2" />

      <h6 class="font-bold text-sm mb-2">Details</h6>
      <div>
        {!! $data->detail !!}
      </div>

      <hr class="my-2" />

      <h6 class="font-bold text-sm mb-2">Condition</h6>
      <div>
        {{ $data->condition }}
      </div>

      <hr class="my-2" />

      <h6 class="font-bold text-sm mb-2">Authentication</h6>
      <p class="text-sm">
        We authenticate every item with a rigorous process overseen by experts.
        <u>Learn more & see our authentication process.</u>4
        <br />
        <br />
        Photos are of the actual item in our possession.
      </p>
    </div>
  </div>
@endsection

@section('bottom-resources')
  <script>
  </script>
@endsection
