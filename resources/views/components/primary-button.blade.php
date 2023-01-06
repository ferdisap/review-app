
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 
    bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
    border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest 
    hover:from-indigo-800 hover:via-purple-800 hover:to-pink-800
    focus: from-indigo-500 focus:via-purple-500 focus:to-pink-500
    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
    transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> --}}
