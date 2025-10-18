<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta data-n-head="ssr" property="og:type" content="{{$og_type}}">
    <meta data-n-head="ssr" property="og:title" content="{{$og_title}}">
    <meta data-n-head="ssr" property="og:site_name" content="{{$og_title}}">
    <meta data-n-head="ssr" property="og:url" content="{{$og_url}}">
    <meta data-n-head="ssr" property="og:image" content="{{$og_image}}">
    <meta data-n-head="ssr" property="og:description" content="{{$og_description}}">
    <meta data-n-head="ssr" property="product:plural_title" content="{{$product_plural_title}}">
    <meta data-n-head="ssr" property="thumbnail" content="{{$og_image}}">
    <meta data-n-head="ssr" property="twitter:title" content="{{$og_title}}">
    <meta data-n-head="ssr" property="twitter:description" content="{{$og_description}}">
    <!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" /> -->
    @stack('styles')
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title></title>
    <meta name="description" content="">

    <!-- Facebook Meta Tags -->
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:type" content="website">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <!-- Meta Tags Generated via https://toolsaday.com -->
</head>

<body>
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-700 transition-all">
                            <i class="fas fa-book me-2 text-blue-500"></i>Книги
                        </a>
                    </li>
                    <li>
                        <a class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-700 transition-all">
                            <i class="fas fa-palette me-2 text-purple-500"></i>Комиксы, манга, артбуки
                        </a>
                    </li>
                    <li>
                        <a class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-700 transition-all">
                            <i class="fas fa-headphones me-2 text-green-500"></i>Аудиокниги
                        </a>
                    </li>
                    <li>
                        <a class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-700 transition-all">
                            <i class="fas fa-podcast me-2 text-orange-500"></i>Подкасты
                        </a>
                    </li>

                    <!-- Библиотека для мобильной версии -->
                    @auth
                    @if(Auth::user()->has_active_subscription)
                    <li>
                        <a href="{{ route('books.library') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-700 transition-all">
                            <i class="fas fa-books me-2 text-indigo-500"></i>Библиотека
                        </a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
            <!-- Логотип со ссылкой на главную -->
            <a href="{{ route('home') }}" class="btn btn-ghost text-xl bg-gradient-to-r from-gray-600 to-gray-800 bg-clip-text text-transparent font-bold hover:scale-105 transition-transform duration-300">
                <i class="fas fa-graduation-cap me-2"></i>Источник Знаний
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 rounded-lg">
                        <i class="fas fa-book me-2"></i>Книги
                    </a>
                </li>
                <li>
                    <a class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 rounded-lg">
                        <i class="fas fa-palette me-2"></i>Комиксы
                    </a>
                </li>
                <li>
                    <a class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 rounded-lg">
                        <i class="fas fa-headphones me-2"></i>Аудиокниги
                    </a>
                </li>
                <li>
                    <a class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 rounded-lg">
                        <i class="fas fa-podcast me-2"></i>Подкасты
                    </a>
                </li>

                <!-- Библиотека для десктопной версии -->
                @auth
                @if(Auth::user()->has_active_subscription)
                <li>
                    <a href="{{ route('books.library') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 rounded-lg">
                        <i class="fas fa-books me-2"></i>Библиотека
                    </a>
                </li>
                @endif
                @endauth
            </ul>
        </div>
        <div class="navbar-end space-x-2">
            @guest()
            <a href="/login" class="btn bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border border-gray-200 text-gray-700 transition-all duration-300">
                <i class="fas fa-sign-in-alt me-2"></i>Вход
            </a>
            <a href="/register" class="btn bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border border-gray-200 text-gray-700 transition-all duration-300">
                <i class="fas fa-user-plus me-2"></i>Регистрация
            </a>
            @else
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 border-0 text-white">
                    <i class="fas fa-user me-2"></i>Профиль
                </div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 bg-base-100 rounded-box w-52 mt-2">
                    <li>
                        <a href="/profile" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all">
                            <i class="fas fa-user-circle me-2 text-blue-500"></i>Мой профиль
                        </a>
                    </li>

                    <!-- Библиотека в выпадающем меню профиля -->
                    @if(Auth::user()->has_active_subscription)
                    <li>
                        <a href="{{ route('books.library') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all">
                            <i class="fas fa-books me-2 text-indigo-500"></i>Библиотека
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="/my-books" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all">
                            <i class="fas fa-bookmark me-2 text-purple-500"></i>Мои книги
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('subscriptions.history') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all">
                            <i class="fas fa-crown me-2 text-yellow-500"></i>Мои подписки
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="text-red-600 hover:bg-red-50 transition-all"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Выход
                        </a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            @endguest
        </div>
    </div>

    {{ $slot }}

    <footer class="footer bg-gradient-to-br from-gray-800 to-gray-900 text-base-content p-10 mt-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Лого и описание -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-graduation-cap text-3xl bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent me-3"></i>
                        <span class="text-2xl font-bold text-white">Источник Знаний</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Крупнейшая цифровая библиотека с тысячами книг, аудиокниг и подкастов.
                        Откройте для себя мир знаний и развлечений.
                    </p>
                    <div class="flex space-x-4">
                        <a class="btn btn-circle bg-gradient-to-r from-blue-500 to-purple-600 border-0 text-white hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                            </svg>
                        </a>
                        <a class="btn btn-circle bg-gradient-to-r from-red-500 to-pink-600 border-0 text-white hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                            </svg>
                        </a>
                        <a class="btn btn-circle bg-gradient-to-r from-blue-600 to-blue-800 border-0 text-white hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Навигация -->
                <div>
                    <h3 class="footer-title text-white mb-4">Навигация</h3>
                    <div class="grid grid-cols-1 gap-2">
                        <a href="/about" class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-info-circle me-2 text-blue-400"></i>О нас
                        </a>
                        <a href="/contact" class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-envelope me-2 text-green-400"></i>Контакты
                        </a>
                        <a class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-briefcase me-2 text-yellow-400"></i>Вакансии
                        </a>
                        <a href="/user_agreement" class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-file-contract me-2 text-purple-400"></i>Пользовательское соглашение
                        </a>
                    </div>
                </div>

                <!-- Поддержка -->
                <div>
                    <h3 class="footer-title text-white mb-4">Поддержка</h3>
                    <div class="grid grid-cols-1 gap-2">
                        <a class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-question-circle me-2 text-blue-300"></i>Помощь
                        </a>
                        <a class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-gift me-2 text-yellow-300"></i>Авторам
                        </a>
                        <a class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-shield-alt me-2 text-green-300"></i>Безопасность
                        </a>
                        <a class="link link-hover text-gray-300 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-mobile-alt me-2 text-purple-300"></i>Приложения
                        </a>
                    </div>
                </div>
            </div>

            <!-- Копирайт -->
            <div class="border-t border-gray-700 mt-8 pt-6 text-center">
                <aside>
                    <p class="text-gray-400">
                        Copyright © {{ date('Y') }} - Все права защищены Источник Знаний
                    </p>
                </aside>
            </div>
        </div>
    </footer>
</body>
{{$_SERVER['REQUEST_URI']}}

</html>