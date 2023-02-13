<link rel="stylesheet" href="/css/slider-checkbox.css">
<div class=" w-fit flex items-center mx-4">
  <span class="text-sm">{{ $slot }}</span>
  {{-- <label class="switch origin-center scale-50 {{ $class }}" style="left: -10px" x-on:change="selectAll($el.children[0].checked, 'toogle-slider')"> --}}
  <label class="switch origin-center scale-50 {{ $class }}" style="left: -10px">
    <input type="checkbox" {{ $checkValue ? 'checked' : 'foo' }} name="{{ $name }}" id="{{ $id }}" x-on:click="toogle($el.checked)">
    <span class="slider round"></span>
  </label>
</div>