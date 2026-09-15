<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GrokAIService implements AIServiceInterface
{
    /**
     * @param  array<string, string>  $profile
     * @param  list<array{slug:string,name:string,description:string,level:string,zone:string}>  $competences
     * @return list<array{slug:string,name:string,description:string,reason:string}>
     */
    public function proposeCatalogue(array $profile, array $competences): array
    {
        $apiKey = config('services.groq.api_key');

        if (! is_string($apiKey) || $apiKey === '') {
            return [];
        }

        try {
            $response = Http::acceptJson()
                ->withToken($apiKey)
                ->connectTimeout(3)
                ->timeout((int) config('services.groq.timeout', 15))
                ->post((string) config('services.groq.endpoint'), [
                    'model' => (string) config('services.groq.model'),
                    'temperature' => 0.2,
                    'max_tokens' => 300,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Tu es Jokalante AI. Propose un mini-catalogue de quatre à six compétences ou domaines concrets adaptés à l’objectif et à la région. Tu peux sélectionner des compétences du catalogue local ou proposer une nouvelle piste à explorer. Retourne uniquement un JSON au format {"catalogue":[{"slug":"...","name":"...","description":"...","reason":"..."}]}. Utilise des slugs courts en minuscules avec tirets. Ne promets pas d’emploi et ne crée aucune formation, bourse ou opportunité.',
                        ],
                        [
                            'role' => 'user',
                            'content' => json_encode([
                                'profil_partiel' => $profile,
                                'catalogue_local' => $competences,
                            ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                return [];
            }

            $content = $response->json('choices.0.message.content');
            $payload = is_string($content) ? json_decode($content, true) : null;
            $catalogue = is_array($payload) ? ($payload['catalogue'] ?? []) : [];

            if (! is_array($catalogue)) {
                return [];
            }

            return collect($catalogue)
                ->filter(fn (mixed $item): bool => is_array($item) && is_string($item['slug'] ?? null) && is_string($item['name'] ?? null))
                ->map(fn (array $item): array => [
                    'slug' => str($item['slug'])->slug()->toString(),
                    'name' => trim($item['name']),
                    'description' => is_string($item['description'] ?? null) ? trim($item['description']) : 'Compétence à explorer selon ton profil.',
                    'reason' => is_string($item['reason'] ?? null) ? trim($item['reason']) : 'Proposée selon ton objectif et ta région.',
                ])
                ->filter(fn (array $item): bool => $item['slug'] !== '' && $item['name'] !== '')
                ->take(6)
                ->all();
        } catch (Throwable $exception) {
            Log::warning('Groq interest suggestion unavailable.', [
                'exception' => $exception::class,
            ]);

            return [];
        }
    }

    /**
     * @param  array<string, string>  $profile
     * @param  list<array{slug:string,name:string,description:string,level:string,zone:string}>  $competences
     * @param  list<array{id:int,competence_slug:string,title:string,location:string,eligibility:string,deadline:string,source:string,verified_at:string,status:string}>  $opportunities
     */
    public function analyzeProfile(array $profile, array $competences, array $opportunities): array
    {
        $apiKey = config('services.groq.api_key');

        if (! is_string($apiKey) || $apiKey === '') {
            return [];
        }

        $allowedSlugs = array_column($competences, 'slug');
        $allowedOpportunityIds = array_map('intval', array_column($opportunities, 'id'));

        try {
            $response = Http::acceptJson()
                ->withToken($apiKey)
                ->connectTimeout(3)
                ->timeout((int) config('services.groq.timeout', 15))
                ->post((string) config('services.groq.endpoint'), [
                    'model' => (string) config('services.groq.model'),
                    'temperature' => 0.1,
                    'max_tokens' => 500,
                    ...$this->webSearchOptions(),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Tu es Jokalante AI. Analyse le profil avec le catalogue local et les opportunités vérifiées fournis. Utilise l outil web_search pour identifier des employeurs ou structures réellement liés à la compétence, à l objectif et à la région. Privilégie les sites officiels et pages récentes. Ne transforme jamais une découverte web en vérité : retourne chaque structure comme local_structure à vérifier. N invente jamais un employeur, une formation, une bourse, une date, un contact ou un recrutement. Retourne uniquement un objet JSON avec les clés competence_slug, opportunity_ids, profile_summary, strengths, skills_to_develop, compatible_roles, reason, next_action, local_structures et web_sources. Chaque local_structure doit contenir name, sector, region, url et evidence. Chaque web_source doit contenir title, url, publisher, published_at et reason. Si aucune structure fiable n est trouvée, retourne une liste local_structures vide.',
                        ],
                        [
                            'role' => 'user',
                            'content' => json_encode([
                                'profil' => $profile,
                                'competences_verifiees' => $competences,
                                'opportunites_verifiees' => $opportunities,
                            ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                Log::warning('Groq profile analysis request failed.', [
                    'status' => $response->status(),
                ]);

                return [];
            }

            $content = $response->json('choices.0.message.content');
            $analysis = is_string($content) ? json_decode($content, true) : null;

            if (! is_array($analysis)) {
                return [];
            }

            $competenceSlug = $analysis['competence_slug'] ?? $analysis['slug'] ?? null;
            $opportunityIds = is_array($analysis['opportunity_ids'] ?? null)
                ? array_values(array_intersect($allowedOpportunityIds, array_map('intval', $analysis['opportunity_ids'])))
                : [];

            return [
                'competence_slug' => is_string($competenceSlug) && in_array($competenceSlug, $allowedSlugs, true) ? $competenceSlug : null,
                'opportunity_ids' => $opportunityIds,
                'profile_summary' => $this->stringValue($analysis['profile_summary'] ?? null),
                'strengths' => $this->stringList($analysis['strengths'] ?? null),
                'skills_to_develop' => $this->stringList($analysis['skills_to_develop'] ?? null),
                'compatible_roles' => $this->stringList($analysis['compatible_roles'] ?? null),
                'reason' => $this->stringValue($analysis['reason'] ?? null),
                'next_action' => $this->stringValue($analysis['next_action'] ?? null),
                'local_structures' => $this->localStructures($analysis['local_structures'] ?? $analysis['employers'] ?? null),
                'web_sources' => $this->webSources($analysis['web_sources'] ?? $analysis['sources'] ?? null),
            ];
        } catch (Throwable $exception) {
            Log::warning('Groq profile analysis request unavailable.', [
                'exception' => $exception::class,
            ]);

            return [];
        }
    }

    /**
     * @return list<string>
     */
    private function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, 'is_string'));
    }

    private function stringValue(mixed $value): ?string
    {
        return is_string($value) && trim($value) !== '' ? trim($value) : null;
    }

    /**
     * @return list<array{name:string,sector:string,region:string,url:string,evidence:string}>
     */
    private function localStructures(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $structures = [];

        foreach ($value as $structure) {
            if (! is_array($structure) || ! is_string($structure['url'] ?? null) || parse_url($structure['url'], PHP_URL_SCHEME) !== 'https') {
                continue;
            }

            $structures[] = [
                'name' => $this->stringValue($structure['name'] ?? null) ?? 'Structure à vérifier',
                'sector' => $this->stringValue($structure['sector'] ?? null) ?? 'Secteur non précisé',
                'region' => $this->stringValue($structure['region'] ?? null) ?? 'Sénégal',
                'url' => $structure['url'],
                'evidence' => $this->stringValue($structure['evidence'] ?? null) ?? 'Source web proposée par Groq.',
            ];
        }

        return array_slice($structures, 0, 5);
    }

    /**
     * @return array{compound_custom?:array{tools:array{enabled_tools:list<string>}}}
     */
    private function webSearchOptions(): array
    {
        if (! filter_var(config('services.groq.web_search', true), FILTER_VALIDATE_BOOL)) {
            return [];
        }

        return [
            'compound_custom' => [
                'tools' => [
                    'enabled_tools' => ['web_search'],
                ],
            ],
        ];
    }

    /**
     * External results remain unverified until a Jokalante source check is implemented.
     *
     * @return list<array{title:string,url:string,publisher:string,published_at:?string,reason:string}>
     */
    private function webSources(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $sources = [];

        foreach ($value as $source) {
            if (! is_array($source) || ! is_string($source['url'] ?? null) || ! filter_var($source['url'], FILTER_VALIDATE_URL)) {
                continue;
            }

            $scheme = parse_url($source['url'], PHP_URL_SCHEME);

            if ($scheme !== 'https') {
                continue;
            }

            $sources[] = [
                'title' => $this->stringValue($source['title'] ?? null) ?? 'Source web proposée',
                'url' => $source['url'],
                'publisher' => $this->stringValue($source['publisher'] ?? null) ?? (parse_url($source['url'], PHP_URL_HOST) ?: 'Source externe'),
                'published_at' => $this->stringValue($source['published_at'] ?? null),
                'reason' => $this->stringValue($source['reason'] ?? null) ?? 'Pertinente pour ce profil.',
            ];
        }

        return array_slice($sources, 0, 5);
    }

    /**
     * @deprecated Use analyzeProfile() so that opportunities and evidence are considered.
     *
     * @param  array<string, string>  $profile
     * @param  list<array{slug:string,name:string,description:string,level:string,zone:string}>  $competences
     */
    public function recommendSkill(array $profile, array $competences): ?string
    {
        $analysis = $this->analyzeProfile($profile, $competences, []);

        return $analysis['competence_slug'] ?? null;
    }
}
