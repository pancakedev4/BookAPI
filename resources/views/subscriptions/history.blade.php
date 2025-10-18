<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">История подписок</h1>

            @if($subscriptions->count())
            <div class="space-y-4">
                @foreach($subscriptions as $subscription)
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $subscription->subscription_package->name }}
                                </h3>
                                <p class="text-gray-600">
                                    {{ $subscription->subscription_package->subscription_period->title }}
                                </p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>Начало: {{ $subscription->start_date->format('d.m.Y') }}</span>
                                    <span>Окончание: {{ $subscription->end_date->format('d.m.Y') }}</span>
                                    <span class="font-medium {{ $subscription->is_active ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $subscription->is_active ? 'Активна' : 'Завершена' }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 text-right">
                                <div class="text-xl font-bold text-gray-800">
                                    {{ $subscription->subscription_package->formatted_price }}
                                </div>
                                @if($subscription->is_active)
                                <div class="text-sm text-green-600">
                                    Осталось {{ $subscription->days_left }} дней
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $subscriptions->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-history text-gray-400 text-6xl mb-4"></i>
                <p class="text-gray-500 text-xl mb-4">У вас еще нет подписок</p>
                <a href="{{ route('subscriptions.index') }}" class="btn btn-primary">
                    <i class="fas fa-crown me-2"></i>Оформить подписку
                </a>
            </div>
            @endif
        </div>
    </section>

</x-app-layout>