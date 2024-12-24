<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Contributor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
