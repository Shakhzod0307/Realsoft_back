<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>RealSoft Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<main  class="w-full bg-gray-100 text-gray-700" x-data="layout">
    <header class="flex w-full items-center justify-between border-b border-gray-200 bg-gray-50 p-2">
        <div class="flex items-center space-x-2">
            <button type="button" class="text-3xl" @click="asideOpen = !asideOpen">
                <i class="bx bx-menu"></i>
            </button>
{{--            <div><img src="{{asset('images/Logo.svg')}}"  alt="logo"></div>--}}
        </div>
        <div class="relative">
            <button type="button" @click="profileOpen = !profileOpen" @click.outside="profileOpen = false"
                    class="h-9 w-9 rounded-full overflow-hidden bg-red-500 text-white flex items-center justify-center">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </button>

            <div class="absolute right-2 mt-1 w-48 rounded-md border border-gray-200 bg-white shadow-md"
                 x-show="profileOpen" x-transition>
                <div class="flex items-center space-x-2 p-2">
                    <img class="object-cover w-8 h-8 rounded-full" src="{{asset('images/find_user.png')}}" alt="">
                    <div class="font-medium">{{ auth()->user()->name }}</div>
                </div>
                <div class="p-2">
                    @if(Auth::check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="flex items-center space-x-2 transition hover:text-blue-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <div class="flex">
        <!-- aside -->
        <aside class="flex flex-col w-72 space-y-2 border-r border-gray-200 bg-white p-2" x-show="asideOpen">
            {{--services--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-briefcase"></i></span>
                    <a href="{{route('admin-service-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Services</a>
                </button>
            </div>
            {{-- Blogs--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-news"></i></span>
                    <a href="{{route('admin-blog-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Blogs</a>
                </button>
            </div>
            {{-- Sectors--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="bx bx-buildings"></i></span>
                    <a href="{{route('admin-sector-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Sectors</a>
                </button>
            </div>
            {{-- Forms--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-brands fa-wpforms"></i></span>
                    <a href="{{route('admin-form-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Forms</a>
                </button>
            </div>
            {{-- Advantage--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-award"></i></span>
                    <a href="{{route('admin-advantages-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Advantages</a>
                </button>
            </div>
            {{-- Teams--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-users"></i></span>
                    <a href="{{route('admin-teams-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Teams</a>
                </button>
            </div>
            {{-- Partners--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-handshake"></i></span>
                    <a href="{{route('admin-partners-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Partners</a>
                </button>
            </div>
            {{-- Statistic--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-chart-line"></i></span>
                    <a href="{{route('admin-statistics-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Statistics</a>
                </button>
            </div>
            {{-- About--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-file-alt"></i></span>
                    <a href="{{route('admin-about-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">About</a>
                </button>
            </div>
            {{-- Images--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-images"></i></span>
                    <a href="{{route('admin-images-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Images</a>
                </button>
            </div>
            {{-- Texts--}}
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 w-full rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                    <span class="text-2xl"><i class="fa-solid fa-comment-dots"></i></span>
                    <a href="{{route('admin-texts-dashboard')}}" class="block px-2 py-1 hover:bg-gray-100">Texts</a>
                </button>
            </div>
        </aside>
        <div id="app" class="w-full">
            @yield('content')
        </div>
    </div>
</main>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("layout", () => ({
            profileOpen: false,
            asideOpen: true,
        }));
    });

</script>
</body>
</html>
