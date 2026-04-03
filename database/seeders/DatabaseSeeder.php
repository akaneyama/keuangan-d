<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $catIncome = \App\Models\Category::create(['user_id' => $user->id, 'name' => 'Salary', 'type' => 'income']);
        $catExpense = \App\Models\Category::create(['user_id' => $user->id, 'name' => 'Food', 'type' => 'expense']);

        for ($i=1; $i<=5; $i++) {
            \App\Models\Income::create([
                'user_id' => $user->id,
                'category_id' => $catIncome->id,
                'amount' => 5000000 + ($i * 100000),
                'date' => now()->subDays($i * 5)->format('Y-m-d'),
                'description' => "Salary month $i"
            ]);

            \App\Models\Expense::create([
                'user_id' => $user->id,
                'category_id' => $catExpense->id,
                'amount' => 50000 + ($i * 10000),
                'date' => now()->subDays($i * 2)->format('Y-m-d'),
                'description' => "Lunch $i"
            ]);
        }

        $target = \App\Models\SavingsTarget::create([
            'user_id' => $user->id,
            'name' => 'New Laptop',
            'target_amount' => 15000000,
            'current_amount' => 2000000,
            'deadline' => now()->addMonths(6)->format('Y-m-d'),
            'status' => 'ongoing'
        ]);

        \App\Models\SavingsTransaction::create([
            'savings_target_id' => $target->id,
            'amount' => 2000000,
            'date' => now()->format('Y-m-d'),
            'note' => 'Initial saving'
        ]);
    }
}
