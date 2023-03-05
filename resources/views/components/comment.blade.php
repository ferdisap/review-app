<div class="my-3 text-justify block">
  <div class="w-full">
    @if ($isCommenting == true)
      <div class="flex justify-items-start items-center space-x-4" x-show="open">
        <img src="/photos/pprofile/{{ Auth::user()->username }}.jpg" alt="" style="width:30px;height:30px"
          class="rounded-full shadow-md">
        <h6 class="text-xl font-bold">{{ Auth::user()->name }}</h6>
      </div>
      <form action="/post/{{ $postID }}/comment/push" method="post" x-show="open">
        @csrf
        <div class="w-full mb-16">
          <x-textarea class="mt-3" style="width: inherit" name="comment" rows="3"
            value="{{ $value ?? null }}" />
          <input type="hidden" name="open_comment_form" value="true">
          <x-input-error :messages="$errors->get('comment')" class="float-left" />
          <x-primary-button type="submit" class="float-right" value="send" />
        </div>
      </form>
    @else
      <div class="flex justify-items-start items-center space-x-4">
        <img src="/photos/pprofile/{{ Auth::user()->username }}.jpg" alt="" style="width:30px;height:30px"
          class="rounded-full shadow-md">
        <div class="block w-full">
          <h6 class="text-xl font-bold">{{ Auth::user()->name }}</h6>
          <p>last update:</p>
        </div>
        <x-dropdown align="right" bottom="100%">
          <x-slot:trigger>
            <button class="float-right more tooltip">
              <span class="tooltiptext tooltip-lh">more</span>
            </button>
          </x-slot>
          @php
          $menus = [
            ['name' => 'Delete', 'href' => '/comment/comment_id/delete', 'icon' => 'delete', 'method' => 'get'],
            ['name' => 'Edit', 'href' => '/comment/comment_id/edit', 'icon' => 'edit', 'method' => 'get'],
            ]
          @endphp
          <x-slot:content>            
            @foreach($menus as $menu)
            <x-dropdown-link :href="$menu['href']" :method="$menu['method']" :tooltip="$menu['name']" tooltipClass="md:hidden tooltip-lh">
              <span class="{{ $menu['icon'] }}"><span class="hidden md:inline-block ml-7">{{ $menu['name'] }}</span></span>
            </x-dropdown-link>
            @endforeach
          </x-slot>
        </x-dropdown>
      </div>
      <div class="w-full">
        <div class="mt-3" style="width:inherit;max-height: 100px">Lorem ipsum dolor sit amet consectetur
          adipisicing elit. Recusandae at, fuga, aliquam in illum veritatis esse, dolorem animi quidem error quaerat
          itaque eveniet! Accusamus vel omnis qui fugiat excepturi repellendus.</div>
      </div>
    @endif

  </div>
</div>
