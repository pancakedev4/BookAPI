<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-8">
            <!-- Хлебные крошки -->
            <div class="mb-6">
                <div class="text-sm breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-purple-600 transition-colors">Главная</a></li>
                        <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-purple-600 transition-colors">Книги</a></li>
                        <li class="text-gray-500">{{ Str::limit($book->title, 30) }}</li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Левая колонка - Обложка и основная информация -->
                <div class="lg:col-span-1">
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 sticky top-8">
                        <figure class="px-4 pt-4">
                            <div class="bg-gradient-to-br from-blue-500 to-purple-600 w-full h-80 rounded-lg flex items-center justify-center">
                                @if($book->image)
                                <img src="{{ $book->getImageUrl() }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover rounded-lg">
                                @else
                                <i class="fas fa-book text-white text-8xl"></i>
                                @endif
                            </div>
                        </figure>
                        <div class="card-body">
                            <!-- Основные действия -->
                            <div class="space-y-3">
                                @auth
                                @if($hasAccess)
                                <a href="{{ route('books.read', $book) }}" class="btn bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 border-0 text-white w-full text-lg">
                                    <i class="fas fa-book-open me-2"></i>Читать книгу
                                </a>
                                @if($book->hasAudioContent())
                                <a href="{{ route('books.audio', $book) }}" class="btn bg-gradient-to-r from-blue-400 to-purple-500 hover:from-blue-500 hover:to-purple-600 border-0 text-white w-full text-lg">
                                    <i class="fas fa-headphones me-2"></i>Слушать аудио
                                </a>
                                @endif
                                @else
                                <a href="{{ route('subscriptions.book.select', $book) }}" class="btn bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 border-0 text-white w-full text-lg">
                                    <i class="fas fa-crown me-2"></i>Оформить подписку для чтения
                                </a>
                                @endif
                                @else
                                <a href="{{ route('login') }}" class="btn bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 border-0 text-white w-full text-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Войти для чтения
                                </a>
                                @endauth
                            </div>

                            <!-- Быстрая информация -->
                            <div class="divider"></div>
                            <div class="space-y-3">
                                @if($book->type_of_book)
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-600">
                                        <i class="fas fa-tag text-blue-500 me-2"></i>Тип:
                                    </span>
                                    <span class="badge bg-blue-100 text-blue-700 border-0">{{ $book->type_of_book->type }}</span>
                                </div>
                                @endif

                                @if($book->year_of_publication)
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-600">
                                        <i class="fas fa-calendar text-purple-500 me-2"></i>Год издания:
                                    </span>
                                    <span class="text-gray-700 font-medium">{{ $book->year_of_publication }}</span>
                                </div>
                                @endif

                                @if($book->language)
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-600">
                                        <i class="fas fa-language text-blue-400 me-2"></i>Язык:
                                    </span>
                                    <span class="badge bg-purple-100 text-purple-700 border-0">{{ $book->language }}</span>
                                </div>
                                @endif

                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-600">
                                        <i class="fas fa-clock text-gray-500 me-2"></i>Добавлено:
                                    </span>
                                    <span class="text-gray-700 font-medium">{{ $book->getFormattedCreatedAt() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Правая колонка - Детальная информация -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Заголовок и основная информация -->
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="card-body">
                            <h1 class="card-title text-3xl font-bold mb-2 bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent">
                                {{ $book->title }}
                            </h1>

                            <!-- Авторы -->
                            <div class="mb-4">
                                <h2 class="text-xl font-semibold mb-3 text-gray-700 flex items-center">
                                    <i class="fas fa-user-pen text-blue-500 me-2"></i>Авторы
                                </h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($book->authors as $author)
                                    <div class="badge bg-gradient-to-r from-blue-500 to-blue-600 border-0 text-white p-4">
                                        <i class="fas fa-user me-2"></i>
                                        <span class="font-semibold">{{ $author->name }}</span>
                                        <span>{{ $author->surname }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Переводчик -->
                            @if($book->translators->isNotEmpty())
                            <div class="mb-4">
                                <h2 class="text-xl font-semibold mb-3 text-gray-700 flex items-center">
                                    <i class="fas fa-language text-purple-500 me-2"></i>Переводчики
                                </h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($book->translators as $translator)
                                    <div class="badge bg-gradient-to-r from-purple-500 to-purple-600 border-0 text-white p-4">
                                        <i class="fas fa-language me-2"></i>
                                        <span class="font-semibold">{{ $translator->name }}</span>
                                        <span>{{ $translator->surname }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Чтецы -->
                            @if($book->reciters->isNotEmpty())
                            <div class="mb-4">
                                <h2 class="text-xl font-semibold mb-3 text-gray-700 flex items-center">
                                    <i class="fas fa-microphone text-blue-400 me-2"></i>Чтецы
                                </h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($book->reciters as $reciter)
                                    <div class="badge bg-gradient-to-r from-blue-400 to-purple-400 border-0 text-white p-4">
                                        <i class="fas fa-microphone me-2"></i>
                                        <span class="font-semibold">{{ $reciter->name }}</span>
                                        <span>{{ $reciter->surname }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Описание -->
                    @if($book->description)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 text-gray-700 flex items-center">
                                <i class="fas fa-file-lines text-blue-500 me-2"></i>Описание
                            </h2>
                            <p class="text-gray-600 leading-relaxed text-lg">{{ $book->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Жанры -->
                    @if($book->genres->isNotEmpty())
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 text-gray-700 flex items-center">
                                <i class="fas fa-tags text-purple-500 me-2"></i>Жанры
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($book->genres as $genre)
                                <span class="badge bg-gradient-to-r from-blue-100 to-purple-100 text-blue-700 border-blue-200 p-3">
                                    <i class="fas fa-tag me-1"></i>{{ $genre->title }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Издательство -->
                    @if($book->publishing)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 text-gray-700 flex items-center">
                                <i class="fas fa-building text-blue-600 me-2"></i>Издательство
                            </h2>
                            <p class="text-lg text-gray-600 font-medium">{{ $book->publishing->title }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Отзывы -->
                    @if($book->feedbacks->isNotEmpty())
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 text-gray-700 flex items-center">
                                <i class="fas fa-comments text-blue-500 me-2"></i>Отзывы
                            </h2>
                            <div class="space-y-4">
                                @foreach($book->feedbacks as $feedback)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-all duration-200 hover:border-blue-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-semibold text-gray-700 flex items-center">
                                            <i class="fas fa-user-circle text-blue-400 me-2"></i>
                                            {{ $feedback->user->name ?? 'Аноним' }}
                                        </span>
                                        <div class="rating rating-sm">
                                            @for($i = 1; $i
                                            <= 5; $i++)
                                                <input type="radio"
                                                class="mask mask-star-2 {{ $i <= $feedback->rating ? 'bg-yellow-400' : 'bg-gray-300' }}"
                                                checked disabled />
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600">{{ $feedback->comment }}</p>
                                    <div class="text-sm text-gray-500 mt-2 flex items-center">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $feedback->created_at->format('d.m.Y H:i') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Кнопка назад -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('home') }}" class="btn btn-lg bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 border-0 text-white">
                    <i class="fas fa-arrow-left me-2"></i>Назад к списку книг
                </a>
            </div>
        </div>
    </section>

</x-app-layout>