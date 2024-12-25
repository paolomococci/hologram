<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Contributor;
use Illuminate\Database\Seeder;

class ContributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contributor::factory()->count(Article::all()->count())->create();
    }
}
