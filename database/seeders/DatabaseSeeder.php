<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $genres = [
            ['en' => 'Action', 'ka' => 'მძაფრსიუჟეტიანი'],
            ['en' => 'Animation', 'ka' => 'ანიმაცია'],
            ['en' => 'Adventure', 'ka' => 'სათავგადასავლო'],
            ['en' => 'Biography', 'ka' => 'ბიოგრაფიული'],
            ['en' => 'Comedy', 'ka' => 'კომედია'],
            ['en' => 'Crime', 'ka' => 'კრიმინალური'],
            ['en' => 'Drama', 'ka' => 'დრამა'],
            ['en' => 'Documentary', 'ka' => 'დოკუმენტური'],
            ['en' => 'Fantasy', 'ka' => 'ფენტეზი'],
            ['en' => 'Historical', 'ka' => 'ისტორიული'],
            ['en' => 'Horror', 'ka' => 'საშინელებათა'],
            ['en' => 'Melodrama', 'ka' => 'მელოდრამა'],
            ['en' => 'Musical', 'ka' => 'მიუზიკლი'],
            ['en' => 'Science', 'ka' => 'სამეცნიერო'],
            ['en' => 'Thriller', 'ka' => 'თრილერი'],
            ['en' => 'Western', 'ka' => 'ვესტერნი'],
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
