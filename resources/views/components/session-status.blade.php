@props(['status', 'bgColor'])

@if ($status)
  <div 
    {!! $attributes->class([$bgColor . " items-center pl-4 shadow-sm relative flex justify-between align-top"]) !!}
  >
    {{ $status }}
    <button class="close scale-50" onclick="this.parentNode.remove()"></button>
  </div>
@endif
