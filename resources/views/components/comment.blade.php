
<div class="my-5">
    <form action="" method="post">
      <div class="w-full">        
        @if($isCommenting == true)
        <div class="flex justify-items-start items-center space-x-4">
          <img src="/photos/pprofile/{{ Auth::user()->username }}.jpg" alt="" style="width:30px;height:30px" class="rounded-full shadow-md">
          <h6 class="text-xl font-bold">{{ Auth::user()->name }}</h6>
        </div>
        <div class="w-full">
          <x-textarea class="mt-3" style="width: inherit" name="comment" rows="3" value="{{ $value ?? null }}" />
          <span class="send float-right active:ring active:ring-2 active:ring-sky-400 active:rounded-lg" role="button">Send</span>
        </div>
        @else
        <div class="flex justify-items-start items-center space-x-4">
          <img src="/photos/pprofile/{{ Auth::user()->username }}.jpg" alt="" style="width:30px;height:30px" class="rounded-full shadow-md">
          <div class="block">
            <h6 class="text-xl font-bold">{{ Auth::user()->name }}</h6>
            <p>last update:</p>
          </div>
        </div>
        <div class="w-full">
          <div class="mt-3" style="width:inherit;max-height: 100px">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae at, fuga, aliquam in illum veritatis esse, dolorem animi quidem error quaerat itaque eveniet! Accusamus vel omnis qui fugiat excepturi repellendus.</div>
        </div>
        @endif

      </div>
    </form>
</div>