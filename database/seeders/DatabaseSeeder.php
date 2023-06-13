<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();
        Movie::factory(5)->create();
        Quote::factory(10)->create();

        $genres = ['Action', 'Animation', 'Adventure', 'Biography', 'Comedy', 'Crime', 'Drama', 'Documentary', 'Fantasy', 'Historical', 'Horror', 'Melodrama', 'Musical', 'Reality', 'Science', 'Thriller', 'Western'];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
