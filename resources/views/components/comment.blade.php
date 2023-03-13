
    @if ($isCommenting == true)
    <div class="my-3 text-justify block rounded-sm border" x-show="open_add_comment_form">
      <div class="w-full p-2">
        <div iscomment="true" class="flex justify-items-start items-center space-x-4">
          <img src="{{ isset(Auth::user()->username) ? '/photos/pprofile/'. Auth::user()->username . '.jpg' : '/images/no_profile_pict.png' }}" alt="" style="width:30px;height:30px"
            class="rounded-full shadow-md">
          <h6 class="text-xl font-bold">{{ Auth::user()->name ?? 'Anonymous' }}</h6>
        </div>
        <form action="/comment/{{ $postID }}/push" method="post" x-show="open_add_comment_form">
          <input type="hidden" name="qtyComment" value="{{ old('qtyComment') ?? 2 }}">
          <input type="hidden" name="open_comment_form" value="true">
          <input type="hidden" name="open_add_comment_form" value="true">
          @csrf
          <div class="w-full mb-16">
            <x-textarea class="mt-3" style="width: inherit" name="comment" rows="3">
              @error('comment') 
              {{ old('comment') }}
              @enderror
            </x-textarea>
            <x-input-error :messages="$errors->get('comment')" class="float-left" />
            {{-- <x-primary-button type="submit" class="float-right" value="send"/> --}}
            <x-primary-button type="submit" class="float-right" value="send" onclick="document.querySelector('input[name=qtyComment]').value = document.querySelectorAll('.comment-container > div').length - 1" />
          </div>
        </form>
      </div>
    </div>
      
    @else
    <div class="my-3 text-justify block rounded-lg border">
      <div class="w-full shadow-sm p-2">
      @if(isset($comment))
        <div iscomment="false" class="flex justify-items-start items-start space-x-4 h-14 border-b-2">
          <img src="/photos/pprofile/{{ $comment->commentator->username }}.jpg" alt="" style="width:30px;height:30px"
            class="rounded-full shadow-md">
          <div class="block w-full">
            <h6 class="text-xl font-bold">{{ $comment->commentator->name }}</h6>
            <p>{{ $comment->updated_at->diffForHumans() }}</p>
          </div>
          @auth
            @if(Auth::user()->id == $comment->commentator->id)
            <div class="delete w-8" role="button" onclick="window.location.href = window.location.origin + '/comment/{{ $comment->uuid }}/delete' "></div>
            <div class="edit w-8" role="button" onclick="window.location.href = window.location.origin + '/comment/{{ $comment->uuid }}/edit' "></div>
            @else
            <div class="report w-8" role="button" onclick="window.location.href = window.location.origin + '/comment/{{ $comment->uuid }}/report' "></div>
            @endif
          @endauth
        </div>
        <div class="w-full">
          <div class="mt-3" style="width:inherit;max-height: 200px">{{ $comment->description }}</div>
        </div>
      @elseif(isset($ajax))
        <div iscomment="false" class="flex justify-items-start items-center space-x-4 h-14 border-b-2">
          <img src="/photos/pprofile/:regex_commentator.username:.jpg" alt="" style="width:30px;height:30px"
            class="rounded-full shadow-md">
          <div class="block w-full">
            <h6 class="text-xl font-bold">:regex_commentator.username:</h6>
            <p>:regex_timeForHuman:</p>
          </div>
          <div class="flex space-x-2">
            {{-- jika Auth user id == commentator id, maka bisa delete/edit. Jika != maka hanya bisa report --}}
            <div class="delete tooltip w-8 hidden border shadow-sm rounded-md h-20px" role="button" onclick="window.location.href = window.location.origin + '/comment/:regex_uuid:/delete' "><span class="tooltiptext tooltip-center">delete comment</span></div>
            <div class="edit w-8 tooltip hidden border shadow-sm rounded-md h-20px" role="button" onclick="window.location.href = window.location.origin + '/comment/:regex_uuid:/edit' "><span class="tooltiptext tooltip-center">report comment</span></div>
            <div class="report w-8 tooltip hidden border shadow-sm rounded-md h-20px" role="button" onclick="window.location.href = window.location.origin + '/comment/:regex_uuid:/report' "><span class="tooltiptext tooltip-center">report comment</span></div>
          </div>
        </div>
        <div class="w-full">
          <div class="mt-3" style="width:inherit;max-height: 100px">:regex_description:</div>
        </div>
      @elseif(isset($comments))
       @foreach($comments as $comment)
       <div iscomment="false" class="flex justify-items-start items-center space-x-4 border-b-2">
         <img src="/photos/pprofile/{{ $comment->commentator->username }}.jpg" alt="" style="width:30px;height:30px"
           class="rounded-full shadow-md">
         <div class="block w-full">
           <h6 class="text-xl font-bold">{{ $comment->commentator->name }}</h6>
           <p>{{ $comment->updated_at->diffForHumans() }}</p>
         </div>
         @auth
          @if(Auth::user()->id == $comment->commentator->id)
          <div class="delete w-8" role="button" onclick="window.location.href = window.location.origin + '/comment/{{ $comment->uuid }}/delete' "></div>
          <div class="edit w-8" role="button" onclick="window.location.href = window.location.origin + '/comment/{{ $comment->uuid }}/edit' "></div>
          @else
          <div class="report w-8" role="button" onclick="window.location.href = window.location.origin + '/comment/{{ $comment->uuid }}/report' "></div>
          @endif
        @endauth
       </div>
       <div class="w-full">
         <div class="mt-3" style="width:inherit;max-height: 100px">{{ $comment->description }}</div>
       </div>
       @endforeach
      @endif
      </div>
    </div>
    @endif
