<?php

namespace Database\Seeders;

use App\Services\KnowledgeBase\JsonImporterService;
use Illuminate\Database\Seeder;

class JurumiyahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define path to jurumiyah.json in the workspace root
        $jsonPath = base_path('jurumiyah.json');

        $this->command->info("Memulai proses impor Knowledge Base dari: {$jsonPath}");

        try {
            $importService = new JsonImporterService();
            $importService->import($jsonPath);
            
            $this->command->info("Sukses: Knowledge Base Jurumiyah berhasil diimpor.");
        } catch (\Exception $e) {
            $this->command->error("Gagal melakukan impor: " . $e->getMessage());
        }
    }
}
