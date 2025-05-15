<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Universite;

class UniversiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universites = [
            [
                'libelle' => 'Université Pr Joseph KI-ZERBO',
                'abreviation' => 'UJKZ',
                'ville' => 'Ouagadougou'
            ],
            [
                'libelle' => 'Université Thomas SANKARA',
                'abreviation' => 'UTS',
                'ville' => 'Ouagadougou'
            ],
            [
                'libelle' => 'Université Virtuelle',
                'abreviation' => 'UV',
                'ville' => 'Ouagadougou'
            ],
            [
                'libelle' => 'Université Norbert ZONGO',
                'abreviation' => 'UNZ',
                'ville' => 'Koudougou'
            ],
            [
                'libelle' => 'Université Lédéa Bernard OUEDRAOGO',
                'abreviation' => 'ULBO',
                'ville' => 'Ouahigouya'
            ],
            [
                'libelle' => 'Universite Yembila Abdoulaye TOGUYENI',
                'abreviation' => 'UYAT',
                'ville' => 'Fada N\'Gourma'
            ],
            [
                'libelle' => 'Université Daniel Ouezzin COULIBALY',
                'abreviation' => 'UDOC',
                'ville' => 'Dédougou'
            ]
        ];

        $totalInserts = 0;

        // Parcourir et insérer chaque groupe d'examens
        foreach ($universites as $universite) {
            try {
                // Vérifier si l'université existe déjà
                $existingUniversite = Universite::where('libelle', $universite['libelle'])->first();
                if (!$existingUniversite) {
                    Universite::create([
                        'libelle' => $universite['libelle'],
                        'abreviation' => $universite['abreviation'],
                        'ville' => $universite['ville'],
                        'created_by' => 'system'
                    ]);
                    $totalInserts++;
                }
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de l'insertion de l'universtité: " . $e->getMessage());
            }
        }

        // Log du nombre total d'inserts
        $this->command->info("Universitées insérées : " . $totalInserts);
    }
}
