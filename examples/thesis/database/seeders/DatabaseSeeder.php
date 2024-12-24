<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(25)->create();

        $this->call([
            AdminSeeder::class,
            ApplicantSeeder::class,
            DocumentationSeeder::class,
            ScannedDocumentSeeder::class,
            ArticleSeeder::class,
            AuthorSeeder::class,
            ContributorSeeder::class,
        ]);
    }
}
