<x-app-layout title="My Post">

  <x-session-status :status="session('success')" bgColor="bg-green-200"/>
  <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
  @php
  $active = 'published';
  $checked = true;
  @endphp
  
  <div x-data="{
      ckboxDisplay: 'none',
      qtyPostDraft: null,
      qtyPostPublished: null,

      showAllPost(cat = null){
        console.log('showAllPost', this);
        this.category == undefined ? (this.category = document.getElementById('content').getAttribute('active')) : this.hideAllPost();
        cat != undefined ? (this.category = cat) : null;
        document.getElementById(this.category).style.display = 'block';
        document.querySelector('button[for=' + this.category +']').classList.add('border-b-4', 'border-sky-400');
      },

      hideAllPost(){
        document.getElementById(this.category).style.display = 'none';
        this.toogle(false);
        document.querySelector('button[for=' + this.category +']').classList.remove('border-b-4', 'border-sky-400');
      },

      init(){
        console.log('init');

        this.qtyPostDraft = document.querySelectorAll('#draft .list-post');
        this.qtyPostPublished = document.querySelectorAll('#published .list-post');

        x = document.getElementById('content');
        x.addEventListener('mousedown', (e) => {
          console.log('mousedown', this);
          
          if (this.ckboxDisplay == 'none'){
            to = setTimeout(this.showCkBox.bind(this, e), 1000);
          } else {
            to = setTimeout(this.hideCkBox.bind(this, e), 1000);
          }

          clsTimeoutHandler = function(){
            console.log('clsTimeoutHandler', this);
            clearTimeout(to);
            x.removeEventListener('mouseup', clsTimeoutHandler);
          }.bind(this);

          x.addEventListener('mouseup', clsTimeoutHandler);
        });

        this.showAllPost();

        {{-- // jika ingin otomatis selected All/not jika pindah category, taruh ini di dalam @showAllPost --}}
        this.toogle(document.getElementById('toogle-switch'));
      },

      showCkBox(){
        console.log('showCkBox', this.category);
        this.selectBoxHandler = this.selectBox.bind(this);
        document.getElementById('content').addEventListener('click', this.selectBoxHandler);

        document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach( el => el.style.display = 'block');
        this.ckboxDisplay = 'block';
      },

      hideCkBox(){
        console.log('hideCkBox', this);
        document.getElementById('content').removeEventListener('click', this.selectBoxHandler);

        document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach( el => el.style.display = 'none');
        this.ckboxDisplay = 'none';
      },

      selectBox(e){
        e.preventDefault();
        
        e.target.type == 'checkbox' ? setTimeout(() => e.target.checked = !e.target.checked, 0) : (() => {
          input = this.getTheCheckBox(e.target);
          input.checked = !input.checked; 
        })();

        sum = this.getCheckedQty();
        console.log('sum', sum, this.qtyPostDraft);
        if(sum[1].length == sum[0].length){
          this.toogle(true);
        } 
        else if (sum[1].length == 0) {
          this.toogle(false);
        }
      },
      toogle(v){
        document.getElementById('toogle-switch').checked = v;
        if(v){
          this.selectAll();
          if (this.ckboxDisplay == 'none'){
            this.showCkBox();
          }
        } else {
          this.deselectAll();
          this.hideCkBox();
        }
      },
      selectAll(){
        document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach( el => el.checked = true);
      },
      deselectAll(){
        document.querySelectorAll('#' + this.category + ' .list-post-cb').forEach( el => el.checked = false);
      },

      {{-- // Fungsi Pendukung --}}
      getCheckedQty(){
        // return [qty, fill];
        console.log('getCheckedQty',this.qtyPostDraft);
        return this.category == 'draft' ? 
        [this.qtyPostDraft, [].filter.call( document.querySelectorAll('#draft .list-post'), el => this.getTheCheckBox(el).checked)] : 
        [this.qtyPostPublished, [].filter.call( document.querySelectorAll('#published .list-post'), el => this.getTheCheckBox(el).checked)];

      },
      getTheCheckBox(el){
        targetBox = el.nodeName == 'A' ? el :
        el.parentElement.nodeName == 'A' ? el.parentElement :
        el.parentElement.parentElement.nodeName == 'A' ? el.parentElement.parentElement :
        el.parentElement.parentElement.parentElement.nodeName == 'A' ? el.parentElement.parentElement.parentElement :
        el.parentElement.parentElement.parentElement.parentElement.nodeName == 'A' ? el.parentElement.parentElement.parentElement.parentElement : null;
        input = targetBox.previousSibling.previousSibling.nodeName == 'INPUT' ? targetBox.previousSibling.previousSibling : targetBox.parentElement.querySelector('.list-post-checklist');
        return input;
      },
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
    <div><button x-on:click="getCheckedQty()">getCheckedQty</button></div>
    
    <x-toogle-slider class="" :checkValue="$checked ?? false" name="toogle-switch" id="toogle-switch">Select All</x-toogle-slider>
    <div id="content" class="" active="{{ $active }}"
    > 
      <!-- Draft post -->
      <div id="draft" style="display: none">
        @foreach ($posts as $key => $post)
        <div class="list-post-container flex items-center h-full md:px-6 px-2 mb-2">
          <input type="checkbox" class="list-post-cb appearance-none checked:bg-blue-500 mx-2" style="display: none" x-on:clicks="onclickCB($el)"/>
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
          <input type="checkbox" class="list-post-cb appearance-none checked:bg-blue-500 mx-2" style="display: none" x-on:clicks="onclickCB($el)"/>
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
        let cbs = document.querySelectorAll('.list-post-cb'); 
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
