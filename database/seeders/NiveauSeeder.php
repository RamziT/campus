<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer toutes les filières
        $filieres = Filiere::all();

        // Niveaux disponibles dans le système
        $niveauxTypes = [
            ['libelle' => 'Licence 1', 'abreviation' => 'L1'],
            ['libelle' => 'Licence 2', 'abreviation' => 'L2'],
            ['libelle' => 'Licence 3', 'abreviation' => 'L3'],
            ['libelle' => 'Master 1', 'abreviation' => 'M1'],
            ['libelle' => 'Master 2', 'abreviation' => 'M2'],
            ['libelle' => 'Doctorat 1', 'abreviation' => 'D1'],
            ['libelle' => 'Doctorat 2', 'abreviation' => 'D2'],
            ['libelle' => 'Doctorat 3', 'abreviation' => 'D3'],

        ];

        $totalInserts = 0;

        // Pour chaque filière, créer tous les niveaux
        foreach ($filieres as $filiere) {
            foreach ($niveauxTypes as $niveau) {
                try {
                    // Vérifier si le niveau existe déjà pour cette filière
                    $existingNiveau = Niveau::where('libelle', $niveau['libelle'])
                                           ->where('filiere_id', $filiere->id)
                                           ->first();

                    if (!$existingNiveau) {
                        // Déterminer si ce niveau est accessible (par défaut, seul L1 est accessible)
                        $accessible = ($niveau['libelle'] === 'Licence 1') ? 1 : 0;

                        Niveau::create([
                            'libelle' => $niveau['libelle'],
                            'abreviation' => $niveau['abreviation'],
                            'filiere_id' => $filiere->id,
                            'accessible' => $accessible,
                            'created_by' => 'system'
                        ]);
                        $totalInserts++;
                    }
                } catch (\Exception $e) {
                    $this->command->error("Erreur lors de l'insertion du niveau: " . $e->getMessage());
                }
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("Niveaux insérés : " . $totalInserts);
    }
}
