<style>
</style>

<div x-data class="fixed z-10 h-screen w-screen bg-cm-dark" id="modal-search">
  <!-- Close button -->
  <span id="search-close-btn" class="close gray fixed z-20 right-0" role="button" x-on:click="$store.search.close()"></span>

  <!-- content -->
  <div class="absolute z-20 w-8/12 h-max bg-stone-900 rounded-lg p-2 text-white" style="top:25%; right: 16.65%">
    {{-- Input search --}}
    <x-text-input class="search w-full text-white bg-transparent focus:ring-transparent focus:border-none focus:outline-none focus:ring-0" placeholder="press '/' to search" tabindex="0"></x-text-input>

    {{-- Result search --}}
    <div class="relative z-30 mt-3 text-black" id="searched-post-container">
      <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">      
        <a href="/post/1" class="list-post w-full z-30 relative" tabindex="0">
          <x-list-post 
          :inputValue="10"
          :title="'foo'"
          :simpleDescription="'foo'"
          :ratingValue="80"
          imgsrc="/foo" />
        </a>
      </div>
      <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">      
        <a href="/post/1" class="list-post w-full z-30 relative" tabindex="0">
          <x-list-post 
          :inputValue="10"
          :title="'foo'"
          :simpleDescription="'foo'"
          :ratingValue="70"
          imgsrc="/foo" />
        </a>
      </div>
      <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">      
        <a href="/post/1" class="list-post w-full z-30 relative" tabindex="0">
          <x-list-post 
          :inputValue="10"
          :title="'foo'"
          :simpleDescription="'foo'"
          :ratingValue="70"
          imgsrc="/foo" />
        </a>
      </div>
      <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">      
        <a href="/post/1" class="list-post w-full z-30 relative" tabindex="0">
          <x-list-post 
          :inputValue="10"
          :title="'foo'"
          :simpleDescription="'foo'"
          :ratingValue="70"
          imgsrc="/foo" />
        </a>
      </div>
      <a href=""><span class="float-right text-white">See 40 more result.</span></a>
    </div>
  </div>

</div>