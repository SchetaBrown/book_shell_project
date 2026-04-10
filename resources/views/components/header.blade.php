<header class="bg-white shadow-md">
    <nav class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <a href="{{ route('index') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">
                📚 BookLibrary
            </a>

            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-600 transition">
                    Главная
                </a>

                <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-blue-600 transition">
                    Книги
                </a>

                @if (auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('authors.index') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Авторы
                    </a>
                @endif

                <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-blue-600 transition">
                    Категории
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="relative">
                        <button id="profileDropdownBtn"
                            class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" id="dropdownArrow">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div id="profileDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                            <a href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-t-md">
                                👤 Профиль
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-b-md">
                                    🚪 Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login.create') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Вход
                    </a>
                    <a href="{{ route('register.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Регистрация
                    </a>
                @endauth
            </div>

            <button id="mobileMenuBtn" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden mt-4 pt-4 border-t flex flex-col space-y-3">
            <a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                Главная
            </a>

            <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                Книги
            </a>

            @if (auth()->user() && auth()->user()->isAdmin())
                <a href="{{ route('authors.index') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                    Авторы
                </a>
            @endif

            <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-blue-600 transition py-2">
                Категории
            </a>

            <div class="border-t pt-3 mt-2">
                @auth
                    <a href="{{ route('profile.show') }}" class="block text-gray-700 hover:text-blue-600 transition py-2">
                        👤 Профиль
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left text-gray-700 hover:text-blue-600 transition py-2">
                            🚪 Выйти
                        </button>
                    </form>
                @else
                    <a href="{{ route('login.create') }}" class="block text-gray-700 hover:text-blue-600 transition py-2">
                        Вход
                    </a>
                    <a href="{{ route('register.create') }}"
                        class="block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center mt-2">
                        Регистрация
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<script>
    // Десктопный дропдаун
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdown = document.getElementById('profileDropdown');
    const arrow = document.getElementById('dropdownArrow');

    if (dropdownBtn && dropdown) {
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
            if (arrow) arrow.classList.toggle('rotate-180');
        });

        document.addEventListener('click', function(e) {
            if (dropdownBtn && dropdown && !dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });

        if (dropdown) {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    }

    // Мобильное бургер-меню
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
    }

    #profileDropdownBtn svg {
        transition: transform 0.2s ease;
    }
</style>
