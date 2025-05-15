<?php

namespace Database\Seeders;

use App\Models\Filiere;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filieres = [
            // Département de Mathématiques
            [
                'departement_id' => 1,
                'libelle' => 'Mathématiques Fondamentales',
                'abreviation' => 'MAT-FOND'
            ],
            [
                'departement_id' => 1,
                'libelle' => 'Mathématiques Appliquées',
                'abreviation' => 'MAT-APP'
            ],
            // Département de Physique
            [
                'departement_id' => 2,
                'libelle' => 'Physique Fondamentale',
                'abreviation' => 'PHY-FOND'
            ],
            [
                'departement_id' => 2,
                'libelle' => 'Physique Appliquée',
                'abreviation' => 'PHY-APP'
            ],
            // Département d'Informatique
            [
                'departement_id' => 3,
                'libelle' => 'Génie Logiciel',
                'abreviation' => 'GL'
            ],
            [
                'departement_id' => 3,
                'libelle' => 'Réseaux et Télécommunications',
                'abreviation' => 'RT'
            ],
            [
                'departement_id' => 3,
                'libelle' => 'Intelligence Artificielle',
                'abreviation' => 'IA'
            ],
            // Département d'Histoire
            [
                'departement_id' => 4,
                'libelle' => 'Histoire Contemporaine',
                'abreviation' => 'HIST-CONT'
            ],
            [
                'departement_id' => 4,
                'libelle' => 'Archéologie',
                'abreviation' => 'ARCHEO'
            ],
            // Département de Droit
            [
                'departement_id' => 10,
                'libelle' => 'Droit Privé',
                'abreviation' => 'DR-PRIV'
            ],
            [
                'departement_id' => 10,
                'libelle' => 'Droit Public',
                'abreviation' => 'DR-PUB'
            ]
        ];

        $totalInserts = 0;

        // Parcourir et insérer chaque filière
        foreach ($filieres as $filiere) {
            try {
                // Vérifier si la filière existe déjà
                $existingFiliere = Filiere::where('libelle', $filiere['libelle'])
                                         ->where('departement_id', $filiere['departement_id'])
                                         ->first();
                if (!$existingFiliere) {
                    Filiere::create([
                        'departement_id' => $filiere['departement_id'],
                        'libelle' => $filiere['libelle'],
                        'abreviation' => $filiere['abreviation'],
                        'created_by' => 'system'
                    ]);
                    $totalInserts++;
                }
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de l'insertion de la filière: " . $e->getMessage());
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("Filières insérées : " . $totalInserts);
    }
}
