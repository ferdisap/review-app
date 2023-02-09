<x-app-layout title="Create Post">
  {{-- @dd($uuid) --}}
  <div class="md:px-6 px-2 mb-2">
    <x-session-status :status="session('success')" bgColor="bg-green-200"/>
    <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
    <form action="/post/store" method="post" enctype="multipart/form-data">
      @csrf
      <!-- uuid -->
      <p class="text-gray-300 text-center">{{ $uuid }}</p>
      {{-- <p class="text-gray-300 text-center">{{ old('uuid') ?? $uuid }}</p> --}}
      <input type="hidden" name="uuid" value="{{ $uuid }}">
      {{-- <input type="hidden" name="uuid" value="{{ old('uuid') ?? $uuid }}"> --}}
      
      <!-- Title -->
      <div class="mb-5 mt-5">
        <x-input-label for="title" :value="__('Post Title')" />
        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus error="{{ $errors->get('title') ? true : false }}"/>
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
      </div>
      <!-- images -->
      <div class="flex justify-between mb-5">
        @for ($i = 0 ; $i<5 ; $i++)
        <div x-data class="bg-neutral-100 cursor-pointer hover:bg-transparent border rounded-lg flex justify-center items-center w-20 h-20 max-[640px]:w-16 max-[640px]:h-16 max-[320px]:w-8 max-[320px]:h-8"
             style="position: relative; background-color:white"
             onclick="this.querySelector('input').click()">

            <img src="{{ request()->getSchemeAndHttpHost() }}/postImages/ferdisap/thumbnail/{{ $uuid }}_50_images.{{ $i }}.jpg" 
                  id="thumbnail_{{ $i }}"
                  alt="" 
                  srcset="" 
                  style="position:absolute;max-height:100%">

            <img src="/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg" 
                  alt=""
                  class="thumbnail-img rounded-sm shadow-md"
                  style="max-height: 100%; min-width: inherit;">
                  
            <input  type="file" 
                    name="images[]" 
                    accept="image/png, image/gif, image/jpeg, image/bmp"  
                    class="absolute z-10 " 
                    style="display: none" 
                    x-on:change="$store.previewThumbnail.show($el, '#thumbnail_{{ $i }}')">
          </div>
      @endfor
      </div>
      <div class="font-medium text-ssm text-gray-700" style="margin-top:-0.75rem">*fist image will become a thumbnail</div>
      @foreach($errors->get('images.*') as $n => $img)
      <div><x-input-error :messages="$errors->get($n)" class="mt-2" /></div>      
      @endforeach

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
        <x-primary-button name='submit' bgColor=' from-purple-500 via-indigo-300 to-yellow-300 hover:from-purple-800 hover:via-indigo-800 hover:to-yellow-800'>
          save
        </x-primary-button>
        
        <!-- button Submit -->
        <x-primary-button name='submit'>
          publish
        </x-primary-button>
        
      </div>
    </form>
  </div>
</x-app-layout>