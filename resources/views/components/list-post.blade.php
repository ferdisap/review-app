{{-- class "scale-11, transition-05" ada di icon.css --}}
<div class="relative w-full p-2 border rounded-lg shadow-md bg-slate-50 h-max flex space-x-2"
     x-data="{changeSRC(el){el.src = '/svg/icon/lunch_dining_FILL0_wght400_GRAD0_opsz48.svg'}}"
     :inputValue="{{ $inputValue }}"
     style="background-image:rgba(0,0,0,0)">
  <div class="h-20 flex items-center bg-gray-200 rounded-sm">
    <img loading="lazy" src="{{ $imgsrc }}" alt="" style="max-height:100%" class="rounded-sm scale-11 transition-05" style="max-width: 50px"
    x-on:error="changeSRC($el)">
  </div>
  <div class="h-20">
    <h6 class="font-bold md:text-md lg:text-lg">{{ $title }}</h6>
    <p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">{{ $simpleDescription }}</p>
  </div>
  <div class="absolute right-3 top-0">
    <x-rating ratingValue="{{ $ratingValue ?? 0 }}"/>  
  </div>
</div>