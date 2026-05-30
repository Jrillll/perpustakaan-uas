<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBorrowingWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_returning_an_overdue_borrowing_creates_a_fine_and_restores_stock(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Teknologi',
            'description' => 'Buku teknologi',
        ]);

        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Laravel Dasar',
            'author' => 'Ahmad',
            'publisher' => 'Pustaka',
            'publication_year' => 2024,
            'isbn' => '9781234567890',
            'description' => 'Panduan Laravel',
            'stock' => 0,
        ]);

        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(3)->toDateString(),
            'status' => 'approved',
        ]);

        $response = $this->withSession([
            'user_id' => $admin->id,
            'role' => 'admin',
        ])->post("/admin/borrowings/{$borrowing->id}/return");

        $response->assertRedirect('/admin/borrowings');
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'returned',
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => 1,
        ]);

        $this->assertDatabaseHas('fines', [
            'borrowing_id' => $borrowing->id,
            'status' => 'unpaid',
        ]);
    }
}
