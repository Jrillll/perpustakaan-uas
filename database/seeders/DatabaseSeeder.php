<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Categories
        $categories = [
            'Sistem Informasi',
            'Ilmu Komputer',
            'Fiksi',
            'Umum'
        ];

        $categoryModels = [];
        foreach ($categories as $catName) {
            $categoryModels[$catName] = Category::create([
                'name' => $catName,
            ]);
        }

        // 2. Seed Users
        User::create([
            'name' => 'admin',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Rungkut Asri Tengah No.5-7, Surabaya',
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@perpus.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '081234567891',
            'address' => 'Jl. Rungkut Asri Timur No.12, Surabaya',
        ]);

        // 3. Seed Books
        $books = [
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Laut Bercerita',
                'author' => 'Leila S. Chudori',
                'publisher' => 'KPG',
                'publication_year' => 2017,
                'isbn' => '9786024246945',
                'description' => 'Novel tentang aktivis mahasiswa pada masa Orde Baru.',
                'cover' => '/images/laut.jfif',
                'stock' => 10,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'publication_year' => 1980,
                'isbn' => '9789799731234',
                'description' => 'Novel sejarah Indonesia tentang Minke.',
                'cover' => '/images/98759_f.jpg',
                'stock' => 8,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Filsafat',
                'title' => 'Madilog',
                'author' => 'Tan Malaka',
                'publisher' => 'Narasi',
                'publication_year' => 1943,
                'isbn' => '9789791683326',
                'description' => 'Buku filsafat dan logika karya Tan Malaka.',
                'cover' => '/images/51099226.jpg',
                'stock' => 7,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Seporsi Mie Ayam Sebelum Mati',
                'author' => 'Brian Khrisna',
                'publisher' => 'Media Kita',
                'publication_year' => 2023,
                'isbn' => '9786234932515',
                'description' => 'Novel reflektif tentang kehidupan dan kematian.',
                'cover' => 'https://picsum.photos/200/304',
                'stock' => 12,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Sosial',
                'title' => 'Ayat-Ayat Kiri',
                'author' => 'Muhidin M. Dahlan',
                'publisher' => 'Buku Kompas',
                'publication_year' => 2020,
                'isbn' => '9786024125189',
                'description' => 'Kumpulan tulisan sosial dan budaya.',
                'cover' => 'https://picsum.photos/200/305',
                'stock' => 6,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Filsafat',
                'title' => 'Dunia Sophie',
                'author' => 'Jostein Gaarder',
                'publisher' => 'Mizan',
                'publication_year' => 1991,
                'isbn' => '9789794331613',
                'description' => 'Novel filsafat populer dunia.',
                'cover' => 'https://picsum.photos/200/306',
                'stock' => 9,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Crime and Punishment',
                'author' => 'Fyodor Dostoevsky',
                'publisher' => 'Penguin',
                'publication_year' => 1866,
                'isbn' => '9780143058144',
                'description' => 'Novel klasik psikologi dan moralitas.',
                'cover' => 'https://picsum.photos/200/307',
                'stock' => 5,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'White Nights',
                'author' => 'Fyodor Dostoevsky',
                'publisher' => 'Penguin',
                'publication_year' => 1848,
                'isbn' => '9780241252088',
                'description' => 'Cerita romantis klasik Rusia.',
                'cover' => 'https://picsum.photos/200/308',
                'stock' => 5,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Don Quixote',
                'author' => 'Miguel de Cervantes',
                'publisher' => 'Francisco de Robles',
                'publication_year' => 1605,
                'isbn' => '9780060934347',
                'description' => 'Novel klasik petualangan ksatria.',
                'cover' => 'https://picsum.photos/200/309',
                'stock' => 4,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Gadis Kretek',
                'author' => 'Ratih Kumala',
                'publisher' => 'Gramedia',
                'publication_year' => 2012,
                'isbn' => '9789792289473',
                'description' => 'Novel keluarga dan industri kretek Indonesia.',
                'cover' => 'https://picsum.photos/200/310',
                'stock' => 8,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Pengembangan Diri',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Avery',
                'publication_year' => 2018,
                'isbn' => '9780735211292',
                'description' => 'Buku pengembangan diri tentang kebiasaan kecil.',
                'cover' => 'https://picsum.photos/200/311',
                'stock' => 15,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => 'Metamorfosis',
                'author' => 'Franz Kafka',
                'publisher' => 'Kurt Wolff Verlag',
                'publication_year' => 1915,
                'isbn' => '9786024246941',
                'description' => 'Novel absurd tentang perubahan hidup Gregor Samsa.',
                'cover' => 'https://picsum.photos/200/312',
                'stock' => 6,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Biografi',
                'title' => 'Karl Marx',
                'author' => 'Francis Wheen',
                'publisher' => 'Norton',
                'publication_year' => 1999,
                'isbn' => '9780393329438',
                'description' => 'Biografi Karl Marx dan pemikirannya.',
                'cover' => 'https://picsum.photos/200/313',
                'stock' => 5,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Fiksi',
                'title' => '1984',
                'author' => 'George Orwell',
                'publisher' => 'Secker & Warburg',
                'publication_year' => 1949,
                'isbn' => '9780451524935',
                'description' => 'Novel dystopia tentang pengawasan pemerintah.',
                'cover' => 'https://picsum.photos/200/314',
                'stock' => 10,
            ],
            [
                'category_id' => $categoryModels['Sistem Informasi']->id,
                'genre' => 'Filsafat',
                'title' => 'The Stranger',
                'author' => 'Albert Camus',
                'publisher' => 'Gallimard',
                'publication_year' => 1942,
                'isbn' => '9780679720201',
                'description' => 'Novel eksistensialisme klasik.',
                'cover' => 'https://picsum.photos/200/315',
                'stock' => 7,
            ]
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }
    }
}
