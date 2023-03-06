<div class="my-3 text-justify block">
  <div class="w-full">
    @if ($isCommenting == true)
      <div class="flex justify-items-start items-center space-x-4" x-show="open">
        <img src="/photos/pprofile/{{ Auth::user()->username }}.jpg" alt="" style="width:30px;height:30px"
          class="rounded-full shadow-md">
        <h6 class="text-xl font-bold">{{ Auth::user()->name }}</h6>
      </div>
      <form action="/comment/{{ $postID }}/push" method="post" x-show="open">
        @csrf
        <div class="w-full mb-16">
          <x-textarea class="mt-3" style="width: inherit" name="comment" rows="3"
            value="{{ $value ?? null }}" />
          <input type="hidden" name="open_comment_form" value="true">
          <input type="hidden" name="open_add_comment_form" value="true">
          <x-input-error :messages="$errors->get('comment')" class="float-left" />
          <x-primary-button type="submit" class="float-right" value="send" />
        </div>
      </form>
    @else
      @if(isset($comment))
      <div class="flex justify-items-start items-center space-x-4">
        <img src="/photos/pprofile/{{ $comment->commentator->username }}.jpg" alt="" style="width:30px;height:30px"
          class="rounded-full shadow-md">
        <div class="block w-full">
          <h6 class="text-xl font-bold">{{ $comment->commentator->name }}</h6>
          <p>{{ $comment->updated_at->diffForHumans() }}</p>
        </div>
        @auth
        <x-dropdown align="right" bottom="100%">
          <x-slot:trigger>
            <button class="float-right more tooltip">
              <span class="tooltiptext tooltip-lh">more</span>
            </button>
          </x-slot>
          @php
          $menus = [];
          if(Auth::user()->id == $comment->commentator->id){
            array_push($menus, ['name' => 'Delete', 'href' => '/comment/' . $comment->uuid . '/delete', 'icon' => 'delete', 'method' => 'get']);
            array_push($menus, ['name' => 'Edit', 'href' => '/comment/' . $comment->uuid . '/edit', 'icon' => 'edit', 'method' => 'get']);
          } 
          else {
            array_push($menus, ['name' => 'report', 'href' => '/comment/' . $comment->uuid . '/report', 'icon' => 'report', 'method' => 'get']);
          }
          @endphp
          <x-slot:content>            
            @foreach($menus as $menu)
            <x-dropdown-link :href="$menu['href']" :method="$menu['method']" :tooltip="$menu['name']" tooltipClass="md:hidden tooltip-lh">
              <span class="{{ $menu['icon'] }}"><span class="hidden md:inline-block ml-7">{{ $menu['name'] }}</span></span>
            </x-dropdown-link>
            @endforeach
          </x-slot>
        </x-dropdown>
        @endauth
      </div>
      <div class="w-full">
        <div class="mt-3" style="width:inherit;max-height: 100px">{{ $comment->description }}</div>
      </div>
      @endif
    @endif

  </div>
</div>
