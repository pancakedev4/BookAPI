<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-2xl mx-auto text-center">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check text-green-500 text-3xl"></i>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-800 mb-4">Подписка успешно оформлена!</h1>

                        <p class="text-gray-600 mb-6">
                            @if(isset($book))
                            Теперь у вас есть доступ к книге "{{ $book->title }}" и всей библиотеке.
                            @else
                            Теперь у вас есть доступ ко всей библиотеке книг.
                            @endif
                        </p>

                        <!-- Информация о подписке -->
                        @if(isset($subscription))
                        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                            <h3 class="font-semibold text-gray-800 mb-2">Детали подписки:</h3>
                            <p class="text-sm text-gray-600">
                                Пакет: {{ $subscription->subscription_package->name }}<br>
                                Действует до: {{ $subscription->end_date->format('d.m.Y') }}<br>
                                Осталось дней: {{ $subscription->days_left }}
                            </p>
                        </div>
                        @endif

                        <div class="space-y-4">
                            @if(isset($book))
                            <a href="{{ route('books.read', $book) }}" class="btn btn-primary btn-lg w-full">
                                <i class="fas fa-book-open me-2"></i>Читать книгу сейчас
                            </a>
                            @endif

                            <a href="{{ route('books.library') }}" class="btn btn-secondary btn-lg w-full">
                                <i class="fas fa-books me-2"></i>Перейти в библиотеку
                            </a>

                            <a href="{{ route('subscriptions.history') }}" class="btn btn-outline btn-lg w-full">
                                <i class="fas fa-history me-2"></i>Мои подписки
                            </a>

                            <a href="{{ route('home') }}" class="btn btn-ghost btn-lg w-full">
                                <i class="fas fa-home me-2"></i>На главную
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>