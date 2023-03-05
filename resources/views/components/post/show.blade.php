<x-app-layout title="Detail Post">

  <x-session-status :status="session('success')" bgColor="bg-green-200"/>
  <x-session-status :status="session('fail')" bgColor="bg-red-200"/>

  <div  class="block h-full w-inherit"
        x-data="{          
          img: document.querySelector('.img-post-display'),
          circle: document.querySelector('circle'),
          circleAll: document.querySelectorAll('circle'),
          nextimg(){
            if(this.img.nextElementSibling != null){
              this.img.classList.add('hidden');
              this.img.nextElementSibling.classList.remove('hidden');
              this.img = this.img.nextElementSibling;
  
              this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
              this.circle.nextElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
              this.circle = this.circle.nextElementSibling;
            }
          },
          previmg(){
            if(this.img.previousElementSibling != null){
              this.img.classList.add('hidden');
              this.img.previousElementSibling.classList.remove('hidden');
              this.img = this.img.previousElementSibling;
              
              this.circle.setAttribute('fill', 'rgba(0,0,0,0.2)');
              this.circle.previousElementSibling.setAttribute('fill', 'rgba(0,0,0,0.9)');
              this.circle = this.circle.previousElementSibling;
            }
          },
          deleteEl(el){
            this.circleAll[el.getAttribute('circle')].remove();
            el.remove();
          }
        }"
  >


    <h1 class="m-3 text-center text-txl">{{ $post->title }}</h1>

    <x-rating :ratingValue="$post->ratingValue ?? 0" />

    <div class="grid grid-cols-6 gap-4 place-content-center place-items-center">
      <div class="col-start-1">
        <span class="arrowhead_lh" role="button" x-on:click="previmg()"></span>
      </div>
      <div class="col-start-2 col-span-4 h-max">
        <div>
          <img circle="0" class="img-post-display rounded-lg shadow-lg my-2" style="min-height: 12rem" src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.0.jpg" alt="{{ $post->title }}">
          <img x-on:error="deleteEl($el)" circle="1" class="img-post-display hidden rounded-lg shadow-lg my-2" style="min-height: 12rem" src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.1.jpg" alt="{{ $post->title }}">
          <img x-on:error="deleteEl($el)" circle="2" class="img-post-display hidden rounded-lg shadow-lg my-2" style="min-height: 12rem" src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.2.jpg" alt="{{ $post->title }}">
          <img x-on:error="deleteEl($el)" circle="3" class="img-post-display hidden rounded-lg shadow-lg my-2" style="min-height: 12rem" src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.3.jpg" alt="{{ $post->title }}">
          <img x-on:error="deleteEl($el)" circle="4" class="img-post-display hidden rounded-lg shadow-lg my-2" style="min-height: 12rem" src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.4.jpg" alt="{{ $post->title }}">
        </div>
        <div class="w-full flex justify-center">
          <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="85px" height="13px" viewBox="0 0 87 13" xml:space="preserve">
            <circle fill="rgba(0,0,0,0.9)" stroke="none" cx="6.5" cy="6.5" r="6" />
            <circle fill="rgba(0,0,0,0.2)" stroke="none" cx="24.5" cy="6.5" r="6" />
            <circle fill="rgba(0,0,0,0.2)" stroke="none" cx="42.5" cy="6.5" r="6" />
            <circle fill="rgba(0,0,0,0.2)" stroke="none" cx="61" cy="6.5" r="6" />
            <circle fill="rgba(0,0,0,0.2)" stroke="none" cx="79.5" cy="6.5" r="6" />
          </svg>
        </div>
      </div>
      <div class="col-end-7 col-span-1">
        <span class="arrowhead_rh" role="button" x-on:click="nextimg()"></span>
      </div>
    </div>

  {{-- rating form --}}
  <div class="mt-5 mb-5 w-full flex justify-center flex-wrap" x-data="{
    valuesRating: $el.querySelectorAll('div[role=button]'),
    select(el,rateValue){
      this.valuesRating.forEach(el => el.classList.remove('selected-rate'));
      el.classList.add('selected-rate');
      Alpine.store('delay').delay(500, () => {
        fetch('/post/rate',{
          method: 'post',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'rateValue' : rateValue,
            'postID' : '{{ $post->uuid }}',
          }),
        })
        .then(rsp => rsp.json())
        .then(rst => {
          (rateSession = document.querySelector('.session-status')) ? rateSession.remove() : false ;
          div = document.createElement('div');
          div.setAttribute('class', 'rate-session session-status');
          rst.status == true ? div.style.backgroundColor = 'rgb(187 247 208)' : div.style.backgroundColor = 'rgb(254 202 202)'
          div.innerHTML = rst.message + `<button class='close black scale-50' onclick='this.parentNode.remove()'></button>`
          document.querySelector('main').prepend(div);

          rst.status == true ? Alpine.store('setStarRating').run(document.querySelector('div[star-container]'), rst.postRate) : null;
        });
      });
    },
  }">
    <link rel="stylesheet" href="/css/selectedRate.css">
    <h6 class="text-center mx-3 font-bold">give your rating:</h6>
    <div class="w-60 rounded-md grid grid-cols-5 place-content-center place-items-center">
      <div class="hover:scale-150 col-start-1" x-on:click="select($el,1)" role="button">1</div>
      <div class="hover:scale-150 col-start-2" x-on:click="select($el,2)" role="button">2</div>
      <div class="hover:scale-150 col-start-3" x-on:click="select($el,3)" role="button">3</div>
      <div class="hover:scale-150 col-start-4" x-on:click="select($el,4)" role="button">4</div>
      <div class="hover:scale-150 col-start-5" x-on:click="select($el,5)" role="button">5</div>
    </div>
  </div>

  {{-- short description --}}
  <div x-data="{open: true}" class="px-8 my-4">
    <h5 class="text-dxl font-bold my-2" x-on:click="open = ! open" role="button">Short Description <span class="expand" x-init="$watch('open', v => v ? ($el.setAttribute('class', 'expand')) : ($el.setAttribute('class', 'arrow_rh')))"></span></h5>
    <div x-show="open" class="">
      {{ $post->simpleDescription }}
    </div>
  </div>
  
  {{-- Reviews Comment --}}
  <div x-data="{open: {{ old('open_comment_form') ?? 'true' }} }" class="px-8 my-4">
    <h5 class="text-dxl font-bold my-2" x-on:click="open = ! open" role="button">Review <span class="expand" x-init="$watch('open', v => v ? ($el.setAttribute('class', 'expand')) : ($el.setAttribute('class', 'arrow_rh')))"></span></h5>
    <div x-show="open" class="">
      {{-- // masih harus punya Auth::user() --}}
      <div class="w-full text-center relative" x-data="{open: false}">
        <button class="comment tooltip" x-on:click="open = !open">
          <span class="tooltiptext tooltip-center md:hidden">add comment</span>
          <span class="hidden md:inline-block ml-7">add comment</span>
        </button>
        <x-comment :isCommenting="false"/>
        <x-comment :isCommenting="true" :postID="$post->uuid" x-show="open"/>
      </div>
    </div>
  </div>

  {{-- Author Contact --}}
  <div x-data="{open: false}" class="px-8 my-4">
    <h5 class="text-dxl font-bold my-2" x-on:click="open = ! open" role="button">Author Contact <span class="arrow_rh" x-init="$watch('open', v => v ? ($el.setAttribute('class', 'expand')) : ($el.setAttribute('class', 'arrow_rh')))"></span></h5>
    <div x-show="open" class="">
      <div>
        <span>Email: </span>
        <span>{{ $post->author->email }}</span>
      </div>
      <div>
        <span>Address: </span>
        <span>{{ $post->author->address }}</span>
      </div>
      <div>
        <span>Bio: </span>
        <span>{{ $post->author->bio }}</span>
      </div>
    </div>
  </div>

  {{-- suggested --}}
  <div class="px-8 my-4">
    <h5 class="text-dxl font-bold my-2">Other Post</h5>
    @if (isset($otherPosts))
    @foreach($otherPosts as $key => $post)
    <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
      <a href="/post/{{ $post->uuid }}" class="list-post w-full">
        <x-list-post 
        :inputValue="$key"
        :title="$post->title"
        :simpleDescription="$post->simpleDescription"
        :ratingValue="80"
        imgsrc="{{ url('/postImages/'. Auth::user()->username . '/thumbnail/' . $post->uuid . '_50_images.0.jpg')}}" />
      </a>
    </div>
    @endforeach
    @endif
  </div>

  {{-- more button --}}
  <div class="sticky bottom-4 mr-8 float-right" style="top: calc(100% - 4rem)">
    <x-dropdown align="right" bottom="100%" width="48">
      <x-slot:trigger>
        <div  style="cursor: pointer" id="float-btn" 
              class="more bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full shadow-lg px-2 pt-1 active:ring-4 scale-11 transition-05"
              role="button">          
    </div>
      </x-slot>

      @php
        $menus = [['name' => 'Add Post', 'href' => '/post/create', 'icon' => 'post_add', 'method' => 'get'],
                  ['name' => 'Edit  Post', 'href' => '/post/edit/' . $post->uuid, 'icon' => 'edit_doc', 'method' => 'get'],
                  ['name' => 'Delete Post', 'href' => '/post/delete/' . $post->uuid, 'icon' => 'delete', 'method' => 'get'],
                ]
      @endphp
      
      <x-slot:content>            
        @foreach ($menus as $menu)
        <x-dropdown-link :href="$menu['href']" :method="$menu['method']" :tooltip="$menu['name']" tooltipClass="tooltip-lh sm:hidden">
          <span class="{{ $menu['icon'] }}"><span class="hidden sm:inline-block ml-7">{{ $menu['name'] }}</span></span>
        </x-dropdown-link>
        @endforeach
        <hr>
        <!-- Show QR Code -->
        <x-dropdown-link href="/post/qrcode/post_uuid" class="sm:mt-4" tooltip="Show QR Code" tooltipClass="tooltip-lh sm:hidden">
          <span class="qr_code"><span class="hidden sm:inline ml-7">Show QR Code</span></span>
        </x-dropdown-link>
            
                        
      </x-slot>
    </x-dropdown>
  </div>
</x-app-layout>
