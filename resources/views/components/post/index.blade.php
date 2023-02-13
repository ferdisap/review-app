<x-app-layout title="My Post">

  <x-session-status :status="session('success')" bgColor="bg-green-200"/>
  <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
  @php
  $active = 'published';
  $checked = false;
  @endphp
  {{-- 1. selanjutnya jika hideCkBox, jalankan juga @diselectAllBox dan @dsaSwitch --}}
  {{-- 2. selanjutnya tambahkan algoritma pada @selectBox jika yang di check jumlahnya sama dgn qtyPost maka jalankan @dsaSwitch / @saSwitch --}}
  {{-- 3. selanjutnya, jika di toogle maka jalankan @selectAllBox / @diselectAllbox --}}
  {{-- 4. selanjutnya jika pindah category, hilangkan semuanya (termasuk @diselectAllBox, @dsaSwitch, @hideCkBox,) dan mulai lagi dari awal, yakni @mousedownEvent --}}
  
  <div x-data="{
     postCategory: function(draftOrPublished){
        this.postCategory == 'undefined' ? this.hideAllPost() : null;
        this.postCategory = draftOrPublished.getAttribute('for');
        return this.showAllPost();
      },
      
      qtyPost:{
        draft: function(){
          this.draft = document.querySelectorAll('#draft .list-post').length;
        },
        published: function(){
          this.published = document.querySelectorAll('#published .list-post').length;
        }
      },
      mousedownEvent(){
        this.mousedownHandler = () => {
          setTimeout(this.showCkBox.bind(this),500);
        };
        document.getElementById('content').addEventListener('mousedown', this.mousedownHandler);
      },
      init(){
        this.qtyPost.draft();
        this.qtyPost.published();
        this.mousedownEvent();
      },
      showAllPost(draftOrPublished = null){
        if (draftOrPublished != null){
          this.hideAllPost();
          this.postCategory = draftOrPublished;
        }
        document.querySelector('button[for=' + this.postCategory +']').classList.add('border-b-4', 'border-sky-400');
        document.getElementById(this.postCategory).style.display = 'block';
      },
      hideAllPost(){
        document.querySelector('button[for=' + this.postCategory +']').classList.remove('border-b-4', 'border-sky-400');
        document.getElementById(this.postCategory).style.display = 'none';
      },
      showCkBox(){
        document.querySelectorAll('#' + this.postCategory + ' .list-post-checklist').forEach(el => {
          el.style.display = 'block';
        });
        this.selectBoxHandler = this.selectBox.bind(this);
        document.querySelector('#content').addEventListener('click', this.selectBoxHandler);
        
      },
      hideCkBox(){
        document.querySelectorAll('#' + this.postCategory + ' .list-post-checklist').forEach(el => {
          el.style.display = 'none';
        });
        document.querySelector('#content').removeEventListener('click', this.selectBoxHandler);
        this.mousedownEvent();
        
      },
            
      {{-- handler(context){
        console.log('context: ', context);
      },
      addHandler(){
        document.getElementById('content').removeEventListener('mousedown', this.mousedownHandler);

        this.handlerBinded = this.handler.bind(this);
        document.querySelector('nav').addEventListener('click', this.handlerBinded);

        
        window.content = document.querySelector('#published');
        this.selectBoxHandler = this.selectBox.bind(this);
        window.content.addEventListener('click', this.selectBoxHandler);
      },
      removeHandler(){
        document.querySelector('nav').removeEventListener('click', this.handlerBinded);
        window.content.removeEventListener('click', this.selectBoxHandler);
      }, --}}


      selectBox(e, executor){
        {{-- console.log('selectBox', this); --}}
        e.preventDefault();
        document.getElementById('content').removeEventListener('mousedown', this.mousedownHandler);
        targetBox = e.target.nodeName == 'A' ? e :
            e.target.parentElement.nodeName == 'A' ? e.target.parentElement :
            e.target.parentElement.parentElement.nodeName == 'A' ? e.target.parentElement.parentElement :
            e.target.parentElement.parentElement.parentElement.nodeName == 'A' ? e.target.parentElement.parentElement.parentElement :
            e.target.parentElement.parentElement.parentElement.parentElement.nodeName == 'A' ? e.target.parentElement.parentElement.parentElement.parentElement : null;
        let input = targetBox.previousSibling.previousSibling.nodeName == 'INPUT' ? targetBox.previousSibling.previousSibling : targetBox.parentElement.querySelector('.list-post-checklist');
        input.checked = !input.checked;       
        {{-- return console.log('executor', executor , e ,this); --}}

        {{-- // untuk menghitung jumlah yang dichecked --}}
        {{-- input.checked ? (this.postCategory == 'draft' ? (this.qtyPost.draft += 1) : (this.qtyPost.published += 1)) :  (this.postCategory == 'draft' ? (this.qtyPost.draft -= 1) : (this.qtyPost.published -= 1)); --}}
        {{-- console.log(this); --}}
        console.log('jumlah post: ', this.qtyPost.published);
      },
      selectAllBox(){
        document.querySelectorAll('#' + this.postCategory + ' .list-post-checklist').forEach(el => {
          el.checked = true;
        });
      },
      diselectAllBox(){
        document.querySelectorAll('#' + this.postCategory + ' .list-post-checklist').forEach(el => {
          el.checked = false;
        });
      },
      saSwitch(){
        document.querySelector('#select-all-post').checked = true;
      },
      dsaSwitch(){
        document.querySelector('#select-all-post').checked = false;
      },
      toogle(isSelectAll){
        isSelectAll ? this.selectAllBox() : this.diselectAllBox();
      }
    }">
    <div class="grid grid-cols-2 gap-x-16 mb-2 mt-1 mx-16">
      <button class="text-center pb-3 transition delay-100 ease-out" 
              x-on:click="showAllPost('draft')" 
              for="draft">draft</button>
      <button class="text-center pb-3 transition delay-100 ease-out" 
              x-on:click="showAllPost('published')" 
              for="published">published</button>
    </div>

    <div><button x-on:click="addHandler()">addHandler()</button></div>
    <div><button x-on:click="removeHandler()">removeHandler()</button></div>
    
    {{-- <div><button x-on:click="hideCkBox()">removeCkBox</button></div> --}}
    <div><button x-on:click="selectAllBox()">Select All Box</button></div>
    <div><button x-on:click="diselectAllBox()">Diselect All Box</button></div>
    <div><button x-on:click="saSwitch()">SA Switch</button></div>
    <div><button x-on:click="dsaSwitch()">DSA Switch</button></div>
    <div><button x-on:click="hideCkBox()">Hide Ck Box</button></div>
    
    <x-toogle-slider class="" :checkValue="$checked ?? false" name="select-all-post" id="select-all-post">Select All</x-toogle-slider>
    <div id="content" class="" x-init="postCategory(document.querySelector('button[for={{ $active }}]'))">      
      <!-- Draft post -->
      <div id="draft" style="display: none">
        @foreach ($posts as $key => $post)
        <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
          <input type="checkbox" class="list-post-checklist appearance-none checked:bg-blue-500 mx-2" style="display: none" value="{{ $key }}"/>
          <a href="/post/1" class="list-post w-full">
            <x-list-post 
            :inputValue="$key"
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
        @for ($key = 0; $key < 5; $key++)
        <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
          <input type="checkbox" class="list-post-checklist appearance-none checked:bg-blue-500 mx-2" style="display: none"/>
          <a href="/post/1" class="list-post w-full">
            <x-list-post 
            :inputValue="$key"
            :title="__('foobar').$key"
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
