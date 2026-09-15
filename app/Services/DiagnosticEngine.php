<?php

namespace App\Services;

use App\Models\Competence;
use Illuminate\Support\Collection;

class DiagnosticEngine
{
    public function __construct(private readonly AIServiceInterface $aiService) {}

    /**
     * @param  array<string, string>  $answers
     * @param  list<array{slug:string,name:string,description:string,reason:string}>  $suggestedCatalogue
     */
    public function recommend(array $answers): Competence
    {
        return $this->analyze($answers)['competence'];
    }

    /**
     * @param  array<string, string>  $answers
     * @return array{competence:Competence,opportunity_id:?int,analysis:array{profile_summary:?string,strengths:list<string>,skills_to_develop:list<string>,compatible_roles:list<string>,reason:?string,next_action:?string,local_structures:list<array{name:string,sector:string,region:string,url:string,evidence:string}>,web_sources:list<array{title:string,url:string,publisher:string,published_at:?string,reason:string}>}}
     */
    public function analyze(array $answers, array $suggestedCatalogue = []): array
    {
        $competences = Competence::query()->get();
        $catalogue = $competences->map(fn (Competence $competence): array => [
            'slug' => $competence->slug,
            'name' => $competence->nom_fr,
            'description' => $competence->description_fr,
            'level' => $competence->niveau,
            'zone' => $competence->zone_geo,
        ])->all();

        $opportunities = $competences->load('opportunites')
            ->flatMap(fn (Competence $competence) => $competence->opportunites->map(fn ($opportunity): array => [
                'id' => $opportunity->id,
                'competence_slug' => $competence->slug,
                'title' => $opportunity->titre_fr,
                'location' => $opportunity->lieu,
                'eligibility' => $opportunity->condition_eligibilite_fr,
                'deadline' => $opportunity->delai_fr,
                'source' => $opportunity->source,
                'verified_at' => $opportunity->source_updated_on->format('Y-m-d'),
                'status' => $opportunity->statut,
            ]))->values()->all();

        $aiCatalogue = array_values(array_merge($catalogue, $suggestedCatalogue));
        $aiAnalysis = $this->aiService->analyzeProfile($answers, $aiCatalogue, $opportunities);
        $aiSlug = $aiAnalysis['competence_slug'] ?? null;
        $competence = $aiSlug
            ? $competences->firstWhere('slug', $aiSlug)
            : null;

        if (! $competence) {
            $competence = $this->fallbackRecommendation($competences, $answers);
            $aiAnalysis = $this->fallbackAnalysis($competence, $answers);
        }

        $allowedOpportunityIds = $competence->opportunites()->pluck('id')->all();
        $opportunityId = collect($aiAnalysis['opportunity_ids'] ?? [])
            ->map(fn (mixed $id): int => (int) $id)
            ->first(fn (int $id): bool => in_array($id, $allowedOpportunityIds, true));

        return [
            'competence' => $competence,
            'opportunity_id' => $opportunityId ?: $competence->opportunites()->value('id'),
            'analysis' => [
                'profile_summary' => $aiAnalysis['profile_summary'] ?? null,
                'strengths' => $aiAnalysis['strengths'] ?? [],
                'skills_to_develop' => $aiAnalysis['skills_to_develop'] ?? [],
                'compatible_roles' => $aiAnalysis['compatible_roles'] ?? [],
                'reason' => $aiAnalysis['reason'] ?? null,
                'next_action' => $aiAnalysis['next_action'] ?? null,
                'local_structures' => $aiAnalysis['local_structures'] ?? [],
                'web_sources' => $aiAnalysis['web_sources'] ?? [],
            ],
        ];
    }

    /**
     * Keep the demo useful when Groq is unavailable, while still using every major diagnostic answer.
     *
     * @param  Collection<int, Competence>  $competences
     * @param  array<string, string>  $answers
     */
    private function fallbackRecommendation(Collection $competences, array $answers): Competence
    {
        $scores = [
            'orientation-emploi' => 0,
            'formation-apprentissage' => 0,
            'recherche-emploi' => 0,
            'entrepreneuriat' => 0,
            'gestion-microentreprise' => 0,
            'accompagnement-formation' => 0,
        ];

        $scores[$this->goalBias($answers['objectif'] ?? '')] += 7;
        $scores[$this->interestMap($answers['interet'] ?? '')] += 4;
        $scores[$this->zoneBias($answers['zone'] ?? '')] += 2;
        $scores[$this->connectivityBias($answers['connectivite'] ?? '')] += 2;
        $scores[$this->timeBias($answers['temps'] ?? '')] += 1;

        arsort($scores);
        $slug = array_key_first($scores) ?? 'orientation-emploi';

        return $competences->firstWhere('slug', $slug) ?? $competences->firstOrFail();
    }

    /**
     * @param  array<string, string>  $answers
     * @return array{competence_slug:string,opportunity_ids:list<int>,profile_summary:string,strengths:list<string>,skills_to_develop:list<string>,compatible_roles:list<string>,reason:string,next_action:string}
     */
    private function fallbackAnalysis(Competence $competence, array $answers): array
    {
        $goal = match ($answers['objectif'] ?? '') {
            'activite' => 'créer une activité',
            'formation' => 'choisir une formation',
            default => 'trouver un emploi',
        };

        return [
            'competence_slug' => $competence->slug,
            'opportunity_ids' => [],
            'profile_summary' => sprintf('Profil orienté vers %s dans la zone %s.', $goal, $answers['zone'] ?? 'locale'),
            'strengths' => [$answers['interet'] ?? 'motivation déclarée', $answers['experience'] ?? 'niveau débutant'],
            'skills_to_develop' => [$competence->nom_fr],
            'compatible_roles' => [$competence->nom_fr],
            'reason' => 'Cette piste correspond à ton objectif, ton intérêt et aux compétences documentées dans le catalogue Jokalante.',
            'next_action' => 'Commencer le micro-contenu puis vérifier les conditions de l’opportunité proposée.',
            'local_structures' => [],
            'web_sources' => [],
        ];
    }

    private function goalBias(string $objectif): string
    {
        return match ($objectif) {
            'emploi' => 'recherche-emploi',
            'activite' => 'entrepreneuriat',
            'formation' => 'formation-apprentissage',
            default => 'orientation-emploi',
        };
    }

    private function interestMap(string $interet): string
    {
        return match ($interet) {
            'reparation', 'energie' => 'formation-apprentissage',
            'commerce' => 'entrepreneuriat',
            'bureau' => 'orientation-emploi',
            default => 'accompagnement-formation',
        };
    }

    private function zoneBias(string $zone): string
    {
        return match ($zone) {
            'dakar', 'thies' => 'recherche-emploi',
            'kaolack', 'ziguinchor' => 'entrepreneuriat',
            default => 'accompagnement-formation',
        };
    }

    private function connectivityBias(string $connectivite): string
    {
        return match ($connectivite) {
            'smartphone' => 'recherche-emploi',
            'partage' => 'orientation-emploi',
            '2g' => 'accompagnement-formation',
            default => 'orientation-emploi',
        };
    }

    private function timeBias(string $temps): string
    {
        return match ($temps) {
            'plein-temps' => 'formation-apprentissage',
            'soirs' => 'entrepreneuriat',
            default => 'orientation-emploi',
        };
    }
}
