
@props(['ratingValue'])
<div class="flex justify-center items-end m-1"
      x-data>
  <div star-container x-init="$store.setStarRating.run($el, {{ $ratingValue }})"></div>
  <p style="margin-top: 0;
        font-size:8px"
        >{{ $ratingValue }}</p>
</div>

