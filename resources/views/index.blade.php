<x-app-layout>

  <section class="text-gray-600 body-font">
    <div class="container mx-auto px-4 py-8">

      <!-- Карусель книг -->
      <div class="carousel w-full rounded-lg shadow-lg mb-8">
        @foreach($featuredBooks as $index => $book)
        <div id="slide{{ $index + 1 }}" class="carousel-item relative w-full">
          <!-- Фон карточки с градиентом -->
          <div class="w-full h-96 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
            <div class="text-center text-white p-8">
              <h2 class="text-4xl font-bold mb-4">{{ $book->title }}</h2>
              <p class="text-xl mb-4">Автор: {{ $book->getAuthorsNames() }}</p>
              @if($book->description)
              <p class="text-lg mb-6 max-w-2xl mx-auto">{{ Str::limit($book->description, 150) }}</p>
              @endif
              <!-- Тип книги -->
              @if($book->type_of_book)
              <p class="text-lg mb-2">Тип: {{ $book->type_of_book->type }}</p>
              @endif
              <a href="/books/{{ $book->id }}" class="btn btn-primary btn-lg">
                Читать подробнее
              </a>
            </div>
          </div>

          <!-- Кнопки навигации -->
          <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
            <a href="#slide{{ $index == 0 ? count($featuredBooks) : $index }}" class="btn btn-circle glass text-white">
              ❮
            </a>
            <a href="#slide{{ $index + 2 > count($featuredBooks) ? 1 : $index + 2 }}" class="btn btn-circle glass text-white">
              ❯
            </a>
          </div>

          <!-- Индикаторы слайдов -->
          <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($featuredBooks as $indicatorIndex => $indicatorBook)
            <a href="#slide{{ $indicatorIndex + 1 }}"
              class="w-3 h-3 rounded-full {{ $index == $indicatorIndex ? 'bg-white' : 'bg-white/50' }}"></a>
            @endforeach
          </div>
        </div>
        @endforeach
      </div>

      <!-- Сортировка со стандартными кнопками -->
      <div class="mb-6 bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap gap-2 items-center justify-between">
          <h2 class="text-xl font-semibold text-gray-800">{{ $sortTitle ?? 'Все книги' }}</h2>
          <div class="flex flex-wrap gap-2">
            <span class="text-gray-600 mr-2">Сортировка:</span>
            <a href="{{ route('home', ['sort' => 'new']) }}"
              class="btn {{ request('sort', 'new') == 'new' ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white border-0' : 'btn-outline' }}">
              Новые
            </a>
            <a href="{{ route('home', ['sort' => 'popular']) }}"
              class="btn {{ request('sort') == 'popular' ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white border-0' : 'btn-outline' }}">
              Популярные
            </a>
            <a href="{{ route('home', ['sort' => 'alphabetical']) }}"
              class="btn {{ request('sort') == 'alphabetical' ? 'bg-gradient-to-r from-green-500 to-teal-500 text-white border-0' : 'btn-outline' }}">
              По алфавиту
            </a>
            <a href="{{ route('home', ['sort' => 'featured']) }}"
              class="btn {{ request('sort') == 'featured' ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white border-0' : 'btn-outline' }}">
              Рекомендуемые
            </a>
          </div>
        </div>
      </div>

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

              @if(request('sort') == 'featured' && $book->is_featured)
              <span class="badge badge-info">Рекомендуем</span>
              @endif
            </div>

            <div class="card-actions justify-between items-center mt-4">
              <div class="flex flex-col text-xs text-gray-500">
                <span>{{ $book->created_at ? $book->created_at->format('d.m.Y') : 'Без даты' }}</span>
                @if($book->views_count > 0)
                <span>Просмотров: {{ $book->views_count }}</span>
                @endif
              </div>
              <a href="/books/{{ $book->id }}" class="btn btn-primary btn-sm">
                Подробнее
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Пагинация -->
      @if($books->hasPages())
      <div class="mt-8">
        {{ $books->appends(request()->query())->links() }}
      </div>
      @endif
    </div>
  </section>

  @push('scripts')
  @endpush
</x-app-layout>