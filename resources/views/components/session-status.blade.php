@props(['status', 'bgColor'])

@if ($status)
  <div 
    {!! $attributes->class([$bgColor . " animate1s items-center pl-4 shadow-sm relative flex justify-between align-top"]) !!}
  >
    {{ $status }}
    <button class="close black scale-50" onclick="this.parentNode.remove()"></button>
  </div>
@endif
