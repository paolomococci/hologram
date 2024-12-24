<?php

namespace Database\Seeders;

use App\Models\ScannedDocument;
use Illuminate\Database\Seeder;

class ScannedDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScannedDocument::factory()->count(100)->create();
    }
}
