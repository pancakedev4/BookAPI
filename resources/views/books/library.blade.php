<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-8">
            <!-- Хлебные крошки -->
            <div class="mb-6">
                <div class="text-sm breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-purple-600 transition-colors">Главная</a></li>
                        <li class="text-gray-500">Библиотека</li>
                    </ul>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-8">Моя библиотека</h1>

            <!-- Поиск и сортировка -->
            <div class="mb-6 space-y-4">
                <!-- Поле поиска -->
                <div class="bg-white rounded-lg shadow p-4">
                    <form action="{{ route('books.search') }}" method="GET" class="max-w-md">
                        <div class="join w-full">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Поиск по книгам и авторам..."
                                class="input input-bordered join-item w-full">
                            <button type="submit" class="btn btn-primary join-item">
                                Найти
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Сортировка -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex flex-wrap gap-2 items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $sortTitle ?? 'Все книги' }}</h2>
                        <div class="flex flex-wrap gap-2">
                            <span class="text-gray-600 mr-2">Сортировка:</span>
                            <a href="{{ route('books.library', array_merge(request()->query(), ['sort' => 'new'])) }}"
                                class="btn {{ request('sort', 'new') == 'new' ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white border-0' : 'btn-outline' }}">
                                Новые
                            </a>
                            <a href="{{ route('books.library', array_merge(request()->query(), ['sort' => 'popular'])) }}"
                                class="btn {{ request('sort') == 'popular' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white border-0' : 'btn-outline' }}">
                                Популярные
                            </a>
                            <a href="{{ route('books.library', array_merge(request()->query(), ['sort' => 'alphabetical'])) }}"
                                class="btn {{ request('sort') == 'alphabetical' ? 'bg-gradient-to-r from-green-500 to-teal-500 text-white border-0' : 'btn-outline' }}">
                                По алфавиту
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($books->count())
            <!-- Сетка книг -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($books as $book)
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <figure class="px-4 pt-4">
                        <div class="w-full h-48 rounded-lg flex items-center justify-center overflow-hidden">
                            <img
                                src="{{ $book->getImageUrl() }}"
                                alt="{{ $book->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="bg-gradient-to-br from-blue-400 to-purple-500 w-full h-48 rounded-lg flex items-center justify-center hidden">
                                <span class="text-white text-2xl font-bold">Книга</span>
                            </div>
                        </div>
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title text-gray-800">{{ $book->title }}</h2>
                        <p class="text-gray-600">Автор: {{ $book->getAuthorsNames() }}</p>
                        <!-- Тип книги -->
                        @if($book->type_of_book)
                        <p class="text-gray-600">Тип: {{ $book->type_of_book->type }}</p>
                        @endif
                        @if($book->description)
                        <p class="text-sm text-gray-500 mt-2">{{ Str::limit($book->description, 100) }}</p>
                        @endif

                        <!-- Бейджи для визуализации сортировки -->
                        <div class="flex flex-wrap gap-1 mt-2">
                            @if(request('sort', 'new') == 'new' && $book->created_at)
                            @if($book->created_at->gt(now()->subDays(30)))
                            <span class="badge badge-success">Новинка</span>
                            @endif
                            @endif

                            @if(request('sort') == 'popular' && $book->views_count && $book->views_count > 100)
                            <span class="badge badge-warning">Популярная</span>
                            @endif
                        </div>

                        <div class="card-actions justify-between items-center mt-4">
                            <div class="flex flex-col text-xs text-gray-500">
                                <span>{{ $book->created_at ? $book->created_at->format('d.m.Y') : 'Без даты' }}</span>
                                @if($book->views_count > 0)
                                <span>Просмотров: {{ $book->views_count }}</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('books.read', $book) }}" class="btn btn-primary btn-sm">
                                    Читать
                                </a>
                                @if($book->hasAudioContent())
                                <a href="{{ route('books.audio', $book) }}" class="btn btn-ghost btn-sm">
                                    Аудио
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Пагинация -->
            <div class="mt-8">
                {{ $books->appends(request()->query())->links() }}
            </div>
            @else
            <!-- Сообщение когда книги не найдены -->
            <div class="text-center py-12">
                <div class="bg-white rounded-lg shadow p-8 max-w-md mx-auto">
                    <div class="text-6xl mb-4">📚</div>
                    <p class="text-gray-500 text-xl mb-4">
                        @if(request('search'))
                        По запросу "{{ request('search') }}" книги не найдены
                        @else
                        В библиотеке пока нет книг
                        @endif
                    </p>
                    @if(request('search'))
                    <a href="{{ route('books.library') }}" class="btn btn-primary">
                        Показать все книги
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </section>
</x-app-layout>