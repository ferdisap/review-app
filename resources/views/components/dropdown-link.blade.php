@php
$method = $method ?? null
@endphp

@if($method == 'post')
<div class="flex" x-data="{    
  changeURL($el){
    document.getElementById('form-mypost-index').action = window.location.origin + '/post/delete'
  }
  }"
}>
  <button x-on:click="changeURL($el)" {{ $attributes->merge(['class' => 'w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</button>
</div>

@else
<div class="flex">
  <a {{ $attributes->merge(['class' => 'w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
</div>

@endif





{{-- @if($method == 'get')
  <div class="flex">
    <a {{ $attributes->merge(['class' => 'w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
  </div>
  
@elseif($method == 'post')
    <div class="flex">
      <button {{ $attributes->merge(['class' => 'w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</button>
    </div>
@endif --}}

