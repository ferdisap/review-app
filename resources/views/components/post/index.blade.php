<x-app-layout title="My Post">
  {{-- @dd($posts) --}}
  <x-session-status :status="session('success')" bgColor="bg-green-200"/>
  <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
  {{-- @for ($i = 0; $i < 50; $i++)
  <div class="md:px-6 px-2 mb-2">
    <a href="/post/1">
      <x-list-post imgsrc="{{ url('/contoh/nasigoreng.jpeg') }}" />
    </a>
  </div>
  @endfor --}}
  @foreach ($posts as $post)
  <div class="md:px-6 px-2 mb-2">
    <a href="/post/1">
      <x-list-post 
      :title="$post->title"
      :simpleDescription="$post->simpleDescription"
      :ratingValue="$post->ratingValue"
      imgsrc="{{ url('/contoh/nasigoreng.jpeg') }}" />
    </a>
  </div>
  @endforeach
  @push('addPost')
    <!-- Dropdown Menu -->
    <div class="sticky flex justify-end bottom-5">
      <x-dropdown align="right" bottom="100%" width="48">
          <x-slot name="trigger">
            <div id="addPost-container"
                  style="cursor: pointer" 
                  class="w-max bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full shadow-lg mr-3 p-2 active:ring-4">
              <svg id="addPost" xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                <path
                  d="M9.45 43.25q-1.95 0-3.325-1.375Q4.75 40.5 4.75 38.55V9.45q0-1.95 1.375-3.35Q7.5 4.7 9.45 4.7H28.6v4.75H9.45v29.1h29.1V19.4h4.75v19.15q0 1.95-1.4 3.325-1.4 1.375-3.35 1.375Zm6.6-9.1v-3H32v3Zm0-6.35v-3H32v3Zm0-6.35v-3H32v3ZM34.9 17.9v-4.8h-4.8V9.55h4.8V4.7h3.55v4.85h4.85v3.55h-4.85v4.8Z" />
              </svg>
            </div>
          </x-slot>

          @php
            $menus = [['name' => 'Add Post', 'href' => '/post/create', 'svg' => 'gear']]
          @endphp
          
          <x-slot name="content">            
            @foreach ($menus as $menu)
            <x-dropdown-link :href="$menu['href']">
              {{ __($menu['name']) }}
            </x-dropdown-link>
          @endforeach
          </x-slot>
      </x-dropdown>
    </div>

    <style>
      #addPost{
        scale: 0.7;
        transform-origin: center
      }
      #addPost:hover{
        stroke:turquoise
      }
    </style>
  @endpush
</x-app-layout>
