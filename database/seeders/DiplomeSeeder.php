<?php

namespace Database\Seeders;

use App\Models\Diplome;
use Illuminate\Database\Seeder;

class DiplomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diplomes = [
            [
                'libelle' => 'Baccaulérat',
                'abreviation' => 'BAC',
                'serie' => 'C',
                'specialite' => 'Sciences',
                'option' => null
            ],
            [
                'libelle' => 'Baccaulérat',
                'abreviation' => 'BAC',
                'serie' => 'D',
                'specialite' => 'Sciences de la Vie et de la Terre',
                'option' => null
            ],
            [
                'libelle' => 'Baccaulérat',
                'abreviation' => 'BAC',
                'serie' => 'A',
                'specialite' => 'Littéraire',
                'option' => null
            ],
            [
                'libelle' => 'Licence',
                'abreviation' => 'LIC',
                'serie' => null,
                'specialite' => 'Informatique',
                'option' => 'Génie Logiciel'
            ],
            [
                'libelle' => 'Licence',
                'abreviation' => 'LIC',
                'serie' => null,
                'specialite' => 'Mathématiques',
                'option' => 'Mathématiques Appliquées'
            ],
            [
                'libelle' => 'Licence Professionnelle',
                'abreviation' => 'LIC-PRO',
                'serie' => null,
                'specialite' => 'Informatique',
                'option' => 'Développement Web'
            ],
            [
                'libelle' => 'Master',
                'abreviation' => 'MST',
                'serie' => null,
                'specialite' => 'Informatique',
                'option' => 'Intelligence Artificielle'
            ],
            [
                'libelle' => 'Master',
                'abreviation' => 'MST',
                'serie' => null,
                'specialite' => 'Droit',
                'option' => 'Droit des Affaires'
            ],
            [
                'libelle' => 'Doctorant',
                'abreviation' => 'PHD',
                'serie' => null,
                'specialite' => 'Informatique',
                'option' => 'Sécurité Informatique'
            ]
        ];

        $totalInserts = 0;

        foreach ($diplomes as $diplome) {
            try {
                // Vérifier si le diplôme existe déjà avec les mêmes caractéristiques
                $existingDiplome = Diplome::where('libelle', $diplome['libelle'])
                                         ->where('serie', $diplome['serie'])
                                         ->where('specialite', $diplome['specialite'])
                                         ->where('option', $diplome['option'])
                                         ->first();

                if (!$existingDiplome) {
                    Diplome::create([
                        'libelle' => $diplome['libelle'],
                        'abreviation' => $diplome['abreviation'],
                        'serie' => $diplome['serie'],
                        'specialite' => $diplome['specialite'],
                        'option' => $diplome['option'],
                        'created_by' => 'system'
                    ]);
                    $totalInserts++;
                }
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de l'insertion du diplôme: " . $e->getMessage());
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("Diplômes insérés : " . $totalInserts);
    }
}
