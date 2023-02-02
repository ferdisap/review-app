<div class="relative w-full p-2 border rounded-lg shadow-md bg-slate-50 h-max flex space-x-2">
  <div class="h-20 flex items-center bg-gray-200 rounded-sm">
    <img src="{{ $imgsrc }}" alt="" style="max-height:100%" class="rounded-sm">
  </div>
  <div class="h-20">
    <h6 class="font-bold md:text-md lg:text-lg">{{ $title }}</h6>
    <p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">{{ $simpleDescription }}</p>
  </div>
  <div class="absolute right-3 top-0">
    <x-rating ratingValue="{{ $ratingValue ?? 0 }}"/>  
  </div>
</div>