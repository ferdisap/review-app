{{-- <svg id="star1" xmlns="http://www.w3.org/2000/svg" height="24" width="24">
    <path
        d="m8.85 17.825 3.15-1.9 3.15 1.925-.825-3.6 2.775-2.4-3.65-.325-1.45-3.4-1.45 3.375-3.65.325 2.775 2.425ZM7.775 19.3 8.9 14.5l-3.725-3.225 4.9-.425L12 6.325l1.925 4.525 4.9.425L15.1 14.5l1.125 4.8L12 16.75ZM12 13.25Z" />
</svg> --}}
@props(['ratingValue'])
<div class="flex justify-center items-end">
  <svg id="star" xmlns="http://www.w3.org/2000/svg" height="24" width="24">
    <defs>
        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="{{ $ratingValue }}%" style="stop-color:rgb(255, 255, 0)" />
            <stop offset="{{ $ratingValue + 10 }}%" style="stop-color:rgb(255,0,0)" />
        </linearGradient>
    </defs>
    <path d="M7.775 19.3 8.9 14.5l-3.725-3.225 4.9-.425L12 6.325l1.925 4.525 4.9.425L15.1 14.5l1.125 4.8L12 16.75Z" />
</svg>
<p style="margin-top: 0;
        font-size:8px"
        >{{ $ratingValue }}</p>
</div>

<style>
    path {
        fill: url(#grad1)
    }
</style>
