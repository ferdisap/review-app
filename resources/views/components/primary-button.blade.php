@props(['bgColor' => ' from-indigo-500 via-purple-500 to-pink-500 hover:from-indigo-800 hover:via-purple-800 hover:to-pink-800 ', 'type' => 'submit', 'name' => null])

<input
  {{ $attributes->merge([
      'type' => $type,
      'name' => $name,
      'class' =>
          'bg-gradient-to-r' .
          $bgColor .
          'h-8 inline-flex items-center px-4 py-2 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest     
          focus: from-indigo-500 focus:via-purple-500 focus:to-pink-500
          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
          transition ease-in-out duration-150',
  ]) }}
  value="{{ $slot }}" />
{{-- <input {{ $attributes->merge(['type' => 'submit', 'name' => $name ?? null , 'class' => 'bg-gradient-to-r ' . $bgColor .
    ' h-8 inline-flex items-center px-4 py-2 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest     
    focus: from-indigo-500 focus:via-purple-500 focus:to-pink-500
    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
    transition ease-in-out duration-150']) }}
    value="{{ $slot }}"    
/> --}}

{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 
    bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
    border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest 
    hover:from-indigo-800 hover:via-purple-800 hover:to-pink-800
    focus: from-indigo-500 focus:via-purple-500 focus:to-pink-500
    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
    transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> --}}
