<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departements = [
            // UFR SEA (UJKZ)
            [
                'ufr_id' => 1,
                'libelle' => 'Département de Mathématiques',
                'abreviation' => 'MATH'
            ],
            [
                'ufr_id' => 1,
                'libelle' => 'Département de Physique',
                'abreviation' => 'PHY'
            ],
            [
                'ufr_id' => 1,
                'libelle' => 'Département d\'Informatique',
                'abreviation' => 'INFO'
            ],
            // UFR SH (UJKZ)
            [
                'ufr_id' => 2,
                'libelle' => 'Département d\'Histoire et Archéologie',
                'abreviation' => 'HIST'
            ],
            [
                'ufr_id' => 2,
                'libelle' => 'Département de Philosophie',
                'abreviation' => 'PHILO'
            ],
            // UFR SS (UJKZ)
            [
                'ufr_id' => 3,
                'libelle' => 'Département de Médecine',
                'abreviation' => 'MED'
            ],
            [
                'ufr_id' => 3,
                'libelle' => 'Département de Pharmacie',
                'abreviation' => 'PHARM'
            ],
            // UFR SEG (UTS)
            [
                'ufr_id' => 4,
                'libelle' => 'Département d\'Économie',
                'abreviation' => 'ECO'
            ],
            [
                'ufr_id' => 4,
                'libelle' => 'Département de Gestion',
                'abreviation' => 'GEST'
            ],
            // UFR SJP (UTS)
            [
                'ufr_id' => 5,
                'libelle' => 'Département de Droit',
                'abreviation' => 'DROIT'
            ],
            [
                'ufr_id' => 5,
                'libelle' => 'Département de Sciences Politiques',
                'abreviation' => 'SCPO'
            ]
        ];

        $totalInserts = 0;

        // Parcourir et insérer chaque département
        foreach ($departements as $departement) {
            try {
                // Vérifier si le département existe déjà
                $existingDepartement = Departement::where('libelle', $departement['libelle'])
                                                 ->where('ufr_id', $departement['ufr_id'])
                                                 ->first();
                if (!$existingDepartement) {
                    Departement::create([
                        'ufr_id' => $departement['ufr_id'],
                        'libelle' => $departement['libelle'],
                        'abreviation' => $departement['abreviation'],
                        'created_by' => 'system'
                    ]);
                    $totalInserts++;
                }
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de l'insertion du département: " . $e->getMessage());
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("Départements insérés : " . $totalInserts);
    }
}
