@props(['align' => 'right', 'width' => null, 'contentClasses' => 'py-1 bg-white', 'bottom' => false])
{{-- @props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white']) --}}

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'bottom':
        $alignmentClasses = 'origin-bottom';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="w-fit">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 rounded-md shadow-lg {{ $alignmentClasses }} mb-5 mr-3 ml-3"
            style="display: none; bottom: {{ $bottom }}"
            @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-neutral-100 shadow-lg {{ $contentClasses }} pr-2 pl-1 w-max pb-2" style="min-width:26px">
            {{ $content }}
        </div>
    </div>
</div>
