<!-- Компактная сортировка в выпадающем меню -->
<div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="btn btn-outline btn-sm">
        <i class="fas fa-sort me-2"></i>
        Сортировка: {{ $sortTitle ?? 'Новые' }}
        <i class="fas fa-chevron-down ms-2"></i>
    </div>
    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
        <li>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'new']) }}" 
               class="{{ request('sort', 'new') == 'new' ? 'active' : '' }}">
                📚 Новые
            </a>
        </li>
        <li>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" 
               class="{{ request('sort') == 'popular' ? 'active' : '' }}">
                🔥 Популярные
            </a>
        </li>
        <li>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'alphabetical']) }}" 
               class="{{ request('sort') == 'alphabetical' ? 'active' : '' }}">
                🔤 По алфавиту
            </a>
        </li>
        <li>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" 
               class="{{ request('sort') == 'featured' ? 'active' : '' }}">
                ⭐ Рекомендуемые
            </a>
        </li>
    </ul>
</div>