<div x-data class="bg-cm-dark hidden" id="modal-search">
  <!-- Close button -->
  <span id="search-close-btn" class="close gray fixed z-20 right-0" role="button"
    x-on:click="$store.search.close()"></span>

  <!-- content -->
  <div class="absolute z-20 w-8/12 h-max bg-stone-900 rounded-lg p-2 text-white" style="top:25%; right: 16.65%"
    x-on:click.outside="$store.search.close(event)">
    {{-- Input search --}}
    <p class="w-full mb-4 text-center">SEARCH</p>
    <x-text-input id="search-input" name="search-input" class="w-full mb-2 text-white bg-transparent"
      placeholder="press '/' to search" tabindex="0" onclick="event.preventDefault();this.focus()" autocomplete="off" />
  </div>

</div>
