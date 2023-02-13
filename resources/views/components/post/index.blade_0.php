<x-app-layout title="My Post">

  <x-session-status :status="session('success')" bgColor="bg-green-200"/>
  <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
  @php
  $active = 'draft';
  $checked = true;
  @endphp
  <div x-data="{
          activeEl: function(el){
            el.classList.add('border-b-4', 'border-sky-400');
            this.activeEl = el;
            this.show(el, 'activeEl');
          },
          active(el){
            this.activeEl.classList.remove('border-b-4', 'border-sky-400');
            this.hide(this.activeEl);
            el.classList.add('border-b-4', 'border-sky-400');
            this.activeEl = el;
            this.show(el, 'method active');
          },
          show(el, executor){ // setiap kali pindah drat/menu, akan UNCHECK semua checkbox
            console.log('executor show: ', executor);
            this.selectAll(document.querySelector('input[name=select-all-post]').checked,'method show'); // untuk UNCHECK all checkbox mengikuti UI selector nya
            document.getElementById(el.getAttribute('for')).style.display = 'block';
          },
          hide(el){
            this.selectAll(false,'method hide'); // setiap kali hiding list-post page, uncheck semua
            document.getElementById(el.getAttribute('for')).style.display = 'none';
          },
          selectAll: function(checked, executor){
            if (checked){
              document.querySelectorAll('#'+ this.activeEl.getAttribute('for') + ' input[type=checkbox]').forEach(el => el.checked = true);
              this.showCkBox(null, document.querySelectorAll('#' + this.activeEl.getAttribute('for') + ' .list-posts'));
            } else {
              document.querySelectorAll('#'+ this.activeEl.getAttribute('for') + ' input[type=checkbox]').forEach(el => el.checked = false);
              this.hideCkBox();
            }
          },
          showCkBox(selectedCBIndex = null, as){
            console.log('showCkBox');
            let cbs = document.querySelectorAll('#' + this.activeEl.getAttribute('for') + ' input[type=checkbox]');
            cbs.forEach(cb => cb.style.display = 'block');
            console.log('selectedCBIndex', selectedCBIndex);
            as.forEach(el => el.addEventListener('click', this.pDefault));
            
            {{-- as.forEach((a,akey) => a.removeEventListener('click', this.selectBox.bind(this, akey, 'method showCkBox' ))); --}}
            {{-- let selectBoxHandler;
            as.forEach((a,akey) => {
              selectBoxHandler = this.selectBox.bind(this, akey);
              a.removeEventListener('click', selectBoxHandler);
            }); --}}
            as.forEach((a,akey) => {
              {{-- console.log('this', this); --}}
              this.selectBoxHandler = this.selectBoxHandler ?? this.selectBox.bind(this, akey);
              a.removeEventListener('click', this.selectBoxHandler);
              a.addEventListener('click', this.selectBoxHandler);
            });
            {{-- as.forEach((a,akey) => a.addEventListener('click', this.selectBox.bind(this, akey, 'method showCkBox' ))); --}}
            selectedCBIndex ? (cbs[selectedCBIndex].checked = true) : null;
          },
          hideCkBox(){
            let cbs = document.querySelectorAll('#' + this.activeEl.getAttribute('for') + ' input[type=checkbox]');
            cbs.forEach(cb => cb.style.display = 'none');
            this.rpDefault();
          },
          selectBox(selectedPostIndex = null, executor){
            console.log('executor selectBox: ', executor);
            {{-- console.log(this.activeEl); --}}
            let cbs = document.querySelectorAll('#' + this.activeEl.getAttribute('for') + ' input[type=checkbox]');
            {{-- return console.log('cbs:', cbs); --}}
            {{-- console.log('cbs:' , cbs); --}}
            {{-- console.log(selectedPostIndex); --}}
            {{-- console.log(cbs[selectedPostIndex]); --}}
            cbs[selectedPostIndex].checked = !cbs[selectedPostIndex].checked;
          },
          pDefault(e){
            e.preventDefault();
          },
          rpDefault(){
            let as = document.querySelectorAll('#' + this.activeEl.getAttribute('for') + ' .list-posts');
            as.forEach((el,akey) => {
              el.removeEventListener('click', this.pDefault);
            });
          },
          {{-- init: function(draftOrPublished, executor){
            return console.log('executor init: ',executor);
            let as = document.querySelectorAll('#' + draftOrPublished + ' .list-posts');
            as.forEach((el,akey) => {
              el.addEventListener('mousedown', (event)=>{
                let eventTarget = event.target;
                let to = setTimeout(this.showCkBox.bind(this, akey, as), 500); // this[1] adalah context x-data object, this[2] 
                el.addEventListener('mouseup', (event)=> clearTimeout(to));
              });
              el.addEventListener('click', (event) => {
                this.selectBox(akey, 'init');
              });
            });
          }, --}}
        }"
        >
    <div  class="grid grid-cols-2 gap-x-16 mb-2 mt-1 mx-16"
          x-init="activeEl($el.querySelector('button[for={{ $active }}]'))">
      <button class="text-center pb-3 transition delay-100 ease-out" 
              x-on:click="active($el)" 
              for="draft">draft</button>
      <button class="text-center pb-3 transition delay-100 ease-out" 
              x-on:click="active($el)" 
              for="published">published</button>
    </div>
    <button x-on:click="hideCkBox()">Hide CBs</button>
    
    <div id="content" class="">
      
      <x-toogle-slider class="" :checkValue="$checked ?? false" name="select-all-post" id="select-all-post">Select All</x-toogle-slider>

      <!-- Draft post -->
      <div id="draft" style="display: none">
        @foreach ($posts as $key => $post)
        <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
          <input type="checkbox" class="list-post-checklist appearance-none checked:bg-blue-500 mx-2" style="display: none" />
          <a href="/post/1" class="list-posts w-full">
          {{-- <a href="javascript:;" class="w-full"> --}}
            <x-list-post 
            :title="$post->title"
            :simpleDescription="$post->simpleDescription"
            :ratingValue="$post->ratingValue"
            imgsrc="{{ url('/postImages/'. Auth::user()->username . '/thumbnail/' . $post->uuid . '_50_images.0.jpg')}}" />
          </a>
        </div>
        @endforeach
      </div>
      
      <!-- Published post -->
      <div id="published" style="display: none">
        @for ($i = 0; $i < 5; $i++)
        <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
          <input type="checkbox" class="list-post-checklist appearance-none checked:bg-blue-500 mx-2" style="display: none"/>
          <a href="/post/1" class="list-posts w-full">
            <x-list-post 
            :title="__('foobar').$i"
            :simpleDescription="__('foobar')"
            :ratingValue="85"
            imgsrc="{{ url('/contoh/nasigoreng.jpeg')}}"/>
          </a>
        </div>
        @endfor
      </div>     
    </div>
    
  </div>

  {{-- <script>
    let a = document.querySelectorAll('.list-post-container > a');
    a.forEach((el,akey) => {
      el.addEventListener('mouseup', function(e){
        let cbs = document.querySelectorAll('.list-post-checklist'); 
        cbs.forEach(cb => {
          cb.style.display = 'block';
          cbs[akey].checked = !cbs[akey].checked;
        });
        el.addEventListener('click', (e) => e.preventDefault() );
      });
    });
  </script> --}}

  @push('floatBtn')
    <div class="sticky flex justify-end bottom-5">
      <x-dropdown align="right" bottom="100%" width="48">
          <x-slot name="trigger">
            <div  style="cursor: pointer" id="float-btn" 
                  class="w-max bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full shadow-lg mr-6 p-2 active:ring-4 scale-11 transition-05">
              <svg style="scale: 0.7" xmlns="http://www.w3.org/2000/svg" height="48" width="48">
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
  @endPush
</x-app-layout>
