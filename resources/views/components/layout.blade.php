<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <a href="/">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="h-16 w-auto" src="{{ asset('images/savesmart.png') }}" alt="SmartSave Logo">

                        </div>
                    </a>
                    <!-- Navigation Links -->
                    @if(Auth::check())
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/user/profiles" class="{{request()->is('user/profiles') ? 'border-indigo-500' : ''  }} text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Profiles
                        </a>
                        <a href="{{ route('goals.index') }}" class="{{request()->is('goals') ? 'border-indigo-500' : ''  }} text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Goals
                        </a>
                        <a href="{{ route('stats') }}" class="{{request()->is('stats') ? 'border-indigo-500' : ''  }} text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Stats
                        </a>
                        <a href="{{ route('report.monthly') }}" class=" text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Report
                        </a>

                    </div>
                    @endif
                </div>

                <!-- Right side -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        @if(Auth::check())
                        <div>
                            <button type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>

                                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->image }}" alt="profile">
                            </button>
                        </div>
                        @else
                        <a href="login">Login</a>
                        @endif
                        <!-- Dropdown menu, show/hide based on menu state. -->
                        <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-10" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu">
                            <a href="/logout" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                logout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->

        <div class="sm:hidden hidden" id="mobile-menu">
            @if(Auth::check())
            <div class="pt-2 pb-3 space-y-1">
                <a href="/user/profiles" class=" {{request()->is('user/profiles') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 border-l-4' : ''}} hover:text-gray-500  block pl-3 pr-4 py-2  text-base font-medium">Profiles</a>
                <a href="{{ route('goals.index') }}" class="{{request()->is('goals') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 border-l-4' : ''}} text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2  text-base font-medium">Goals</a>            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->image }}" alt="profile">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->username }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">

                    <a href="logout" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        logout
                    </a>

                </div>
            </div>
            @else
            <a href="login" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Login</a>
            @endif
        </div>
    </nav>

    <script>
        // Toggle mobile menu
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true' || false;
            mobileMenuButton.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');
        });

        // Toggle user menu dropdown
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            const expanded = userMenuButton.getAttribute('aria-expanded') === 'true' || false;
            userMenuButton.setAttribute('aria-expanded', !expanded);
            userMenu.classList.toggle('hidden');
        });
    </script>


    {{ $slot }}
</body>
</html>
