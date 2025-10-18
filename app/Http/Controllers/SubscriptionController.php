<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPeriod;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Страница выбора подписки для книги
     */
    public function select(Book $book): View
    {
        $subscriptionPackages = $this->getSubscriptionPackages();

        return view('subscriptions.select', compact('book', 'subscriptionPackages'));
    }

    /**
     * Общая страница подписок
     */
    public function index(): View
    {
        $subscriptionPackages = $this->getSubscriptionPackages();
        $popularPackage = $subscriptionPackages->firstWhere('is_popular', true);

        return view('subscriptions.index', compact('subscriptionPackages', 'popularPackage'));
    }

    /**
     * Получение пакетов подписок (4 карточки с бесплатной первой)
     */
    private function getSubscriptionPackages()
    {
        // Получаем существующие платные подписки
        $paidPackages = SubscriptionPackage::with('subscription_period')
            ->where('price', '>', 0)
            ->ordered()
            ->take(3) // Берем 3 платные подписки
            ->get();

        // Создаем или получаем бесплатную подписку
        $freePackage = $this->getOrCreateFreePackage();

        // Объединяем: бесплатная + 3 платные
        return collect([$freePackage])->merge($paidPackages);
    }

    /**
     * Создание или получение бесплатной подписки
     */
    private function getOrCreateFreePackage()
    {
        // Ищем бесплатную подписку
        $freePackage = SubscriptionPackage::where('price', 0)->first();

        if (!$freePackage) {
            // Создаем период для бесплатной подписки
            $freePeriod = SubscriptionPeriod::firstOrCreate(
                ['title' => '1 месяц'],
                ['discount_amount' => 0]
            );

            // Создаем бесплатную подписку
            $freePackage = SubscriptionPackage::create([
                'subscription_period_id' => $freePeriod->id,
                'name' => 'Стартовая',
                'price' => 0,
                'discount_in_partner_store' => 0,
            ]);
        }

        return $freePackage;
    }

    /**
     * Оформление подписки
     */
    public function subscribe(Request $request, Book $book = null): RedirectResponse
    {
        // Проверяем авторизацию
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для оформления подписки необходимо авторизоваться.');
        }

        $request->validate([
            'subscription_package_id' => 'required|exists:subscription_packages,id',
            'payment_method' => 'required|in:card,qiwi,yandex,free',
        ]);

        $subscriptionPackage = SubscriptionPackage::findOrFail($request->subscription_package_id);

        // Для бесплатной подписки автоматически ставим payment_method = 'free'
        $paymentMethod = $subscriptionPackage->price == 0 ? 'free' : $request->payment_method;

        // Создаем подписку
        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'subscription_package_id' => $subscriptionPackage->id,
            'start_date' => Carbon::now(),
            'end_date' => $this->calculateEndDate($subscriptionPackage),
            'status' => 'active',
            'payment_method' => $paymentMethod,
            'amount_paid' => $subscriptionPackage->price,
        ]);

        $redirectRoute = $book ? 'subscriptions.book.success' : 'subscriptions.success';

        return redirect()->route($redirectRoute, $book ? ['book' => $book] : [])
            ->with('success', 'Подписка успешно оформлена!')
            ->with('subscription', $subscription);
    }

    /**
     * Расчет даты окончания подписки
     */
    private function calculateEndDate(SubscriptionPackage $package): Carbon
    {
        if (method_exists($package, 'getMonthCount')) {
            $months = $package->getMonthCount();
        } else {
            $title = $package->subscription_period->title;
            $months = 1;

            if (preg_match('/(\d+)\s*месяц/', $title, $matches)) {
                $months = (int)$matches[1];
            } elseif (preg_match('/(\d+)\s*мес/', $title, $matches)) {
                $months = (int)$matches[1];
            } elseif (preg_match('/(\d+)\s*год/', $title, $matches)) {
                $months = (int)$matches[1] * 12;
            }
        }

        return Carbon::now()->addMonths($months);
    }


    /**
     * Страница успешного оформления для книги
     */
    public function bookSuccess(Book $book): View
    {
        $subscription = session('subscription');
        return view('subscriptions.success', compact('book', 'subscription'));
    }

    /**
     * Страница успешного оформления общей подписки
     */
    public function success(): View
    {
        $subscription = session('subscription');
        return view('subscriptions.success', compact('subscription'));
    }

    /**
     * История подписок пользователя
     */
    public function history(): View
    {
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->with('subscription_package.subscription_period')
            ->latest()
            ->paginate(10); // Добавляем пагинацию

        return view('subscriptions.history', compact('subscriptions'));
    }
}
