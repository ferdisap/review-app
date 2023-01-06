<div class="flex">
  <a {{ $attributes->merge(['class' => ($icon ?? null) . ' w-full block px-2 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
</div>
