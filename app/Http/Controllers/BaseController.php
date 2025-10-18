<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\TypeOfBook;
use App\Models\Publishing;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    // public function getIndex(): View
    // {
    // $author = Author::query()->find(1);
    // $books = $author->books;
    // dump($books->toArray());

    //     $type_of_book = TypeOfBook::query()->find(2);
    //     dump($type_of_book->toArray());
    //     $books = $type_of_book->books;
    //     dump($books->toArray());

    //    $book = Book::query()->find(3);
    //     dump($book->toArray());
    //     dump($book->publishing->toArray());
    //     $books = Book::all();
    //     return view('index', compact('books'));
    // }

    public function index(Request $request): View
    {
        // Книги для карусели с загрузкой авторов
        $featuredBooks = Book::with('authors')
            ->latest()
            ->take(4)
            ->get();

        // Все книги с фильтрацией и сортировкой
        $books = Book::with(['authors', 'type_of_book'])
            ->withFilters($request)
            ->paginate(12);

        $sortTitle = (new \App\Services\BookFilterManager($request))->getSortTitle();

        return view('index', compact('featuredBooks', 'books', 'sortTitle'));
    }

    // Альтернативный вариант с избранными книгами
    public function indexWithFeatured(): View
    {
        // Если есть поле is_featured в модели
        $featuredBooks = Book::with(['authors', 'type_of_book'])
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        // Или случайные книги для карусели
        if ($featuredBooks->isEmpty()) {
            $featuredBooks = Book::with(['authors', 'type_of_book'])
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        $books = Book::with(['authors', 'type_of_book'])
            ->latest()
            ->paginate(12);

        return view('index', compact('featuredBooks', 'books'));
    }

    /**
     * Просмотр одной книги
     */
    public function show(Book $book): View
    {
        $book->load([
            'authors',
            'translators',
            'reciters',
            'genres',
            'publishing',
            'type_of_book',
            'feedbacks.user',
            'subscription_packages'
        ]);

        // Проверяем доступ пользователя к книге
        $hasAccess = Auth::check() && Auth::user()->canAccessBook($book);

        return view('show', compact('book', 'hasAccess'));
    }

    /**
     * Чтение книги (требует подписку)
     */
    public function read(Book $book): View
    {
        // Middleware subscription.access уже проверил доступ
        return view('books.read', compact('book'));
    }

    /**
     * Скачивание книги (требует подписку)
     */
    public function download(Book $book)
    {
        // Middleware subscription.access уже проверил доступ

        // TODO: Реализовать логику скачивания
        // Пример:
        if ($book->file_path && file_exists(storage_path('app/' . $book->file_path))) {
            return response()->download(storage_path('app/' . $book->file_path));
        }

        return back()->with('error', 'Файл книги не найден');
    }

    /**
     * Прослушивание аудиокниги (требует подписку)
     */
    public function audio(Book $book): View
    {
        // Middleware subscription.access уже проверил доступ

        // Проверяем, есть ли у книги аудиосодержание
        if (!$book->hasAudioContent()) {
            abort(404, 'Аудиоверсия книги не найдена');
        }

        return view('books.audio', compact('book'));
    }

    /**
     * Библиотека пользователя с фильтрацией
     */
    /**
     * Библиотека пользователя с фильтрацией
     */
    public function library(Request $request): View
    {
        $search = $request->input('search');
        $sort = $request->get('sort', 'new');

        $books = Book::with(['authors', 'genres', 'type_of_book'])
            ->forLibrary() // Используем scope для библиотеки
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('authors', function ($authorQuery) use ($search) {
                            $authorQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('surname', 'like', "%{$search}%");
                        });
                });
            })
            ->when($sort === 'new', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort === 'popular', function ($query) {
                return $query->orderBy('created_at', 'desc'); // Временно
            })
            ->when($sort === 'alphabetical', function ($query) {
                return $query->orderBy('title', 'asc');
            })
            ->when($sort === 'featured', function ($query) {
                return $query->where('is_featured', true)->orderBy('created_at', 'desc');
            })
            ->paginate(12);

        $sortTitle = match ($sort) {
            'popular' => 'Популярные',
            'alphabetical' => 'По алфавиту',
            'featured' => 'Рекомендуемые',
            default => 'Новые',
        };

        return view('books.library', compact('books', 'search', 'sortTitle'));
    }

    /**
     * Поиск книг в библиотеке с фильтрацией
     */
    public function search(Request $request): View
    {
        return $this->library($request);
    }
}
