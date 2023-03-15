<x-app-layout title="Detail Post">
  <x-slot:additional_script>
    @vite(['resources/js/comment.js', 'resources/js/viewPostImg.js', 'resources/js/giveRating.js' ])
    </x-slot>
    <x-session-status :status="session('success')" bgColor="bg-green-200" />
    <x-session-status :status="session('fail')" bgColor="bg-red-200" />

    <div class="block h-full w-inherit">

      {{-- post title --}}
      <h1 class="m-3 text-center text-txl">{{ $post->title }}</h1>
      {{-- post rating --}}
      <x-rating :ratingValue="$post->ratingValue ?? 0" />

      {{-- post image --}}
      <div x-data="viewPostImg" class="grid grid-cols-6 gap-4 place-content-center place-items-center" x-data>
        <div class="col-start-1">
          <span class="arrowhead_lh" role="button" x-on:click="previmg()"></span>
        </div>
        <div class="col-start-2 col-span-4 h-max">
          <div class="post-img-container" active=1>
            <img id="img0"
              onerror="this.remove()"
              x-on:load="onload()"
              class="hidden shadow-lg postImg-show animate1s"
              src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.0.jpg"
              alt="{{ $post->title }}">
            <img id="img1"
              onerror="this.remove()"
              x-on:load="onload()"
              class="hidden shadow-lg postImg-show animate1s"
              src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.1.jpg"
              alt="{{ $post->title }}">
            <img id="img2"
              onerror="this.remove()"
              x-on:load="onload()"
              class="hidden shadow-lg postImg-show animate1s"
              src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.2.jpg"
              alt="{{ $post->title }}">
            <img id="img3"
              onerror="this.remove()"
              x-on:load="onload()"
              class="hidden shadow-lg postImg-show animate1s"
              src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.3.jpg"
              alt="{{ $post->title }}">
            <img id="img4"
              onerror="this.remove()"
              x-on:load="onload()"
              class="hidden shadow-lg postImg-show animate1s"
              src="/postImages/{{ $post->author->username }}/display/{{ $post->uuid }}_400_images.4.jpg"
              alt="{{ $post->title }}">
          </div>
          <div class="circle-container w-full flex justify-center">
            <!-- circle filled by JS -->
          </div>
        </div>
        <div class="col-end-7 col-span-1">
          <span class="arrowhead_rh" role="button" x-on:click="nextimg()"></span>
        </div>
      </div>

      {{-- rating form --}}
      <div class="mt-5 mb-5 w-full flex justify-center flex-wrap" x-data>
        @vite(['resources/css/selectedRate.css'])
        <h6 class="text-center mx-3 font-bold">give your rating:</h6>
        <div class="container-rating_form w-60 rounded-md grid grid-cols-5 place-content-center place-items-center">
          <div class="hover:scale-150 col-start-1" x-on:click="$store.giveRating.select($el,1,'{{ $post->uuid }}')"
            role="button">1</div>
          <div class="hover:scale-150 col-start-2" x-on:click="$store.giveRating.select($el,2,'{{ $post->uuid }}')"
            role="button">2</div>
          <div class="hover:scale-150 col-start-3" x-on:click="$store.giveRating.select($el,3,'{{ $post->uuid }}')"
            role="button">3</div>
          <div class="hover:scale-150 col-start-4" x-on:click="$store.giveRating.select($el,4,'{{ $post->uuid }}')"
            role="button">4</div>
          <div class="hover:scale-150 col-start-5" x-on:click="$store.giveRating.select($el,5,'{{ $post->uuid }}')"
            role="button">5</div>
        </div>
      </div>

      {{-- short description --}}
      <div x-data="{ open: true }" class="px-8 my-4">
        <h5 class="text-dxl font-bold my-2" x-on:click="open = ! open" role="button">Short Description <span
            class="expand" x-init="$watch('open', v => v ? ($el.setAttribute('class', 'expand')) : ($el.setAttribute('class', 'arrow_rh')))"></span></h5>
        <div x-show="open" class="">
          {{ $post->simpleDescription }}
        </div>
      </div>

      {{-- Reviews Comment --}}
      <div open_comment_form="{{ old('open_comment_form') ?? 'false' }}"
        open_add_comment_form="{{ old('open_add_comment_form') ?? 'false' }}" limit="{{ old('qtyComment') ?? 2 }}"
        x-data="comment" class="px-8 my-4">
        <h5 class="text-dxl font-bold my-2" x-on:click="open = ! open" role="button">Review <span class="expand"
            x-init="$watch('open', v => v ? ($el.setAttribute('class', 'expand')) : ($el.setAttribute('class', 'arrow_rh')))"></span></h5>
        <div class="w-full text-center relative" x-show="open">
          <div class="comment-container" x-init="more_comment('{{ $post->uuid }}')">
            <x-comment :isCommenting="true" :postID="$post->uuid" x-show="open" />
          </div>
          <!-- tombol add and more comment -->
          <div class="my-3 text-justify block rounded-lg space-x-2">
            <div class="comment md:w-fit w-8 inline-block tooltip border shadow-sm rounded-md h-20px" role="button"
              x-on:click="open_add_comment_form = !open_add_comment_form">
              <span class="tooltiptext tooltip-center md:hidden">add comment</span>
              <span class="hidden md:inline-block ml-7">add comment</span>
            </div>
            <div class="more_up md:w-fit w-8 inline-block tooltip border shadow-sm rounded-md h-20px" role="button"
              x-on:click="more_comment('{{ $post->uuid }}')">
              <span class="tooltiptext tooltip-center md:hidden">more comment</span>
              <span class="hidden md:inline-block ml-7">more comment</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Author Contact --}}
      <div x-data="{ open: false }" class="px-8 my-4">
        <h5 class="text-dxl font-bold my-2" x-on:click="open = ! open" role="button">Author Contact <span
            class="arrow_rh" x-init="$watch('open', v => v ? ($el.setAttribute('class', 'expand')) : ($el.setAttribute('class', 'arrow_rh')))"></span></h5>
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
          @foreach ($otherPosts as $key => $otherPost)
            <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
              <a href="/post/{{ $otherPost->uuid }}" class="list-post w-full">
                <x-list-post :inputValue="$key" :title="$otherPost->title" :simpleDescription="$otherPost->simpleDescription" :ratingValue="80"
                  imgsrc="{{ url('/postImages/' . Auth::user()->username . '/thumbnail/' . $otherPost->uuid . '_50_images.0.jpg') }}" />
              </a>
            </div>
          @endforeach
        @endif
      </div>

      {{-- more button --}}
      <div class="sticky bottom-4 mr-8 float-right" style="top: calc(100% - 4rem)">
        <x-dropdown align="right" bottom="100%" width="48">
          <x-slot:trigger>
            <div style="cursor: pointer" id="float-btn"
              class="more bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full shadow-lg px-2 pt-1 active:ring-4 scale-11 transition-05"
              role="button">
            </div>
            </x-slot>

            @php
              $menus = [['name' => 'Add Post', 'href' => '/post/create', 'icon' => 'post_add', 'method' => 'get'], ['name' => 'Edit  Post', 'href' => '/post/edit/' . $post->uuid, 'icon' => 'edit_doc', 'method' => 'get'], ['name' => 'Delete Post', 'href' => '/post/delete/' . $post->uuid, 'icon' => 'delete', 'method' => 'get']];
            @endphp

            <x-slot:content>
              @foreach ($menus as $menu)
                <x-dropdown-link :href="$menu['href']" :method="$menu['method']" :tooltip="$menu['name']"
                  tooltipClass="tooltip-lh sm:hidden">
                  <span class="{{ $menu['icon'] }}"><span
                      class="hidden sm:inline-block ml-7">{{ $menu['name'] }}</span></span>
                </x-dropdown-link>
              @endforeach
              <hr>
              <!-- Show QR Code -->
              <x-dropdown-link href="/post/qrcode/post_uuid" class="sm:mt-4" tooltip="Show QR Code"
                tooltipClass="tooltip-lh sm:hidden">
                <span class="qr_code"><span class="hidden sm:inline ml-7">Show QR Code</span></span>
              </x-dropdown-link>


              </x-slot>
        </x-dropdown>
      </div>
</x-app-layout>
