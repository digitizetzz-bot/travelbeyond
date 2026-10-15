<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('partials.head')
</head>
<body class="h-full bg-white dark:bg-zinc-900 text-neutral-800 dark:text-neutral-100 antialiased overflow-x-hidden selection:bg-neutral-800 selection:text-white" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    <div class="flex min-h-screen w-full bg-[#f8f9fb] dark:bg-zinc-950">
        <!-- Dark Left Sidebar -->
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'" 
            class="hidden md:flex flex-col shrink-0 bg-[#111217] text-neutral-300 border-r border-[#1e2027] transition-all duration-300 ease-in-out sticky top-0 h-screen z-30"
        >
            <!-- Sidebar Header / Logo -->
            <div class="flex items-center justify-between px-5 h-16 border-b border-[#1c1f26]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center overflow-hidden group">
                    <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="font-semibold text-white text-base tracking-tight truncate">
                        Travel & Beyond
                    </span>
                    <span x-show="!sidebarOpen" class="font-bold text-white text-base tracking-tight">
                        TB
                    </span>
                </a>
                <button 
                    @click="sidebarOpen = !sidebarOpen" 
                    type="button" 
                    title="Toggle sidebar"
                    class="p-1 rounded-md text-neutral-400 hover:text-white hover:bg-neutral-800/80 transition"
                >
                    <svg class="size-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </button>
            </div>

            <!-- Search Bar -->
            <div class="px-4 pt-4 pb-2">
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-400">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        placeholder="Search" 
                        :class="sidebarOpen ? 'pl-9 pr-11' : 'pl-9 pr-2'"
                        class="w-full bg-[#181a21] border border-[#262a34] rounded-lg py-2 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-500 focus:ring-1 focus:ring-neutral-500 transition"
                    />
                    <span x-show="sidebarOpen" class="absolute right-2.5 text-[10px] text-neutral-400 font-mono bg-[#222631] px-1.5 py-0.5 rounded border border-[#2f3543]">
                        ⌘F
                    </span>
                </div>
            </div>

            <!-- Nav Links -->
            <div class="flex-1 overflow-y-auto px-3 py-2 space-y-6 scrollbar-none">
                <!-- Main Section -->
                <nav class="space-y-1">
                    <!-- Bookings -->
                    <a 
                        href="{{ route('admin.dashboard') }}" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-[#21242c] text-white border border-[#2b303b]' : 'text-neutral-400 hover:text-white hover:bg-[#1a1d24]' }} transition group"
                    >
                        <svg class="size-4.5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-neutral-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Bookings</span>
                    </a>

                    <!-- Services (New Module) -->
                    <a 
                        href="{{ route('admin.services') }}" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.services*') ? 'bg-[#21242c] text-white border border-[#2b303b]' : 'text-neutral-400 hover:text-white hover:bg-[#1a1d24]' }} transition group"
                    >
                        <svg class="size-4.5 shrink-0 {{ request()->routeIs('admin.services*') ? 'text-white' : 'text-neutral-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Services</span>
                    </a>

                    <!-- Tours & Packages -->
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689A1.125 1.125 0 0 0 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Tours & Packages</span>
                    </a>

                    <!-- Destinations -->
                    <a 
                        href="{{ route('admin.destinations') }}" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.destinations*') ? 'bg-[#21242c] text-white border border-[#2b303b]' : 'text-neutral-400 hover:text-white hover:bg-[#1a1d24]' }} transition group"
                    >
                        <svg class="size-4.5 shrink-0 {{ request()->routeIs('admin.destinations*') ? 'text-white' : 'text-neutral-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Destinations</span>
                    </a>

                    <!-- Ticketing (Flights/Ferries) -->
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Ticketing</span>
                    </a>

                    <!-- Inquiries & Leads -->
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Inquiries & Leads</span>
                    </a>

                    <!-- Customers -->
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Customers</span>
                    </a>
                </nav>

                <!-- Secondary Section -->
                <div class="pt-6 border-t border-[#1c1f26] space-y-1">
                    <!-- Notifications -->
                    <a 
                        href="#" 
                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <div class="flex items-center gap-3 overflow-hidden">
                            <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Notifications</span>
                        </div>
                        <span x-show="sidebarOpen" class="size-4.5 rounded-full bg-red-500 text-white font-bold text-[10px] flex items-center justify-center shrink-0">
                            7
                        </span>
                    </a>

                    <!-- Help & support -->
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Help & support</span>
                    </a>

                    <!-- Settings -->
                    <a 
                        href="{{ route('profile.edit') }}" 
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24] transition group"
                    >
                        <svg class="size-4.5 shrink-0 text-neutral-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">Settings</span>
                    </a>
                </div>
            </div>

            <!-- User Profile Bottom Bar -->
            <div class="p-3 border-t border-[#1c1f26]" x-data="{ userMenuOpen: false }">
                <div class="relative">
                    <button 
                        @click="userMenuOpen = !userMenuOpen"
                        type="button" 
                        class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-[#1a1d24] transition group text-left"
                    >
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="size-8 rounded-full bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                {{ auth()->user()?->initials() ?? 'OW' }}
                            </div>
                            <div x-show="sidebarOpen" class="overflow-hidden">
                                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()?->name ?? 'Olivia Williams' }}</p>
                                <p class="text-[10px] text-neutral-400 truncate">Administrator</p>
                            </div>
                        </div>
                        <svg x-show="sidebarOpen" class="size-4 text-neutral-500 group-hover:text-neutral-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="userMenuOpen" 
                        @click.outside="userMenuOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute bottom-full left-0 mb-2 w-48 rounded-lg bg-[#181a21] border border-[#272b36] shadow-xl py-1 z-50 text-xs"
                    >
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-neutral-300 hover:text-white hover:bg-[#222631]">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                            Profile
                        </a>
                        <a href="{{ route('appearance.edit') }}" class="flex items-center gap-2 px-3 py-2 text-neutral-300 hover:text-white hover:bg-[#222631]">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-1.603 1.5 1.5 0 0 0-.22-1.77Z"/></svg>
                            Appearance
                        </a>
                        <div class="h-px bg-[#262a34] my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 text-left">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15"/></svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 bg-[#f8f9fb] dark:bg-zinc-900">
            <!-- Mobile Top Header -->
            <header class="md:hidden flex items-center justify-between px-4 h-14 bg-[#111217] text-white border-b border-[#1e2027] sticky top-0 z-20">
                <div class="flex items-center">
                    <span class="font-semibold text-sm">Travel & Beyond</span>
                </div>
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    type="button" 
                    class="p-2 rounded-md text-neutral-400 hover:text-white"
                >
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </header>

            <!-- Mobile Menu Drawer Overlay -->
            <div 
                x-show="mobileMenuOpen" 
                x-cloak 
                class="fixed inset-0 z-50 md:hidden"
                role="dialog" 
                aria-modal="true"
            >
                <!-- Backdrop -->
                <div 
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition-opacity ease-linear duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-linear duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="mobileMenuOpen = false" 
                    class="fixed inset-0 bg-black/70 backdrop-blur-xs"
                ></div>

                <!-- Slide-over Drawer Panel -->
                <div 
                    x-show="mobileMenuOpen"
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative flex flex-col w-4/5 max-w-xs h-full bg-[#111217] text-neutral-300 border-r border-[#1e2027] shadow-2xl"
                >
                    <!-- Drawer Header -->
                    <div class="flex items-center justify-between px-5 h-16 border-b border-[#1c1f26]">
                        <span class="font-semibold text-white text-base tracking-tight">Travel & Beyond</span>
                        <button 
                            @click="mobileMenuOpen = false" 
                            type="button" 
                            class="p-1 rounded-md text-neutral-400 hover:text-white"
                        >
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Drawer Nav Items -->
                    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">
                        <nav class="space-y-1">
                            <a 
                                href="{{ route('admin.dashboard') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-[#21242c] text-white border border-[#2b303b]' : 'text-neutral-400 hover:text-white hover:bg-[#1a1d24]' }}"
                            >
                                <svg class="size-4.5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-neutral-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                </svg>
                                <span>Bookings</span>
                            </a>
                            <a 
                                href="{{ route('admin.services') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.services*') ? 'bg-[#21242c] text-white border border-[#2b303b]' : 'text-neutral-400 hover:text-white hover:bg-[#1a1d24]' }}"
                            >
                                <svg class="size-4.5 shrink-0 {{ request()->routeIs('admin.services*') ? 'text-white' : 'text-neutral-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                                <span>Services</span>
                            </a>
                            <a 
                                href="#" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24]"
                            >
                                <svg class="size-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689A1.125 1.125 0 0 0 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                                </svg>
                                <span>Tours & Packages</span>
                            </a>
                            <a 
                                href="{{ route('admin.destinations') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.destinations*') ? 'bg-[#21242c] text-white border border-[#2b303b]' : 'text-neutral-400 hover:text-white hover:bg-[#1a1d24]' }}"
                            >
                                <svg class="size-4.5 shrink-0 {{ request()->routeIs('admin.destinations*') ? 'text-white' : 'text-neutral-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <span>Destinations</span>
                            </a>
                            <a 
                                href="#" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24]"
                            >
                                <svg class="size-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                                <span>Ticketing</span>
                            </a>
                            <a 
                                href="#" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24]"
                            >
                                <svg class="size-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                </svg>
                                <span>Inquiries & Leads</span>
                            </a>
                            <a 
                                href="#" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24]"
                            >
                                <svg class="size-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <span>Customers</span>
                            </a>
                        </nav>

                        <div class="pt-4 border-t border-[#1c1f26] space-y-1">
                            <a 
                                href="{{ route('profile.edit') }}" 
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24]"
                            >
                                <svg class="size-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <span>Profile Settings</span>
                            </a>
                            <a 
                                href="{{ route('appearance.edit') }}" 
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-neutral-400 hover:text-white hover:bg-[#1a1d24]"
                            >
                                <svg class="size-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-1.603 1.5 1.5 0 0 0-.22-1.77Z" />
                                </svg>
                                <span>Appearance</span>
                            </a>
                        </div>
                    </div>

                    <!-- Drawer Footer / Logout -->
                    <div class="p-4 border-t border-[#1c1f26]">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-red-400 hover:text-red-300 hover:bg-red-500/10">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                                <span>Log out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Stage -->
            <main class="flex-1 min-w-0">
                {{ $slot }}
            </main>
        </div>
    </div>

    @fluxScripts
</body>
</html>
