<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-8">
            <!-- Хлебные крошки -->
            <div class="mb-6">
                <div class="text-sm breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-purple-600 transition-colors">Главная</a></li>
                        <li><a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-purple-600 transition-colors">{{ Str::limit($book->title, 20) }}</a></li>
                        <li class="text-gray-500">Выбор подписки</li>
                    </ul>
                </div>
            </div>

            <div class="max-w-7xl mx-auto">
                <!-- Заголовок -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                        Выберите подписку для книги
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Для доступа к книге "<span class="font-semibold text-gray-800">{{ $book->title }}</span>" и тысячам других произведений
                    </p>
                </div>

                <!-- Информация о книге -->
                <div class="card bg-base-100 shadow-xl mb-8">
                    <div class="card-body">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-24 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                @if($book->image)
                                <img src="{{ $book->getImageUrl() }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                <i class="fas fa-book text-white text-2xl"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $book->title }}</h3>
                                <p class="text-gray-600">Автор: {{ $book->getAuthorsNames() }}</p>
                                @if($book->type_of_book)
                                <p class="text-sm text-gray-500">Тип: {{ $book->type_of_book->type }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Карточки подписок - 4 в ряд -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($subscriptionPackages as $package)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 h-full flex flex-col
                    {{ $package->is_popular ? 'border-yellow-400 relative' : 'border-transparent' }}
                    {{ $package->price == 0 ? 'border-green-400' : '' }}">

                        <!-- Бейдж для бесплатной подписки -->
                        @if($package->price == 0)
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-10">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                Бесплатно
                            </span>
                        </div>
                        @endif

                        <!-- Бейдж популярности -->
                        @if($package->is_popular && $package->price > 0)
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-10">
                            <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold">
                                Популярный
                            </span>
                        </div>
                        @endif

                        <!-- Бейдж скидки в магазине партнера -->
                        @if($package->hasPartnerDiscount() && $package->price > 0)
                        <div class="absolute -top-3 right-4 z-10">
                            <span class="{{ $package->discount_badge_color }} text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                <i class="fas fa-store me-1"></i>
                                {{ $package->discount_in_partner_store }}% у партнера
                            </span>
                        </div>
                        @endif

                        <div class="card-body pt-6 flex-1 flex flex-col">
                            <!-- Период и название -->
                            <div class="text-center mb-3">
                                <h3 class="text-lg font-semibold text-gray-700">{{ $package->subscription_period->title }}</h3>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $package->name ?? 'Пакет подписки' }}</h2>
                            </div>

                            <!-- Цена и экономия -->
                            <div class="text-center mb-3">
                                <div class="flex items-baseline justify-center space-x-2 mb-1">
                                    <span class="text-3xl font-bold 
                                    {{ $package->price == 0 
                                        ? 'text-green-600' 
                                        : 'bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent' }}">
                                        {{ $package->price == 0 ? 'Бесплатно' : $package->formatted_price }}
                                    </span>
                                </div>

                                <!-- Экономия - компактный вариант -->
                                @if($package->savings > 0)
                                <div class="mt-1 mb-1">
                                    <div class="flex items-center justify-center text-green-700">
                                        <i class="fas fa-piggy-bank text-green-500 text-sm me-1"></i>
                                        <span class="text-sm font-bold">Экономия {{ $package->formatted_savings }}</span>
                                    </div>
                                    <div class="text-xs text-green-600">
                                        {{ $package->savings_percent }}% выгоды
                                    </div>
                                </div>
                                @endif

                                @if($package->price > 0)
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $package->monthly_price }}
                                </div>
                                @endif
                            </div>

                            <!-- Особенности - компактный вариант -->
                            <div class="space-y-2 mb-4 flex-1">

                                <!-- Основные фичи БЕЗ рамок -->
                                @foreach($package->features as $feature)
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-check text-green-500 me-2 flex-shrink-0"></i>
                                    <span class="leading-tight">{{ $feature }}</span>
                                </div>
                                @endforeach

                                <!-- Дополнительные фичи для бесплатной подписки В РАМКАХ -->
                                @if($package->price == 0)
                                <div class="flex items-center text-sm text-blue-600 font-medium bg-blue-50 rounded p-2 border border-blue-200 mt-1">
                                    <i class="fas fa-star text-blue-500 me-2 flex-shrink-0"></i>
                                    <span class="leading-tight">Ограниченный доступ к библиотеке</span>
                                </div>
                                <div class="flex items-center text-sm text-blue-600 font-medium bg-blue-50 rounded p-2 border border-blue-200 mt-1">
                                    <i class="fas fa-clock text-blue-500 me-2 flex-shrink-0"></i>
                                    <span class="leading-tight">Действует 1 месяц</span>
                                </div>
                                @endif

                                <!-- Скидка в магазине партнера В РАМКЕ -->
                                @if($package->hasPartnerDiscount() && $package->price > 0)
                                <div class="flex items-center text-sm text-green-600 font-medium bg-green-50 rounded p-2 border border-green-200 mt-1">
                                    <i class="fas fa-tag text-green-500 me-2 flex-shrink-0"></i>
                                    <div>
                                        <div class="font-bold leading-tight">
                                            Скидка {{ $package->discount_in_partner_store }}% у партнеров
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Кнопка выбора -->
                            @if($package->price == 0)
                            <!-- Форма для бесплатной подписки -->
                            <form action="{{ route('subscriptions.book.subscribe', $book) }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="subscription_package_id" value="{{ $package->id }}">
                                <input type="hidden" name="payment_method" value="free">

                                <button type="submit" class="btn w-full bg-green-500 hover:bg-green-600 border-0 text-white">
                                    <i class="fas fa-gift me-2"></i>
                                    Получить бесплатно
                                </button>
                            </form>
                            @else
                            <!-- Форма для платных подписок -->
                            <form action="{{ route('subscriptions.book.subscribe', $book) }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="subscription_package_id" value="{{ $package->id }}">

                                <!-- Выбор способа оплаты -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Способ оплаты:</label>
                                    <div class="grid grid-cols-3 gap-1">
                                        <label class="flex flex-col items-center p-1 border rounded cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="payment_method" value="card" class="hidden" checked>
                                            <i class="fas fa-credit-card text-blue-500 text-sm mb-1"></i>
                                            <span class="text-xs">Карта</span>
                                        </label>
                                        <label class="flex flex-col items-center p-1 border rounded cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="payment_method" value="qiwi" class="hidden">
                                            <i class="fas fa-wallet text-orange-500 text-sm mb-1"></i>
                                            <span class="text-xs">QIWI</span>
                                        </label>
                                        <label class="flex flex-col items-center p-1 border rounded cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="payment_method" value="yandex" class="hidden">
                                            <i class="fas fa-money-bill text-yellow-500 text-sm mb-1"></i>
                                            <span class="text-xs">Yandex</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn w-full
                                {{ $package->is_popular 
                                    ? 'bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 border-0 text-white' 
                                    : 'bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 border-0 text-white' }}">
                                    <i class="fas fa-crown me-2"></i>
                                    Выбрать
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Кнопка назад -->
                <div class="text-center">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-outline btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Вернуться к книге
                    </a>
                </div>
            </div>
        </div>

        <style>
            /* Плавная анимация для всех карточек */
            .card {
                transition: all 0.3s ease-in-out;
            }

            .card:hover {
                transform: translateY(-5px);
            }

            /* Особые стили для популярной карточки */
            .border-yellow-400 {
                box-shadow: 0 10px 25px -5px rgba(251, 191, 36, 0.4);
            }
        </style>
    </section>



</x-app-layout>