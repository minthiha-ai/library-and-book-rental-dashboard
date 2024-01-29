<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BookImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $category = Category::firstOrCreate(['name' => $row['categories']]);

            $genres = explode(',', $row['genres'] ?? '');
            $book = Book::create([
                'title' => $row['title_name'] ?? '',
                'author' => $row['author'] ?? '',
                'category_id' => $category->id,
                'code' => $row['call_number'] ?? '',
                'no_of_book' => $row['quantity'] ?? 0,
                'remain' => $row['quantity'] ?? 0,
                'description' => $row['description'] ?? '',
            ]);

            foreach ($genres as $genre) {
                $genreModel = Genre::firstOrCreate(['name' => $genre]);
                $book->genres()->attach($genreModel->id);
            }
        }
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1; // Skip the first row (heading row)
    }

    public function batchSize(): int
    {
        return 5000;
    }

    public function chunkSize(): int
    {
        return 5000;
    }


}
