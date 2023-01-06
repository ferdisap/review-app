@props(['messages'])

@if ($messages)
    {{-- @dd($messages) --}}
    <ul {{ $attributes->merge(['class' => 'text-sm text-pink-500 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
