<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubscriptionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для доступа к контенту необходимо авторизоваться');
        }

        $user = Auth::user();

        // Проверяем активную подписку
        if (!$user->has_active_subscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Для доступа к библиотеке необходима подписка');
        }

        return $next($request);

        // Если пытаемся получить доступ к конкретной книге
        //     if ($book) {
        //         return redirect()->route('subscriptions.book.select', $book)
        //             ->with('error', 'Для доступа к книге "' . $book->title . '" необходима подписка');
        //     }

        //     // Если общий доступ к библиотеке
        //     return redirect()->route('subscriptions.index')
        //         ->with('error', 'Для доступа к библиотеке необходима подписка');
        // }

        // return $next($request);
    }
}
