<x-app-layout title="Create Post">
  <div class="md:px-6 px-2 mb-2">
    <form action="/post/store" method="post" enctype="multipart/form-data">
      @csrf
      <!-- uuid -->
      <p class="text-gray-300 text-center">{{ old('id') ?? $uuid }}</p>
      <input type="hidden" name="id" value="{{ old('id') ?? $uuid }}">

      <!-- Title -->
      <div class="mb-5 mt-5">
        <x-input-label for="title" :value="__('Post Title')" />
        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus error="{{ $errors->get('title') ? true : false }}"/>
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
      </div>
      <!-- images -->
      <div class="flex justify-between mb-5">
        @for ($i = 0 ; $i<5 ; $i++)
        {{-- <div class="border rounded-lg flex justify-center items-center w-20 h-20 max-[640px]:w-16 max-[640px]:h-16 max-[320px]:w-8 max-[320px]:h-8">
          <img src="http://review-app.test/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg" alt="" class="rounded-sm shadow-md">
        </div> --}}
        <div class="mb-2" x-data="{
          previewImage: function(thisEl){
            const FR = new FileReader();

            FR.addEventListener('load', () => {
              $el.querySelector('img').src = FR.result;
            },false);

            FR.readAsDataURL(thisEl.files[0]);
          }
        }">
          <div class="bg-neutral-100 hover:bg-transparent border rounded-lg flex justify-center items-center w-20 h-20 max-[640px]:w-16 max-[640px]:h-16 max-[320px]:w-8 max-[320px]:h-8">

            @php
            // $thumbnailSrc = asset('postImages/ferdisap/thumbnail/846f12f5-7f42-465d-95b2-88c91cc7a0f9_50_01.jpg')
            @endphp
            {{-- <img src="{{ $thumbnailSrc ?? 'http://review-app.test/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg' }}"  --}}
            <img src="http://review-app.test/postImages/ferdisap/thumbnail/{{ $uuid }}_50_{{ $i }}.png" 
                  alt=""
                  class="thumbnail-img rounded-sm shadow-md"
                  role="button"
                  onclick="this.nextElementSibling.click()"
                  style="max-height: 100%; min-width: inherit;">
                  
            <input  type="file" 
                    name="images[]" 
                    accept="image/png, image/gif, image/jpeg, image/bmp"  
                    class="absolute z-10 " 
                    style="display: none" 
                    x-on:change="previewImage($el)">
          </div>
        </div>
      @endfor
      </div>
      <script>
        function changeSRC(el,src, imgFormats=[]){
          if (typeof imgFormats[0] == 'undefined'){
            return el.src =  window.location.origin + "/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg";
          }  
          el.src = src + imgFormats[0];
          imgFormats.shift();
          el.addEventListener('error', function(){
            changeSRC(el, src, imgFormats);
          });
        }

        const formats = ['.jpg', '.gif', '.bmp'];
        const regex = /\.\w+$/gm;

        let imgs = document.querySelectorAll('.thumbnail-img');
        imgs.forEach(img => {  
          let src = img.src.replace(regex, '');
          let imgFormats = formats.slice();
          img.addEventListener('error', function(){
            changeSRC(this, src, imgFormats);
          });
        });
      </script>
      <div class="font-medium text-ssm text-gray-700" style="margin-top:-0.75rem">*fist image will become a thumbnail</div>
      <div><x-input-error :messages="$errors->get('images')" class="mt-2" /></div>

      <!-- Simple Description -->
      <div class="w-full mb-5 mt-5">
        <x-input-label for="simpleDescription" :value="__('Simple Description')" />
        <x-textarea class="max-h-32 w-full" name="simpleDescription" id="simple_description" :value="old('simpleDescription')"/>
        <p class="mr-3 italic font-light text-dsm text-gray-700 float-right" style="margin-top: -5px">max 100 word</p>
        <x-input-error :messages="$errors->get('simpleDescription')" class="mt-2" />
      </div>

      <!-- Detail Description -->
      <div class="w-full mb-5 mt-5">
        <x-input-label for="detailDescription" :value="__('Detail Description')" />
        <x-textarea class="max-h-96 w-full" name="detailDescription" id="detailDescription" :value="old('detailDescription')"/>
        <p class="mr-3 italic font-light text-dsm text-gray-700 float-right" style="margin-top: -5px">max 1000 word</p>
        <x-input-error :messages="$errors->get('detailDescription')" class="mt-2" />
      </div>

      <div class="text-end mt-5 flex justify-between px-5">
        
        <!-- button Save -->
        <x-primary-button name='save' bgColor=' from-purple-500 via-indigo-300 to-yellow-300'>
          save
        </x-primary-button>
        
        <!-- button Submit -->
        <x-primary-button name='submit'>
          Submit
        </x-primary-button>
        
      </div>
    </form>
  </div>
</x-app-layout>