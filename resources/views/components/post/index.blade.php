<x-app-layout title="My Post">

  {{-- @dd($postsDraft) --}}
  
  <x-session-status :status="session('success')" bgColor="bg-green-200"/>
  <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
  @php
  // dd($active);
  $active =  $active ?? (old('active-content') ?? 'published');
  $checked = old('toogle-switch') ?? false; // old('toogle-switch') @return 'some' / 'on'
  @endphp
  
  <form action="" style="height: 100%; width:inherit" class="overflow-auto" method="post" id="form-mypost-index">
    @csrf  
    <div id="main-content" x-data x-init="$store.selectDiselectFeature.initialization()">
      <div class="grid grid-cols-2 gap-x-16 mb-2 mt-1 mx-16">
        <div class="text-center pb-3 transition delay-100 ease-out" 
                x-on:click="$store.selectDiselectFeature.showAllPost('draft')" 
                for="draft"
                role="button">draft</div>
        <div class="text-center pb-3 transition delay-100 ease-out" 
                x-on:click="$store.selectDiselectFeature.showAllPost('published')" 
                for="published"
                role="button">published</div>
      </div>

      {{-- <div><x-input-error :messages="$errors->get('list-post-cb')" class="mt-2" /></div>       --}}
      {{-- <x-toogle-slider class="" :checkValue="$checked ?? false" name="toogle-switch" id="toogle-switch">Select All</x-toogle-slider> --}}
      <div class="flex justify-between">
        <x-toogle-slider class="" :checkValue="$checked" name="toogle-switch" id="toogle-switch">Select All</x-toogle-slider>
        <span class="search" role="button" x-on:click="$store.search.open()"></span>
      </div>
      <div id="content" class="" active="{{ $active }}" mousedownHandler="false" clickHandler="false" mouseupHandler="false"> 
        <input type="hidden" id="active-content" name="active-content" value="{{ $active }}"> 
        <!-- Draft post -->
        <div id="draft" style="display: none">
          @foreach ($postsDraft as $key => $post)
          {{-- @if($post->isDraft == 1) --}}
          <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
            <input name="list-post-cb[]" type="checkbox" class="list-post-cb appearance-none checked:bg-blue-500 mx-2" style="display: none" value="{{ $post->uuid }}" {{ old($post->uuid) ?? '' }}/>
            <a href="/post/{{ $post->uuid }}" class="list-post w-full">
              <x-list-post 
              :inputValue="$key"
              :title="$post->title"
              :simpleDescription="Str::limit($post->simpleDescription, 125, '...')"
              :ratingValue="$post->ratingValue"
              imgsrc="{{ url('/postImages/'. Auth::user()->username . '/thumbnail/' . $post->uuid . '_50_images.0.jpg')}}" />
            </a>
          </div>
          {{-- @endif --}}
          @endforeach
          {{ $postsDraft->links() }}      
        </div>

        
        <!-- Published post -->
        <div id="published" style="display: none">
          @foreach ($postsPublished as $key => $post)
          {{-- @if($post->isDraft == 0) --}}
          <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
            <input name="list-post-cb[]" type="checkbox" class="list-post-cb appearance-none checked:bg-blue-500 mx-2" style="display: none" value="{{ $post->uuid }}" {{ old($post->uuid) ?? '' }}/>
            <a href="/post/{{ $post->uuid }}" class="list-post w-full">
              <x-list-post 
              :inputValue="$key"
              :title="$post->title"
              :simpleDescription="Str::limit($post->simpleDescription, 125, '...')"
              :ratingValue="$post->ratingValue"
              imgsrc="{{ url('/postImages/'. Auth::user()->username . '/thumbnail/' . $post->uuid . '_50_images.0.jpg')}}" />
            </a>
          </div>
          {{-- @endif --}}
          @endforeach
          {{ $postsPublished->links() }}
        </div>
      </div>
      
    </div>

    <div class="sticky bottom-4 mr-4 float-right" style="top: calc(100% - 4rem)">
      <x-dropdown align="right" bottom="100%" width="48">
        <x-slot:trigger>
          <div  style="cursor: pointer" id="float-btn" 
                class="more bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full shadow-lg px-2 pt-1 active:ring-4 scale-11 transition-05"
                role="button">          
      </div>
        </x-slot>

        @php
          $menus = [['name' => 'Add Post', 'href' => '/post/create', 'icon' => 'add', 'method' => 'get'],
                    ['name' => 'Delete Post', 'href' => '/post/delete', 'icon' => 'more', 'method' => 'post']
                  ]
        @endphp
        
        <x-slot:content>            
          @foreach ($menus as $menu)
          <x-dropdown-link :href="$menu['href']" :icon="$menu['icon']" :method="$menu['method']">
            {{ __($menu['name']) }}
          </x-dropdown-link>
          @endforeach
        </x-slot>
      </x-dropdown>
    </div>
  </form>
</x-app-layout>