<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-8">
            <!-- Навигация -->
            <div class="mb-6">
                <div class="text-sm breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('books.library') }}">Библиотека</a></li>
                        <li><a href="{{ route('books.show', $book) }}">{{ Str::limit($book->title, 30) }}</a></li>
                        <li class="text-gray-500">Чтение</li>
                    </ul>
                </div>
            </div>

            <!-- Заголовок -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>
                <p class="text-gray-600 mt-2">Автор: {{ $book->getAuthorsNames() }}</p>
            </div>

            <!-- Контент книги -->
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
                <div class="prose max-w-none">
                    <!-- TODO: Заменить на реальный контент книги -->
                    <p>Здесь будет содержимое книги...</p>
                    <p>Для примера: это глава 1 книги "{{ $book->title }}"</p>
                </div>

                <!-- Навигация по главам -->
                <div class="flex justify-between mt-8 pt-6 border-t">
                    <button class="btn btn-outline">
                        <i class="fas fa-arrow-left me-2"></i>Предыдущая глава
                    </button>
                    <button class="btn btn-outline">
                        Следующая глава <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>