<x-app-layout>
<div class="flex gap-4 mt-6">
    @auth
        @if($hasAccess)
            <a href="{{ route('books.read', $book) }}" class="btn btn-primary btn-lg">
                <i class="fas fa-book-open me-2"></i>Читать книгу
            </a>
            @if($book->hasAudioContent())
            <a href="{{ route('books.audio', $book) }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-headphones me-2"></i>Слушать аудио
            </a>
            @endif
        @else
            <a href="{{ route('subscriptions.book.select', $book) }}" class="btn btn-primary btn-lg">
                <i class="fas fa-crown me-2"></i>Оформить подписку для чтения
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt me-2"></i>Войти для чтения
        </a>
    @endauth
</div>
</x-app-layout>