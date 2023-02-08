<div class="relative w-full p-2 border rounded-lg shadow-md bg-slate-50 h-max flex space-x-2">
  <div 
    {{-- x-data="{
      changeSRC(){
        const imgFormats = ['.gif', '.bmp', '.jpeg', '.jpg'];
        const regex = /\.\w+$/gm;
        
        let img = $el.querySelector('img');
        let src = img.src.replace(regex, '');

        function execute(img,src, imgFormats=[]){
          if (typeof imgFormats[0] == 'undefined'){
            console.log(img.src);
            console.log('format terakhir', imgFormats[0]);
            return img.src =  window.location.origin + '/svg/icon/add_FILL1_wght400_GRAD0_opsz20.svg';
          }

          img.src = src + imgFormats[0];
          imgFormats.shift();
        }

        img.addEventListener('error', function(){
          execute(img, src, imgFormats);
        });
      },
    }"  --}}
    class="h-20 flex items-center bg-gray-200 rounded-sm">
    <img loading="lazy" x-init="$store.changeSRC.execute($el)" src="{{ $imgsrc }}" alt="" style="max-height:100%" class="rounded-sm thumbnail-img">
  </div>
  <div class="h-20">
    <h6 class="font-bold md:text-md lg:text-lg">{{ $title }}</h6>
    <p class="text-ssm sm:text-sm md:text-md lg:text-lg xl:text-xl">{{ $simpleDescription }}</p>
  </div>
  <div class="absolute right-3 top-0">
    <x-rating ratingValue="{{ $ratingValue ?? 0 }}"/>  
  </div>
</div>