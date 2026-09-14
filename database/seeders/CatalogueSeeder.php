<?php

namespace Database\Seeders;

use App\Models\Competence;
use App\Models\Contenu;
use App\Models\Opportunite;
use Illuminate\Database\Seeder;

class CatalogueSeeder extends Seeder
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
        }
    }

    private function catalogue(): array
    {
        return [
            [
                'slug' => 'reparation-smartphone',
                'nom_fr' => 'Réparation de smartphones',
                'nom_wo' => 'Defar telefon',
                'description_fr' => 'Diagnostiquer un écran, une batterie et un port de charge — compétence recherchée dans les marchés de Pikine et Guédiawaye.',
                'description_wo' => 'Xam ni ngay seet problem ekran, batterie ak port charge — liggéey bu ñu soxla ci Pikine ak Guédiawaye.',
                'niveau' => 'debutant',
                'zone_geo' => 'pikine',
                'demande_locale' => 12,
                'justification_source' => 'Enquêtes kiosques Marché Thiaroye + offres WhatsApp groupes « Jobs Dakar », août 2026',
                'source_updated_on' => '2026-08-18',
                'contenu' => [
                    'type' => 'texte',
                    'source' => 'Fiche atelier Jokalante / formateurs Sandaga, 2026',
                    'corps_fr' => "En 20 minutes, tu peux déjà isoler 3 pannes courantes.\n\n1. L’écran tactile ne répond plus mais l’image s’affiche : souvent la nappe, pas tout l’écran.\n2. Le téléphone s’éteint à 30 % : tester une batterie d’occasion avant de commander une neuve.\n3. Ça charge seulement en position penchée : le port USB est oxydé — un nettoyage à l’alcool isopropylique suffit souvent.\n\nRègle d’or : ne jamais forcer un tournevis Y000. Marque chaque vis. Un téléphone qui ne rallume pas après démontage, c’est presque toujours une vis mal remise.",
                    'corps_wo' => "Ci 20 minuti, mën nga xam 3 problem yu ëpp.\n\n1. Ekran du jaaxal waaye nataal dafa nekk : nappe moo am jafe-jafe, du ekran bépp.\n2. Telefon dafay fey ci 30% : seetal batterie bu yàgg bala ngay jënd bu bees.\n3. Dafay charge rekk su nga tënk : port USB dafa xarax — alcohol isopropyl mën na ko setal.\n\nLu am solo : bul jëfandikoo tournevis Y000 ci doole. Bind vis yi. Su telefon bañee tàkk ginaaw, vis moo dëkkul.",
                    'script_audio_fr' => 'Micro-leçon réparation smartphone. Trois pannes fréquentes à Pikine : nappe d’écran, batterie faible trop tôt, port de charge oxydé. Nettoie, teste, ne force jamais les vis. Ensuite, va te faire valider en atelier.',
                    'script_audio_wo' => 'Leçon ndaw ci defar telefon. Ñett problem yu ëpp ci Pikine : nappe ekran, batterie ju gaaw fey, port charge ju xarax. Setal, seet, bul jëfandikoo vis yi ci doole. Topp, dem atelier ngir ñu seet sa liggéey.',
                ],
                'opportunites' => [[
                    'titre_fr' => 'Atelier d’essai — Centre Métiers Pikine Nord',
                    'titre_wo' => 'Atelier njeexital — Centre Métiers Pikine Nord',
                    'lieu' => 'Centre Métiers, route des Niayes, Pikine Nord (près du marché Thiaroye)',
                    'contact' => 'Fatou Diop, 77 512 44 18 (WhatsApp)',
                    'condition_eligibilite_fr' => '16–35 ans, pièce d’identité, 1 téléphone HS à apporter si possible. Gratuit le mercredi.',
                    'condition_eligibilite_wo' => '16 ba 35 at, kàrt identite, telefon bu yàqu bu nga mën indil. Mercredi dara la.',
                    'delai_fr' => 'Prochaine session : mercredi 23 septembre 2026, 9h.',
                    'delai_wo' => 'Session bu nekk : alarba 23 septembre 2026, 9h.',
                    'source' => 'Affiche centre + appel formateur, 2 sept. 2026',
                    'source_updated_on' => '2026-09-02',
                    'zone_geo' => 'pikine',
                ]],
            ],
            [
                'slug' => 'vente-whatsapp',
                'nom_fr' => 'Vente sur WhatsApp Business',
                'nom_wo' => 'Jaay ci WhatsApp Business',
                'description_fr' => 'Ouvrir un catalogue, répondre aux clients et encaisser via Wave — demandé par les boutiques de Rufisque et Grand-Yoff.',
                'description_wo' => 'Ubbi catalogue, tontu kijaan yi, jot xaalis ci Wave — boutik yi ci Rufisque ak Grand-Yoff a koy soxla.',
                'niveau' => 'debutant',
                'zone_geo' => 'rufisque',
                'demande_locale' => 18,
                'justification_source' => 'Comptes-rendus Chambre de métiers Rufisque + groupe « Commerçants Dakar », juillet 2026',
                'source_updated_on' => '2026-07-22',
                'contenu' => [
                    'type' => 'texte',
                    'source' => 'Fiche Jokalante / association commerçantes Rufisque',
                    'corps_fr' => "Ton premier catalogue en 4 gestes.\n\n1. Crée un compte WhatsApp Business (pas le compte personnel de la famille).\n2. Photo de profil = produit net, pas un selfie. Description : prix + quartier de livraison.\n3. Trois photos par article, lumière du jour, fond uni. Écris le prix sur l’image.\n4. Réponds en moins de 30 minutes entre 9h et 19h. Propose Wave ou Orange Money, jamais « on verra ».\n\nPiège : ne vends pas un stock que tu n’as pas. Un client perdu à Rufisque parle à tout le marché.",
                    'corps_wo' => "Sa catalogue bu njëkk ci 4 jëf.\n\n1. Sos konte WhatsApp Business (du konte waa kër ga).\n2. Nataal profil = lu nga jaay, du sa kanam. Bind prij ak kër-gi ngay yónnee.\n3. Ñett nataal ci benn loxol, leer u bëccëg. Bind prij ci nataal bi.\n4. Tontu ci 30 minuti, 9h ba 19h. Wave walla Orange Money, bul wax « dinga gis ».\n\nTuuma : bul jaay lu amul. Kijaan bu ñàkk ci Rufisque dafay wax ak marché bépp.",
                    'script_audio_fr' => 'Micro-leçon vente WhatsApp. Compte Business séparé, photos claires avec prix, réponse rapide, paiement Wave. Ne promets pas un stock que tu n’as pas. L’étape suivante : atelier catalogue au marché de Rufisque.',
                    'script_audio_wo' => 'Leçon ndaw ci jaay WhatsApp. Konte Business, nataal yu leer ak prij, tontu gaaw, Wave. Bul dig lu amul. Li topp : atelier catalogue ci marché Rufisque.',
                ],
                'opportunites' => [[
                    'titre_fr' => 'Atelier « Catalogue en 2 heures » — Marché central Rufisque',
                    'titre_wo' => 'Atelier Catalogue — Marché Rufisque',
                    'lieu' => 'Bureau des commerçantes, marché central, Rufisque',
                    'contact' => 'Awa Ndiaye, 76 204 91 55',
                    'condition_eligibilite_fr' => 'Smartphone Android, 3 produits à photographier. 2 000 F de participation, places limitées à 15.',
                    'condition_eligibilite_wo' => 'Telefon Android, 3 loxol yu nga nataal. 2 000 F, 15 nit rekk.',
                    'delai_fr' => 'Samedi 26 septembre 2026, 10h–12h.',
                    'delai_wo' => 'Gaawu 26 septembre 2026, 10h ba 12h.',
                    'source' => 'Association commerçantes Rufisque, 28 août 2026',
                    'source_updated_on' => '2026-08-28',
                    'zone_geo' => 'rufisque',
                ]],
            ],
            [
                'slug' => 'installation-solaire',
                'nom_fr' => 'Installation solaire domestique',
                'nom_wo' => 'Taxal solaire ci kër',
                'description_fr' => 'Brancher un kit 100–300 W en zone périurbaine et rurale — demande forte là où la SENELEC coupe souvent.',
                'description_wo' => 'Tànn kit 100 ba 300 W ci dëkk yu sori — ñu soxla ko fu SENELEC di dog.',
                'niveau' => 'intermediaire',
                'zone_geo' => 'thies-rural',
                'demande_locale' => 9,
                'justification_source' => 'ANER / points de vente kits Bargny–Sébikotane, juin 2026',
                'source_updated_on' => '2026-06-12',
                'contenu' => [
                    'type' => 'texte',
                    'source' => 'Fiche simplifiée ANER + atelier Jokalante',
                    'corps_fr' => "Un kit domestique, ce n’est pas « coller un panneau sur le toit ».\n\n1. Le panneau regarde le sud, sans ombre de manguier entre 10h et 15h.\n2. La batterie ne va jamais à même le sol en terre battue : caisse aérée, hors de la chambre des enfants.\n3. Section des câbles : trop fin = incendie. Si ça chauffe, tu débranches.\n4. Un régulateur PWM pour kit d’entrée, MPPT seulement si le vendeur l’explique clairement.\n\nTu n’installes pas chez un voisin avant d’avoir fait une pose supervisée.",
                    'corps_wo' => "Kit kër, du « tëj panneau ci tàgg ».\n\n1. Panneau jàkk bëj-saalum, du am ker mango 10h ba 15h.\n2. Batterie du tëral ci suuf : boyet bu am ngelaw, sore waa kër yu ndaw.\n3. Cable yu sew = safara. Su tàngee, duggil.\n4. Régulateur PWM ci kit bu njëkk. MPPT su jaaykat bi ko leeralée.\n\nBul taxal kër dëkkandoo bala ngay am njeexital ak formateur.",
                    'script_audio_fr' => 'Micro-leçon solaire. Orientation sud, batterie hors sol, câbles qui ne chauffent pas, pose toujours supervisée. Les données ANER datent de juin : à vérifier sur place. Prochaine étape : session pratique Bargny.',
                    'script_audio_wo' => 'Leçon ndaw ci solaire. Jàkk bëj-saalum, batterie sore suuf, cable yu tàngul, njeexital ak formateur. Xibaar ANER junio la : seetal ci bérab. Li topp : session Bargny.',
                ],
                'opportunites' => [[
                    'titre_fr' => 'Session pratique kits 200 W — Bargny',
                    'titre_wo' => 'Session kit 200 W — Bargny',
                    'lieu' => 'Point relais énergie, route de Rufisque, Bargny',
                    'contact' => 'Ibrahima Sarr, 70 118 33 90',
                    'condition_eligibilite_fr' => 'Savoir lire un schéma simple. Chaussures fermées obligatoires. 18 ans minimum.',
                    'condition_eligibilite_wo' => 'Mën jàng schema. Dàll yu tëj. 18 at.',
                    'delai_fr' => 'Inscriptions ouvertes jusqu’au 30 septembre 2026.',
                    'delai_wo' => 'Mën nga bind ba 30 septembre 2026.',
                    'source' => 'Point relais ANER Bargny (données juin 2026, à confirmer)',
                    'source_updated_on' => '2026-06-12',
                    'zone_geo' => 'thies-rural',
                ]],
            ],
            [
                'slug' => 'bureautique',
                'nom_fr' => 'Bureautique et dossiers administratifs',
                'nom_wo' => 'Liggéey bureau ak kayit',
                'description_fr' => 'Word, Excel simple et scan de pièces — demandé par mairies d’arrondissement et cabinets de Dakar.',
                'description_wo' => 'Word, Excel bu yomb, scan kayit — mairie yi ak cabinet Dakar a koy laaj.',
                'niveau' => 'debutant',
                'zone_geo' => 'dakar',
                'demande_locale' => 14,
                'justification_source' => 'Offres CDD secrétariat mairies Grand-Dakar / Parcelles, août 2026',
                'source_updated_on' => '2026-08-05',
                'contenu' => [
                    'type' => 'texte',
                    'source' => 'Référentiel OFPPT adapté Jokalante',
                    'corps_fr' => "Ce que les employeurs testent vraiment.\n\n1. Un CV d’une page, police lisible, pas de fond coloré.\n2. Un tableau Excel : noms, dates, totaux avec =SOMME. Pas de calcul à la main.\n3. Scanner une CNI sans ombre, fichier inférieur à 500 Ko.\n4. Nommer les fichiers : 2026-09-Aida-CNI.pdf — jamais « document final 2 ».\n\nSi tu rates ça, le reste du diplôme ne compte pas pour un poste d’accueil.",
                    'corps_wo' => "Lu liggéeykat yi di seet.\n\n1. CV benn xët, bind bu leer, du melax.\n2. Tableau Excel : tur, bés, total ak =SOMME.\n3. Scan CNI bu amul ker, file < 500 Ko.\n4. Tur file : 2026-09-Aida-CNI.pdf — du « document final 2 ».\n\nSu loolu jafee, diplôme bi du jariñ ci poste accueil.",
                    'script_audio_fr' => 'Micro-leçon bureautique. CV propre, somme Excel, scan léger, fichiers bien nommés. C’est ce que les mairies de Dakar testent. Étape suivante : atelier gratuit à la maison de quartier Grand-Yoff.',
                    'script_audio_wo' => 'Leçon ndaw ci bureau. CV bu leer, Excel SOMME, scan bu woyof, tur file yu rafet. Loolu la mairie Dakar di seet. Li topp : atelier Grand-Yoff.',
                ],
                'opportunites' => [[
                    'titre_fr' => 'Atelier CV + Excel — Maison de quartier Grand-Yoff',
                    'titre_wo' => 'Atelier CV + Excel — Grand-Yoff',
                    'lieu' => 'Maison de quartier, Grand-Yoff, Dakar',
                    'contact' => 'Bureau accueil, 33 855 21 40',
                    'condition_eligibilite_fr' => 'Ouvert à toutes et tous. Apporter une clé USB. Pas de diplômes exigés.',
                    'condition_eligibilite_wo' => 'Ku nekk mën na ñëw. Indil clé USB. Diploma laajuwul.',
                    'delai_fr' => 'Tous les mardis 14h, sur inscription.',
                    'delai_wo' => 'Talaata 14h, bindul bañ.',
                    'source' => 'Planning maison de quartier, 1er sept. 2026',
                    'source_updated_on' => '2026-09-01',
                    'zone_geo' => 'dakar',
                ]],
            ],
            [
                'slug' => 'maintenance-pc',
                'nom_fr' => 'Maintenance informatique de proximité',
                'nom_wo' => 'Defar ordinateur',
                'description_fr' => 'Nettoyage, antivirus, réinstallation Windows — cybercafés et lycées de Pikine recrutent des dépanneurs du quartier.',
                'description_wo' => 'Setal, antivirus, Windows — cyber ak lycée Pikine a soxla nit yu mën defar.',
                'niveau' => 'intermediaire',
                'zone_geo' => 'pikine',
                'demande_locale' => 7,
                'justification_source' => 'Tournée 8 cybercafés Pikine-Guédiawaye, août 2026',
                'source_updated_on' => '2026-08-20',
                'contenu' => [
                    'type' => 'texte',
                    'source' => 'Checklist formateurs Jokalante',
                    'corps_fr' => "Diagnostic en 10 minutes, pas en 2 heures.\n\n1. Écoute le client : lent au démarrage, ou seulement sur YouTube ?\n2. Espace disque < 10 % : vider Téléchargements avant tout logiciel miracle.\n3. Pâte thermique et poussière : 70 % des PC « qui chauffent » à Pikine.\n4. Sauvegarde avant formatage. Toujours. Sur une clé, pas « on verra après ».\n\nTu factures le diagnostic même si la personne refuse la réparation.",
                    'corps_wo' => "Seet ci 10 minuti, du 2 waxtu.\n\n1. Déggul kijaan : dafa yeex ci tàkk, walla YouTube rekk ?\n2. Disk < 10% : empty Téléchargements bala ngay dugg logiciel.\n3. Poussière ak pâte thermique : 70% PC yu tàng ci Pikine.\n4. Backup bala ngay format. Ci clé, du « dinga gis ».\n\nJot xaalis diagnostic doon, su ñu bañee defar.",
                    'script_audio_fr' => 'Micro-leçon maintenance PC. Questionne, libère le disque, dépoussière, sauvegarde avant formatage. Facture le diagnostic. Étape suivante : stage d’observation dans un cyber de Guédiawaye.',
                    'script_audio_wo' => 'Leçon ndaw ci defar PC. Laaj, empty disk, dindi poussière, backup. Jot diagnostic. Li topp : stage cyber Guédiawaye.',
                ],
                'opportunites' => [[
                    'titre_fr' => 'Stage d’observation 3 jours — Cyber Guédiawaye',
                    'titre_wo' => 'Stage 3 bés — Cyber Guédiawaye',
                    'lieu' => 'Cyber Okada, route de Camberene, Guédiawaye',
                    'contact' => 'Mamadou Ba, 77 890 12 44',
                    'condition_eligibilite_fr' => 'Avoir déjà ouvert un PC (vis). Non rémunéré, 2 places par mois.',
                    'condition_eligibilite_wo' => 'Mën ubbi PC. Duñu la jox xaalis. 2 palas ci weer.',
                    'delai_fr' => 'Prochaine vague : 5 octobre 2026.',
                    'delai_wo' => 'Waxtu bu nekk : 5 octobre 2026.',
                    'source' => 'Entretien gérant cyber, 20 août 2026',
                    'source_updated_on' => '2026-08-20',
                    'zone_geo' => 'pikine',
                ]],
            ],
            [
                'slug' => 'electricite-batiment',
                'nom_fr' => 'Électricité bâtiment — bases sûres',
                'nom_wo' => 'Koor kër — dëgg yu wóor',
                'description_fr' => 'Lire un schéma simple, poser une prise, respecter la terre — chantiers de Rufisque et Diamniadio.',
                'description_wo' => 'Jàng schema, taxal prise, honneur terre — chantier Rufisque ak Diamniadio.',
                'niveau' => 'debutant',
                'zone_geo' => 'rufisque',
                'demande_locale' => 11,
                'justification_source' => 'Chantiers promoteurs Diamniadio / syndicats apprentis, sept. 2026',
                'source_updated_on' => '2026-09-04',
                'contenu' => [
                    'type' => 'texte',
                    'source' => 'Rappel sécurité ONEE / formateurs locaux',
                    'corps_fr' => "La compétence n°1 n’est pas « brancher vite ». C’est ne tuer personne.\n\n1. Coupe le disjoncteur. Vérifie avec un testeur. Encore une fois.\n2. Neutre à gauche, phase à droite, terre au milieu sur une prise 2P+T.\n3. Jamais deux fils sous la même vis « parce que ça tient ».\n4. Si tu ne comprends pas le schéma, tu ne poses pas.\n\nSans attestation d’apprentissage, tu n’interviens pas seul sur un tableau.",
                    'corps_wo' => "Liggéey bu njëkk du « tànn gaaw ». Mooy bañ rey nit.\n\n1. Dog disjoncteur. Seet ak testeur. Waatoo.\n2. Neutre càmmoñ, phase ndeyjoor, terre ci digg.\n3. Bul tëj ñaar fiil ci benn vis.\n4. Su nga xamul schema, bul taxal.\n\nSu amuloo njeexital, bul liggéey sa bopp ci tableau.",
                    'script_audio_fr' => 'Micro-leçon électricité. Couper, tester, respecter phase-neutre-terre, ne jamais poser seul sans apprentissage. Étape suivante : inscription CFA bâtiment Rufisque.',
                    'script_audio_wo' => 'Leçon ndaw ci koor. Dog, seet, phase-neutre-terre, bul liggéey sa bopp. Li topp : bind CFA Rufisque.',
                ],
                'opportunites' => [[
                    'titre_fr' => 'Inscription apprentissage — CFA Bâtiment Rufisque',
                    'titre_wo' => 'Bind apprentissage — CFA Rufisque',
                    'lieu' => 'CFA Bâtiment, quartier Diokoul, Rufisque',
                    'contact' => 'Secrétariat, 33 836 10 22',
                    'condition_eligibilite_fr' => 'BFEM souhaité mais pas obligatoire. Dossier : photos, acte de naissance, 5 000 F de frais de dossier.',
                    'condition_eligibilite_wo' => 'BFEM baax na waaye du laaj. Nataal, acte de naissance, 5 000 F.',
                    'delai_fr' => 'Dossier à déposer avant le 15 octobre 2026.',
                    'delai_wo' => 'Indil dossier balaa 15 octobre 2026.',
                    'source' => 'Secrétariat CFA, 4 sept. 2026',
                    'source_updated_on' => '2026-09-04',
                    'zone_geo' => 'rufisque',
                ]],
            ],
        ];
    }
}
