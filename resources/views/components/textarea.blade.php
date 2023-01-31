@props(['error' => $error ?? false,
        'error_css' => 'ring-2 ring-offset-2 ring-pink-400 focus:border-pink-500 focus:ring-pink-500 focus:outline-none',
        'noerror_css' => 'focus:ring-sky-500 focus:border-sky-500 focus:outline-none focus:ring-2',
        'class', 'name', 'id', 'value'
      ])
{{-- <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>  ($error ? $error_css : $noerror_css) . ' text-sm  py-2 px-3 border-gray-300 rounded-md shadow-sm']) !!}> --}}

<textarea name="{{ $name }}" id="{{ $id }}" cols="30" rows="10" 
          class="bg-white border-gray-300 border rounded-md shadow-sm {{ $class }} focus:ring-sky-500 focus:border-sky-500 focus:outline-none focus:ring-2"
          >{{ $value ?? null }}
</textarea>