@php
$menu_settings = [
  ['name' => 'Account', 'href' => url('/setting/account'), 'svg' => null],
  ['name' => 'About', 'href' => url('/about'), 'svg' => null],
  ['name' => 'FAQ', 'href' => null, 'svg' => null],
  ['name' => 'Help', 'href' => null, 'svg' => null],
  ['name' => 'Theme', 'href' => null, 'svg' => null]
]   
@endphp
<x-app-layout title="Settings">
  <div class="py-4">
    <ul class="ml-3">
      @foreach ($menu_settings as $menu)
       <li class="mb-2"><a href="{{ $menu['href'] }}" class="font-bold text-xl hover:text-cyan-500 hover:text-4xl">{{ $menu['name'] }}</a></li> 
      @endforeach
    </ul>
  </div>
</x-app-layout>