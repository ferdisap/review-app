@props(['status', 'bgColor'])

@if ($status)
  <div class="bg-{{ $bgColor }}-200 rounded-md pl-4 pt-3 pb-4 shadow-sm mb-3 relative flex justify-between align-top">
    {{ $status }}
    <button class="close-icon w-20" onclick="this.parentNode.remove()"></button>
  </div>
@endif
