<?php

namespace Database\Seeders;

use App\Models\Diplome;
use App\Models\Niveau;
use App\Models\NiveauDiplome;
use Illuminate\Database\Seeder;

class NiveauDiplomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Associations entre niveaux et diplômes
        $niveauxDiplomes = [
            // L1 GL -> Baccalauréat série C
            [
                'niveau_id' => 33,
                'diplome_id' => 1
            ],
            // L1 RT -> Baccalauréat série C
            [
                'niveau_id' => 41,
                'diplome_id' => 1
            ],
            // L1 IA -> Baccalauréat série C
            [
                'niveau_id' => 49,
                'diplome_id' => 1
            ],
            // L1 GL -> Baccalauréat série D
            [
                'niveau_id' => 33,
                'diplome_id' => 2
            ],
            // L1 RT -> Baccalauréat série D
            [
                'niveau_id' => 41,
                'diplome_id' => 2
            ],
            // L1 IA -> Baccalauréat série D
            [
                'niveau_id' => 49,
                'diplome_id' => 2
            ],
            // L1 MF -> Baccalauréat série C
            [
                'niveau_id' =>1 ,
                'diplome_id' => 1
            ],
            // L1 MA -> Baccalauréat série C
            [
                'niveau_id' => 9,
                'diplome_id' => 1
            ],
            // L1 MA -> Baccalauréat série D
            [
                'niveau_id' => 9,
                'diplome_id' => 2
            ],
            // L1 PF -> Baccalauréat série C
            [
                'niveau_id' => 17,
                'diplome_id' => 1
            ],
            // L1 PA -> Baccalauréat série C
            [
                'niveau_id' => 25,
                'diplome_id' => 1
            ],
            // L1 PA -> Baccalauréat série D
            [
                'niveau_id' => 25,
                'diplome_id' => 2
            ],
            // M1 IA -> Licence en GL
            [
                'niveau_id' => 52,
                'diplome_id' => 4
            ],
            // M1 IA -> Licence en IA
            [
                'niveau_id' => 52,
                'diplome_id' => 6
            ],
            // M1 MA -> Licence en MA
            [
                'niveau_id' => 12,
                'diplome_id' => 5
            ],
        ];

        $totalInserts = 0;

        // Parcourir et insérer chaque association niveau-diplôme
        foreach ($niveauxDiplomes as $niveauDiplome) {
            try {
                // Vérifier si l'association existe déjà
                $existingNiveauDiplome = NiveauDiplome::where('niveau_id', $niveauDiplome['niveau_id'])
                                                   ->where('diplome_id', $niveauDiplome['diplome_id'])
                                                   ->first();

                if (!$existingNiveauDiplome) {
                    // Vérifier si le niveau et le diplôme existent
                    $niveauExists = Niveau::find($niveauDiplome['niveau_id']);
                    $diplomeExists = Diplome::find($niveauDiplome['diplome_id']);

                    if ($niveauExists && $diplomeExists) {
                        NiveauDiplome::create([
                            'niveau_id' => $niveauDiplome['niveau_id'],
                            'diplome_id' => $niveauDiplome['diplome_id'],
                            'created_by' => 'system'
                        ]);

                        $niveauExists->update([
                           'accessible' => 1,
                            'updated_by' => 'system'
                        ]);
                        $totalInserts++;
                    } else {
                        $this->command->warn("Niveau ID " . $niveauDiplome['niveau_id'] . " ou Diplôme ID " . $niveauDiplome['diplome_id'] . " n'existe pas.");
                    }
                }
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de l'insertion de l'association niveau-diplôme: " . $e->getMessage());
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("Associations niveau-diplôme insérées : " . $totalInserts);
    }
}
