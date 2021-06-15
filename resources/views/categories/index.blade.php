@extends('layouts.default')

@section('page-title', 'Categories - ')

@section('head-resources')
  <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
<style>
  .ph-col-12{
    padding-right: 0;
    padding-left: 0;
  }

  .category-item {
    width: 160px;
    padding: 0;
    border: 0;
    border-radius: 0;
  }
  .category-item>img {
    max-height: 100%;
    min-width: 100%;
  }

  #categories-wrapper>div {
    row-gap: 10px;
  }
</style>
@endsection

@section('content')
  <section id="categories" class="flex flex-col text-center mb-20">
    <h2 class="font-serif text-3xl mb-10">CATEGORIES</h2>
    <div id="categories-wrapper" class="flex flex-col sm:py-12">
      <!--
    <div  class="flex flex-row flex-wrap justify-between mb-5">
      <div class="flex flex-col">
        <a href="#" class="">
          <img src="https://dummyimage.com/200x200/222222/eeeeee.png&text=category" class="mb-2" alt="categories">
          <div class="uppercase font-bold underline">Handbags</div>
        </a>
      </div>
    </div>
      -->
    </div>
    <div id="skeleton-view" class="flex flex-row flex-wrap justify-between mb-5">
      @for ($i = 0; $i < 7; $i++)
        <div class="ph-item category-item flex flex-col">
          <div class="ph-col-12">
            <div class="ph-picture" style="height: 160px"></div>
            <div class="ph-row">
              <div class="ph-col-2 empty big"></div>
              <div class="ph-col-8 big"></div>
            </div>
          </div>
        </div>
      @endfor
    </div>
  </section>
@endsection


@section('bottom-resources')
  <script src="{{asset('js/app.js')}}"></script>
  <script defer src="https://kit.fontawesome.com/8505c87347.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <script>
    function loadCategory() {
      const skeleton = document.getElementById('skeleton-view');
      const wrapper = document.getElementById('categories-wrapper');

      skeleton.style.display = 'inherit';
      wrapper.style.display = 'none';
      axios.get('{{route('categories-api')}}').then(result => {
        if (result.status === 200) {
          skeleton.style.display = 'none';
          wrapper.style.display = 'inherit';
          const data = result.data.data;

          wrapper.innerHTML = "";
            const div = document.createElement('div');
            div.className = "flex flex-row flex-wrap justify-start mb-5";
            div.style.width = '100%';

            data.forEach(el => {
              const divItem = document.createElement('div');
              divItem.className = "flex-row category-item";

              divItem.style.marginLeft = '28px'
              divItem.style.marginRight = '28px'

              const a = document.createElement('a');
              a.href = '#';
              a.onclick= (e) => e.preventDefault();

              const img = document.createElement('img');
              img.src = "https://dummyimage.com/160x160/222222/eeeeee.png&text="+el.name.substring(0,3);
              img.width = 160;
              img.height = img.width;

              img.className = "mb-2";
              img.alt = "categories";

              a.append(img);

              const title = document.createElement('div');
              title.className = 'uppercase font-bold underline';
              title.innerText = el.name;
              a.append(title)

              divItem.append(a);
              div.append(divItem);
            })
            wrapper.append(div);
        } else {
          throw new Error(result.message);
        }
      }).catch(err => {
        let errorMessage = err.response.data.message;
          Toastify({
            text: errorMessage || err,
            duration: '3000',
            close: true,
            gravity: 'top',
            position: 'center',
            backgroundColor: '#333',
            stopOnFocus: true
          }).showToast();
      })
    }

    document.addEventListener('DOMContentLoaded', () => loadCategory());
  </script>
@endsection
