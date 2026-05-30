<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
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
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '08123456789',
                'address' => 'Kantor Admin',
            ]
        );

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        $tech = Category::firstOrCreate([
            'name' => 'Teknologi',
        ], [
            'description' => 'Buku terkait teknologi',
        ]);

        $fiction = Category::firstOrCreate([
            'name' => 'Fiksi',
        ], [
            'description' => 'Buku fiksi dan novel',
        ]);

        Book::firstOrCreate([
            'isbn' => '9781234567890',
        ], [
            'category_id' => $tech->id,
            'title' => 'Laravel Dasar',
            'author' => 'Ahmad',
            'publisher' => 'Pustaka',
            'publication_year' => 2024,
            'description' => 'Panduan Laravel',
            'stock' => 3,
        ]);

        Book::firstOrCreate([
            'isbn' => '9781234567891',
        ], [
            'category_id' => $fiction->id,
            'title' => 'Negeri Para Bedebah',
            'author' => 'Tere Liye',
            'publisher' => 'Gramedia',
            'publication_year' => 2023,
            'description' => 'Novel fiksi',
            'stock' => 5,
        ]);
    }
}
