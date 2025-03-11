<nav x-data="{ open: false }" class="bg-primario-500  ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="http://www.unam.mx" target="_blank">
                        <x-application-logo class="block h-9 w-auto " />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @canany(['consultar-listado-usuarios', 'registrar-usuario', 'cambiar-estatus-usuario'])
                    <x-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.index')">
                        {{ __('Administración de usuarios') }}
                    </x-nav-link>
                    @endcanany
                    @canany(['consultar-listado-roles', 'registrar-rol'])
                    <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')">
                        {{ __('Administración de roles') }}
                    </x-nav-link>
                    @endcanany
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden lg:flex lg:items-center lg:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center text-sm leading-4 font-medium rounded-md text-white bg-white bg-opacity-20  hover:text-primario-100  px-3 py-2  focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nombreCompleto }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Cambiar contraseña') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white   transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="space-y-1 border-t border-primario-400">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @canany(['consultar-listado-usuarios', 'registrar-usuario', 'cambiar-estatus-usuario'])
            <x-responsive-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.index')">
                {{ __('Administración de usuarios') }}
            </x-responsive-nav-link>
            @endcanany
            @canany(['consultar-listado-roles', 'registrar-rol'])
            <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')">
                {{ __('Administración de roles') }}
            </x-responsive-nav-link>
            @endcanany
        </div>

        <!-- Responsive Settings Options -->
        <div class="pb-1 border-t border-primario-300">
            <div class="px-4 py-1 bg-primario-700 text-center">
                <div class="font-bold text-base text-white">{{ Auth::user()->nombreCompleto }}</div>
                <!-- <div class="font-medium text-sm text-primario-800 ">{{ Auth::user()->email }}</div> -->
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Cambiar contraseña') }}
                </x-responsive-nav-link>

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
</nav>
