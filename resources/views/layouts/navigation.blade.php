@php
  // $menus = [['name' => 'Settings', 'href' => null, 'svg' => ''],
  $menus = [
            ['name' => 'Settings', 'href' => '/setting', 'icon' => 'gear', 'method' => 'get'],
            ['name' => 'My Posts', 'href' => '/mypost', 'icon' => 'edit_doc', 'method' => 'get'],
            ['name' => 'Saved', 'href' => '/saved', 'icon' => 'bookmark', 'method' => 'get'],
            ['name' => 'History', 'href' => '/history', 'icon' => 'history', 'method' => 'get'],
            ['name' => 'Help', 'href' => '/help', 'icon' => 'help', 'method' => 'get'],
           ]
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto">
        <div class="flex bg-gradient-to-r from-cyan-500 to-blue-500 items-center" style="height: 4rem">
            @auth
            <div class="w-1/6" style="margin-top: -0.5em">
              <!-- back icon -->
              <button onclick="history.back()" class="back black scale-11 mt-1"></button>
            </div>
            <div class="w-5/6 text-center">
              <a href="#" class=" w-auto align-middle font-bold font-forte text-txl">{{ $title ?? null }}</a>
            </div>
            @else
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="w-3/4">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>
            @endauth

            <!-- Dropdown Menu -->
            @if(Auth::user() != null)
            <div class="sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                      <button class="more_vert inline-flex">
                        <div class="drop-shadow-md hidden sm:block">{{ Auth::user()->name }}</div>
                      </button>
                    </x-slot>

                    <x-slot name="content">
                      @foreach ($menus as $menu)
                        <x-dropdown-link :href="$menu['href']" :method="$menu['method']" :tooltip="$menu['name']" tooltipClass="tooltip-lh sm:hidden" class="mt-1">
                          <span class="{{ $menu['icon'] }}"><span class="hidden sm:inline ml-7">{{ $menu['name'] }}</span></span>
                        </x-dropdown-link>
                      @endforeach
                        <hr>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                                class="sm:mt-4"
                                                tooltip="Log out"
                                                tooltipClass="sm:hidden tooltip-lh">
                                <span class="log_out"><span class="hidden sm:inline ml-7">Log out</span></span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endif

            <!-- Hamburger -->
            {{-- <div class="mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>
    
</nav>
