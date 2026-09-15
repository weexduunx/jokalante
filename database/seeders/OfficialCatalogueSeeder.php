<?php

namespace Database\Seeders;

use App\Models\Competence;
use App\Models\Contenu;
use App\Models\Opportunite;
use App\Models\RoadmapStep;
use Illuminate\Database\Seeder;

class OfficialCatalogueSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->catalogue() as $item) {
            $competence = Competence::query()->updateOrCreate(
                ['slug' => $item['slug']],
                collect($item)->except(['contenu', 'opportunites'])->all(),
            );

            Contenu::query()->updateOrCreate(
                ['competence_id' => $competence->id],
                $item['contenu'],
            );

            foreach ($item['opportunites'] as $opportunite) {
                Opportunite::query()->updateOrCreate(
                    [
                        'competence_id' => $competence->id,
                        'titre_fr' => $opportunite['titre_fr'],
                    ],
                    $opportunite,
                );
            }

            foreach ($this->roadmapSteps($competence) as $step) {
                RoadmapStep::query()->updateOrCreate(
                    [
                        'competence_id' => $competence->id,
                        'position' => $step['position'],
                    ],
                    $step,
                );
            }
        }
    }

    /**
     * @return list<array{competence_id:int,titre_fr:string,titre_wo:string,description_fr:string,description_wo:string,position:int,duree_minutes:int}>
     */
    private function roadmapSteps(Competence $competence): array
    {
        return [
            [
                'competence_id' => $competence->id,
                'titre_fr' => 'Comprendre le service officiel',
                'titre_wo' => 'Xam serwis bi ci yoon wi',
                'description_fr' => 'Identifier le service ANPEJ ou Emploi Jeunes qui correspond à ton objectif.',
                'description_wo' => 'Xam serwis ANPEJ walla Emploi Jeunes bu mébét mi la méngoo.',
                'position' => 1,
                'duree_minutes' => 10,
            ],
            [
                'competence_id' => $competence->id,
                'titre_fr' => 'Préparer son dossier',
                'titre_wo' => 'Waajal sa dossier',
                'description_fr' => 'Réunir les informations demandées sur la page officielle avant le contact.',
                'description_wo' => 'Daajal xibaar yi ñu laaj ci xët wi bala ngay jokkoo.',
                'position' => 2,
                'duree_minutes' => 20,
            ],
            [
                'competence_id' => $competence->id,
                'titre_fr' => 'Contacter l’organisme',
                'titre_wo' => 'Jokkoo ak kurum bi',
                'description_fr' => 'Vérifier les conditions, la disponibilité et la prochaine étape directement auprès de l’organisme.',
                'description_wo' => 'Seetal anam yi ak li topp ak kurum bi ci boppam.',
                'position' => 3,
                'duree_minutes' => 10,
            ],
        ];
    }

    /**
     * Les données sont issues des pages officielles consultées le 15 septembre 2026.
     * Les portails restent à vérifier avant toute candidature ou inscription.
     *
     * @return list<array<string, mixed>>
     */
    private function catalogue(): array
    {
        $anpejContact = 'contact@anpej.sn · +221 33 869 19 82';
        $anpejAddress = 'ANPEJ, Lot 1 Lotissement SODIDA, Avenue Bourguiba, Dakar-Liberté';
        $verifiedOn = '2026-09-15';

        return [
            $this->competence(
                'orientation-emploi',
                'Orientation et accompagnement vers l’emploi',
                'Tànn yoon ak dimbali ci liggéey',
                'L’ANPEJ propose l’accueil, l’orientation, l’inscription dans sa base, le suivi et le rapprochement entre offres et profils.',
                'ANPEJ dafay dalal, orienter, bind ci base bi, topp nit ñi ak jokkoo offre ak profil.',
                'emploi',
                'https://anpej.sn/accueil/services-aux-demandeurs/',
                $anpejContact,
                $anpejAddress,
                $verifiedOn,
            ),
            $this->competence(
                'formation-apprentissage',
                'Formation et apprentissage',
                'Jàng ak tàmbali métier',
                'L’ANPEJ propose une initiation à un métier, une technique ou une technologie en présentiel ou via la plateforme e-Taggat.',
                'ANPEJ dafay jàngal métier, technique walla technologie ci bérab walla ci e-Taggat.',
                'formation',
                'https://anpej.sn/accueil/formation/',
                $anpejContact,
                $anpejAddress,
                $verifiedOn,
            ),
            $this->competence(
                'recherche-emploi',
                'Offres d’emploi et de stages',
                'Seet liggéey ak stage',
                'Le portail Emploi Jeunes permet de consulter les offres publiées et de s’inscrire comme demandeur d’emploi.',
                'Portail Emploi Jeunes dafay may seet offres yi ñu publier ak bind ni ku seet liggéey.',
                'emploi',
                'https://emploijeunes.sn/offres-et-publications',
                'Portail Emploi Jeunes · contact via la plateforme officielle',
                'En ligne · Sénégal',
                $verifiedOn,
            ),
            $this->competence(
                'entrepreneuriat',
                'Création d’entreprise et auto-emploi',
                'Tambali sa liggéey',
                'Emploi Jeunes propose un accompagnement personnalisé, l’orientation, la formation en entrepreneuriat et l’aide au business plan.',
                'Emploi Jeunes dafay dimbali ci auto-emploi, orientation, jàng entrepreneuriat ak business plan.',
                'activite',
                'https://emploijeunes.sn/entreprendre',
                'Guichet unique Emploi Jeunes · inscription sur la plateforme officielle',
                'En ligne · Sénégal',
                $verifiedOn,
            ),
            $this->competence(
                'gestion-microentreprise',
                'Gestion des micro-entreprises',
                'Saytu micro-entreprise',
                'L’ANPEJ indique proposer des formations en entrepreneuriat, éducation financière et gestion des micro-entreprises.',
                'ANPEJ dafay jàngal entrepreneuriat, xam-xam xaalis ak saytu micro-entreprise.',
                'activite',
                'https://anpej.sn/accueil/services-aux-demandeurs/',
                $anpejContact,
                $anpejAddress,
                $verifiedOn,
            ),
            $this->competence(
                'accompagnement-formation',
                'Recherche de formation et accompagnement',
                'Seet formation ak dimbali',
                'Emploi Jeunes propose une détection du profil, l’identification des besoins et un accompagnement personnalisé vers une formation.',
                'Emploi Jeunes dafay seet profil bi, xam soxla yi ak dimbali ci tànn formation.',
                'formation',
                'https://emploijeunes.sn/vous-cherchez-une-formation',
                'Guichet unique Emploi Jeunes · inscription sur la plateforme officielle',
                'En ligne · Sénégal',
                $verifiedOn,
            ),
        ];
    }

    /** @return array<string, mixed> */
    private function competence(
        string $slug,
        string $nomFr,
        string $nomWo,
        string $descriptionFr,
        string $descriptionWo,
        string $objectif,
        string $sourceUrl,
        string $contact,
        string $lieu,
        string $verifiedOn,
    ): array {
        return [
            'slug' => $slug,
            'nom_fr' => $nomFr,
            'nom_wo' => $nomWo,
            'description_fr' => $descriptionFr,
            'description_wo' => $descriptionWo,
            'niveau' => 'debutant',
            'zone_geo' => 'senegal',
            'demande_locale' => 0,
            'justification_source' => $sourceUrl,
            'source_updated_on' => $verifiedOn,
            'contenu' => [
                'type' => 'texte',
                'source' => $sourceUrl,
                'corps_fr' => $descriptionFr."\n\nObjectif du parcours : ".$objectif.'. Consulte la page officielle avant toute démarche.',
                'corps_wo' => $descriptionWo."\n\nMebét : ".$objectif.'. Seetal xët officiel bi bala ngay jëf.',
                'script_audio_fr' => 'Cette information vient d’une page officielle. Consulte la source et vérifie les conditions avant de contacter l’organisme.',
                'script_audio_wo' => 'Xibaar bii dale ci xët officiel. Seetal anam yi bala ngay jokkoo ak kurum bi.',
            ],
            'opportunites' => [[
                'titre_fr' => $nomFr.' · source officielle',
                'titre_wo' => $nomWo.' · source officiel',
                'lieu' => $lieu,
                'contact' => $contact,
                'condition_eligibilite_fr' => 'Consulter les conditions publiées sur la page officielle.',
                'condition_eligibilite_wo' => 'Seetal anam yi ci xët officiel bi.',
                'delai_fr' => 'Disponibilité et calendrier à confirmer sur la page officielle.',
                'delai_wo' => 'Seetal waxtu ak disponibilité ci xët officiel bi.',
                'source' => $sourceUrl,
                'source_url' => $sourceUrl,
                'source_updated_on' => $verifiedOn,
                'statut' => 'a_verifier',
                'zone_geo' => 'senegal',
                'ajoutee_par_formateur' => false,
            ]],
        ];
    }
}
