<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['id' => 1, 'name' => 'Salary'],
            ['id' => 2, 'name' => 'Other Income'],
            ['id' => 3, 'name' => 'Family Expense'],
            ['id' => 4, 'name' => 'Transport Expense'],
            ['id' => 5, 'name' => 'Meal Expense'],
        ]);
    }
}