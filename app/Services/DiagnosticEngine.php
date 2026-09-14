<?php

namespace App\Services;

use App\Models\Competence;

class DiagnosticEngine
{
    /**
     * @param  array{zone:string,connectivite:string,interet:string,temps:string}  $answers
     */
    public function recommend(array $answers): Competence
    {
        $scores = [
            'reparation-smartphone' => 0,
            'vente-whatsapp' => 0,
            'installation-solaire' => 0,
            'bureautique' => 0,
            'maintenance-pc' => 0,
            'electricite-batiment' => 0,
        ];

        $scores[$this->interestMap($answers['interet'] ?? '')] += 4;
        $scores[$this->zoneBias($answers['zone'] ?? '')] += 2;
        $scores[$this->connectivityBias($answers['connectivite'] ?? '')] += 2;
        $scores[$this->timeBias($answers['temps'] ?? '')] += 1;

        arsort($scores);
        $slug = array_key_first($scores);

        return Competence::query()->where('slug', $slug)->firstOrFail();
    }

    private function interestMap(string $interet): string
    {
        return match ($interet) {
            'reparation' => 'reparation-smartphone',
            'commerce' => 'vente-whatsapp',
            'energie' => 'installation-solaire',
            'bureau' => 'bureautique',
            default => 'vente-whatsapp',
        };
    }

    private function zoneBias(string $zone): string
    {
        return match ($zone) {
            'pikine', 'rufisque' => 'reparation-smartphone',
            'thies-rural' => 'installation-solaire',
            default => 'bureautique',
        };
    }

    private function connectivityBias(string $connectivite): string
    {
        return match ($connectivite) {
            'smartphone' => 'vente-whatsapp',
            'partage' => 'reparation-smartphone',
            '2g' => 'electricite-batiment',
            default => 'bureautique',
        };
    }

    private function timeBias(string $temps): string
    {
        return match ($temps) {
            'plein-temps' => 'maintenance-pc',
            'soirs' => 'vente-whatsapp',
            default => 'electricite-batiment',
        };
    }
}
