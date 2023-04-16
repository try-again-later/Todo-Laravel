<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav me-lg-auto mb-2 justify-content-center mb-lg-0 me-4 me-lg-0">
                <li><x-nav-link :active="Request::routeIs('home')" :href="route('home')">Домашняя</x-nav-link></li>

                @auth
                    <li><x-nav-link :active="Request::routeIs('todos')" :href="route('todos')">Список дел</x-nav-link></li>
                    <li><x-nav-link :active="Request::routeIs('users')" :href="route('users')">Список пользователей</x-nav-link></li>
                @endauth
            </ul>

            <div>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-warning">Зарегистрироваться</a>
                @endguest

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-warning">Выйти</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>
