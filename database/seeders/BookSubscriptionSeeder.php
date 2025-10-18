<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\DB;

class BookSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $packages = SubscriptionPackage::all();

        if ($books->isEmpty()) {
            $this->command->info('Нет книг для создания связей');
            return;
        }

        if ($packages->isEmpty()) {
            $this->command->info('Нет пакетов подписок для создания связей');
            return;
        }

        $connections = [];

        foreach ($books as $book) {
            // Привязываем каждый пакет к каждой книге
            foreach ($packages as $package) {
                $connections[] = [
                    'book_id' => $book->id,
                    'subscription_package_id' => $package->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Вставляем все связи одним запросом
        DB::table('book_subscription_package')->insert($connections);

        $this->command->info("Создано связей: " . count($connections));
        $this->command->info("Книг: {$books->count()}, Пакетов: {$packages->count()}");
    }
}
