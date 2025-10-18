<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Навигация -->
                <div class="mb-6">
                    <div class="text-sm breadcrumbs">
                        <ul>
                            <li><a href="{{ route('home') }}">Главная</a></li>
                            <li><a href="{{ route('books.library') }}">Библиотека</a></li>
                            <li><a href="{{ route('books.show', $book) }}">{{ Str::limit($book->title, 30) }}</a></li>
                            <li class="text-gray-500">Аудиокнига</li>
                        </ul>
                    </div>
                </div>

                <!-- Плеер -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="text-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">{{ $book->title }}</h1>
                            <p class="text-gray-600">Аудиоверсия</p>
                        </div>

                        <!-- Аудиоплеер -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <audio controls class="w-full">
                                <source src="#" type="audio/mpeg">
                                Ваш браузер не поддерживает аудио элемент.
                            </audio>
                        </div>

                        <!-- Информация о чтеце -->
                        @if($book->reciters->count())
                        <div class="text-center text-gray-600">
                            <p>Читает: {{ $book->reciters->pluck('name')->implode(', ') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</x-app-layout>