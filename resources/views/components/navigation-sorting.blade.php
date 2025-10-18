<!-- Компонент сортировки для навигации -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="flex flex-wrap gap-2 items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">{{ $sortTitle ?? 'Все книги' }}</h2>
        <div class="flex flex-wrap gap-2">
            <span class="text-gray-600 mr-2">Сортировка:</span>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'new']) }}"
                class="px-4 py-2 rounded-lg transition-all duration-200 {{ request('sort', 'new') == 'new' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-sm' }}">
                📚 Новые
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}"
                class="px-4 py-2 rounded-lg transition-all duration-200 {{ request('sort') == 'popular' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-sm' }}">
                🔥 Популярные
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'alphabetical']) }}"
                class="px-4 py-2 rounded-lg transition-all duration-200 {{ request('sort') == 'alphabetical' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-sm' }}">
                🔤 По алфавиту
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}"
                class="px-4 py-2 rounded-lg transition-all duration-200 {{ request('sort') == 'featured' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-sm' }}">
                ⭐ Рекомендуемые
            </a>
        </div>
    </div>
</div>