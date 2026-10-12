<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | TailAdmin - Laravel Tailwind CSS Admin Dashboard Template</title>

    <!-- Scripts -->
    @moduleVite('admin')

    <!-- Theme Store -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    this.theme = savedTheme === 'dark' ? 'dark' : 'light';
                    this.updateTheme();
                },
                theme: 'light',
                resolvedTheme: 'light',
                set(value) {
                    value = value === 'dark' ? 'dark' : 'light';
                    this.theme = value;
                    localStorage.setItem('theme', value);
                    this.updateTheme();
                    window.dispatchEvent(new CustomEvent('theme-changed', { detail: value }));
                },
                toggle() {
                    this.set(this.resolvedTheme === 'dark' ? 'light' : 'dark');
                },
                updateTheme() {
                    const html = document.documentElement;
                    const isDark = this.theme === 'dark';
                    if (isDark) {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }

                    this.resolvedTheme = isDark ? 'dark' : 'light';
                    html.setAttribute('data-color-scheme', this.resolvedTheme);
                    html.dataset['theme'] = this.resolvedTheme;
                    html.style.colorScheme = this.resolvedTheme;
                    if (document.body) {
                        document.body.dataset['theme'] = this.resolvedTheme;
                        document.body.style.colorScheme = this.resolvedTheme;
                    }
                }
            });

            Alpine.store('sidebar', {
                isExpanded: false,
                isMobileOpen: false,
                isHovered: false,

                init() {
                    this.restore();

                    window.addEventListener('resize', () => {
                        this.handleResize();
                    });
                },

                restore() {
                    const savedState = localStorage.getItem('sidebarExpanded');

                    if (window.innerWidth >= 1280) {
                        this.isExpanded = savedState === null ? true : savedState === 'true';
                    } else {
                        this.isExpanded = false;
                    }

                    this.isMobileOpen = false;

                    this.syncDocumentClass();
                },

                syncDocumentClass() {
                    const expanded = this.isExpanded || this.isHovered || this.isMobileOpen;

                    document.documentElement.classList.toggle('sidebar-expanded', expanded);
                    document.documentElement.classList.toggle('sidebar-mobile-open', this.isMobileOpen);
                },

                handleResize() {
                    if (window.innerWidth < 1280) {
                        this.isMobileOpen = false;
                    }

                    this.restore();
                },

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;

                    if (window.innerWidth >= 1280) {
                        localStorage.setItem('sidebarExpanded', this.isExpanded);
                    }

                    this.syncDocumentClass();
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;

                    this.syncDocumentClass();
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;

                    this.syncDocumentClass();
                },

                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;

                        this.syncDocumentClass();
                    }
                }
            });
        });
    </script>

    <!-- Apply RTL and dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedDir = localStorage.getItem('dir');
            const savedLocale = localStorage.getItem('locale');
            if (savedDir) {
                document.documentElement.setAttribute('dir', savedDir);
            } else if (savedLocale === 'ar') {
                document.documentElement.setAttribute('dir', 'rtl');
            }
            if (savedLocale) {
                document.documentElement.setAttribute('lang', savedLocale);
            }

            const savedTheme = localStorage.getItem('theme');
            const isDark = savedTheme === 'dark';
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }

            const savedSidebar = localStorage.getItem('sidebarExpanded');
            if (window.innerWidth >= 1280 && savedSidebar !== 'false') {
                document.documentElement.classList.add('sidebar-expanded');
            }
        })();
    </script>
    

</head>

<body>

    <div class="min-h-screen xl:flex" x-data>
        @include('admin::layouts.backdrop')
        @include('admin::layouts.sidebar')

        {{-- transition-all duration-300 ease-in-out --}}
        <div class="flex-1 ml-0 ltr:xl:ml-[90px] rtl:xl:ml-0 rtl:xl:mr-[90px] [.sidebar-expanded_&]:ltr:xl:ml-[290px] [.sidebar-expanded_&]:rtl:xl:ml-0 [.sidebar-expanded_&]:rtl:xl:mr-[290px] transition-all duration-300 ease-in-out">
            <!-- app header start -->
            @include('admin::layouts.app-header')
            <!-- app header end -->
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @yield('content')
            </div>
        </div>

    </div>

    <x-core::ui.toast />

</body>

@stack('scripts')

</html>
