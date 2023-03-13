@props(['method' => 'get', 'href' => null, 'tooltip' => null, 'tooltipClass' => null])

@if($method == 'get')
<div {{ $attributes->merge(['class' => 'flex items-center mb-3 p-1 hover:bg-sky-300 rounded-sm' ]) }} style="min-height: 17px;">
  <a href="{{ $href }}" class="tooltip">
    {{ $slot }}
    <span class="tooltiptext {{ $tooltipClass }}">{{ $tooltip }}</span>
  </a>
</div>
@else
<div {{ $attributes->merge(['class' => 'flex items-center mb-3 p-1 px-2 hover:bg-sky-300' ]) }} style="min-height: 17px;">
  <button class="tooltip"
    onclick="Alpine.store('changeURL').execute(document.getElementById('form-mypost-index'), 'action', window.location.origin + '{{ $href }}' )">
    {{ $slot }}
    <span class="tooltiptext {{ $tooltipClass }}">{{ $tooltip }}</span>
  </button>
</div>
@endif

{{-- @php
$method = $method ?? null;
$icon = 'delete delete_text'
@endphp --}}
{{-- @props(['icon' => 'more']) --}}

{{-- @dd(isset($icon)) --}}
{{-- @if($method == 'post')
<div class="flex" x-data="{    
  changeURL($el){
    document.getElementById('form-mypost-index').action = window.location.origin + '/post/delete'
  }
  }"
}>
  <button x-on:click="changeURL($el)" {{ $attributes->merge(['class' => 'w-full block px-1 py-2 text-l300 text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</button>
</div> --}}

{{-- @else --}}
{{-- <div {{ $attributes->merge(["class" => "flex w-full px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out"]) }}> --}}
  {{-- <a class="block">{{ $slot }}</a> --}}
{{-- </div> --}}

{{-- @endif --}}





{{-- @if($method == 'get')
  <div class="flex">
    <a {{ $attributes->merge(['class' => 'w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
  </div>
  
@elseif($method == 'post')
    <div class="flex">
      <button {{ $attributes->merge(['class' => 'w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-blue-500 focus:text-white transition duration-150 ease-in-out']) }}>{{ $slot }}</button>
    </div>
@endif --}}

