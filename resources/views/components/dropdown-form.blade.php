@php
  $title = $title ?? null;
  // $open = true; // buat development saja. Nanti dihapus ini.
  // $fetchData = true
@endphp
<div x-data="{
  open: {{ $open }},
  {{-- fetchData: (function(){
    if ({{ $fetchData }}){
      $store.fill_input.getFormData($el);
      return true;
    }
    return false;
  })(), --}}
  icon: this.open ? 'collapse-icon' : 'expand-icon'
}" class="relative mb-8">
  <div x-on:click="(()=>{
      open = ! open;
      icon = (icon == 'expand-icon' ? 'collapse-icon' : 'expand-icon');
      {{-- if (open) {
        if (fetchData){
          $store.fill_input.getFormData($el.parentNode);
        }
      } --}}
    })()" class="bg-gray-300 py-4 rounded-md px-2 relative text-center shadow-md" :class="icon">
    <span class="font-bold">{{ $title }}</span>
  </div>

  <div x-show="open" class="bg-gray-100 rounded-md px-6 pt-5 pb-4 shadow-sm ml-2 mr-1" style="margin-top: -10px;">
    {{ $form }}
  </div>
</div>