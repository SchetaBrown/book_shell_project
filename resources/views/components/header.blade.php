<header class="bg-white shadow-md">
    <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('index') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">
            📚 BookLibrary
        </a>

        <div class="flex items-center space-x-6">
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

        <div class="flex items-center space-x-4">
            @auth
                <div class="relative">
                    <button id="profileDropdownBtn"
                        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" id="dropdownArrow">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
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
    </nav>
</header>

<script>
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdown = document.getElementById('profileDropdown');
    const arrow = document.getElementById('dropdownArrow');

    if (dropdownBtn && dropdown) {
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });

        document.addEventListener('click', function(e) {
            if (!dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        });

        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
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
