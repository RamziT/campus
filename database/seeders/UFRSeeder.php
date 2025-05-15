<?php

namespace Database\Seeders;

use App\Models\UFR;
use Illuminate\Database\Seeder;

class UFRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ufrs = [
            // UJKZ
            [
                'universite_id' => 1,
                'libelle' => 'UFR Sciences Exactes et Appliquées',
                'abreviation' => 'SEA'
            ],
            [
                'universite_id' => 1,
                'libelle' => 'UFR Sciences Humaines',
                'abreviation' => 'SH'
            ],
            [
                'universite_id' => 1,
                'libelle' => 'UFR Sciences de la Santé',
                'abreviation' => 'SS'
            ],
            // UTS
            [
                'universite_id' => 2,
                'libelle' => 'UFR Sciences Économiques et de Gestion',
                'abreviation' => 'SEG'
            ],
            [
                'universite_id' => 2,
                'libelle' => 'UFR Sciences Juridiques et Politiques',
                'abreviation' => 'SJP'
            ],
            // UNZ
            [
                'universite_id' => 4,
                'libelle' => 'UFR Lettres et Sciences Humaines',
                'abreviation' => 'LSH'
            ],
            [
                'universite_id' => 4,
                'libelle' => 'UFR Sciences et Technologies',
                'abreviation' => 'ST'
            ]
        ];

        $totalInserts = 0;

        // Parcourir et insérer chaque UFR
        foreach ($ufrs as $ufr) {
            try {
                // Vérifier si l'UFR existe déjà
                $existingUFR = UFR::where('libelle', $ufr['libelle'])
                                  ->where('universite_id', $ufr['universite_id'])
                                  ->first();
                if (!$existingUFR) {
                    UFR::create([
                        'universite_id' => $ufr['universite_id'],
                        'libelle' => $ufr['libelle'],
                        'abreviation' => $ufr['abreviation'],
                        'created_by' => 'system'
                    ]);
                    $totalInserts++;
                }
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de l'insertion de l'UFR: " . $e->getMessage());
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("UFRs insérées : " . $totalInserts);
    }
}
