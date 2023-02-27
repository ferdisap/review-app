
<div x-data class="fixed z-10 h-screen w-screen bg-cm-dark hidden" id="modal-search">
    <!-- Close button -->
    <span id="search-close-btn" class="close gray fixed z-20 right-0" role="button"
        x-on:click="$store.search.close()"></span>

    <!-- content -->
    <div class="absolute z-20 w-8/12 h-max bg-stone-900 rounded-lg p-2 text-white" style="top:25%; right: 16.65%">
        {{-- Input search --}}
        <x-text-input id="search-input" name="search-input"
            class="search w-full mb-2 text-white bg-transparent"
            placeholder="press '/' to search" tabindex="0"></x-text-input>

        {{-- Result search --}}
        {{-- <a href="/post/1" class="list-post-container">
            <div class="list-post w-full z-30 relative">              
              <div class="" x-data="{changeSRC(el){el.src = '/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg'}}">
                <div class="">
                  <img loading="lazy" src="/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg" alt="" style="max-height:100%" class="scale-11 transition-05"
                  x-on:error="changeSRC($el)">
                </div>
                <div class="">
                  <h6 class="font-bold md:text-md lg:text-lg">FOO</h6>
                  <p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">bar</p>
                </div>
                <div class="">
                  <div class="">
                    <div class="">
                      <span class="star orange"></span> 
                      <span class="star orange"></span> 
                      <span class="star orange"></span> 
                      <span class="star orange"></span> 
                      <span class="star orange-to-black"></span> 
                    </div>
                    <p class="text-dsm">90</p>
                  </div>
                </div>
              </div>
            </div>
        </a>
       
        <a href="/post/1" class="list-post-container">
            <div class="list-post w-full z-30 relative text-white">
               See 40 more results.
            </div>
        </a> --}}

    </div>

</div>
