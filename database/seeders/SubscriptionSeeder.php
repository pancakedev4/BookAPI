<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPeriod;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очищаем только пакеты, периоды оставляем
        SubscriptionPackage::query()->delete();

        // Создаем или получаем периоды: 1, 3, 6, 12 месяцев
        $period1month = SubscriptionPeriod::firstOrCreate(
            ['title' => '1 месяц'],
            ['discount_amount' => 0]
        );

        $period3months = SubscriptionPeriod::firstOrCreate(
            ['title' => '3 месяца'],
            ['discount_amount' => 0]
        );

        $period6months = SubscriptionPeriod::firstOrCreate(
            ['title' => '6 месяцев'],
            ['discount_amount' => 0]
        );

        $period12months = SubscriptionPeriod::firstOrCreate(
            ['title' => '12 месяцев'],
            ['discount_amount' => 0]
        );

        // Создаем пакеты подписок: 1 бесплатная + 3 платные с разными периодами
        $packages = [
            [
                'name' => 'Стартовая',
                'price' => 0,
                'subscription_period_id' => $period1month->id,
                'discount_in_partner_store' => 0,
            ],
            [
                'name' => 'Базовая',
                'price' => 15, // 15 BYN за 3 месяца (5 BYN/месяц)
                'subscription_period_id' => $period3months->id,
                'discount_in_partner_store' => 5,
            ],
            [
                'name' => 'Расширенная',
                'price' => 25, // 25 BYN за 6 месяцев (4.17 BYN/месяц)
                'subscription_period_id' => $period6months->id,
                'discount_in_partner_store' => 10,
            ],
            [
                'name' => 'Премиум',
                'price' => 40, // 40 BYN за 12 месяцев (3.33 BYN/месяц)
                'subscription_period_id' => $period12months->id,
                'discount_in_partner_store' => 15,
            ],
        ];

        foreach ($packages as $package) {
            SubscriptionPackage::create($package);
        }

        echo "Подписки успешно созданы с периодами: 1, 3, 6, 12 месяцев!\n";
        echo "Популярная подписка: Расширенная (6 месяцев)\n";
    }
}
