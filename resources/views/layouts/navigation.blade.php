@php
  // $menus = [['name' => 'Settings', 'href' => null, 'svg' => ''],
  $menus = [['name' => 'Settings', 'href' => '/setting', 'svg' => 'gear'],
            ['name' => 'My Posts', 'href' => '/mypost', 'svg' => 'edit_doc'],
            ['name' => 'Saved', 'href' => '/saved', 'svg' => 'bookmark'] , 
            ['name' => 'History', 'href' => '/history', 'svg' => 'history'], 
            ['name' => 'Help', 'href' => '/help', 'svg' => 'help']
           ]
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between bg-gradient-to-r from-cyan-500 to-blue-500 items-center" style="height: 4rem">
            @auth
            <div class="w-auto" style="margin-top: -0.5em">
              <!-- back icon -->
              {{-- <a href="#" class="back"></a> --}}
              <button onclick="history.back()" class="back black scale-11 mt-1"></button>
            </div>
            <div>
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
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-200 bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="drop-shadow-md">{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                      @foreach ($menus as $menu)
                        <x-dropdown-link :href="$menu['href']">
                          <x-slot:icon>
                           {{ $menu['svg'] }}
                          </x-slot>
                          {{ __($menu['name']) }}
                        </x-dropdown-link>
                      @endforeach
                        <hr>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endif

            <!-- Hamburger -->
            <div class="mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @if(Auth::user() != null)
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> --}}

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @foreach ($menus as $menu)
                <x-responsive-nav-link :href="$menu['href'] ">
                  <x-slot:icon>
                    {!! $menu['svg'] !!}
                  </x-slot>
                  {{ __($menu['name']) }}
                </x-responsive-nav-link>
                @endforeach
                {{-- <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link> --}}
                <hr>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    @endif
</nav>
