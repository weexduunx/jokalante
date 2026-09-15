# Cahier des charges — Jokalante

**Projet :** Jokalante  
**Signification :** « créer une connexion » en wolof  
**Contexte :** Hackathon OSF — _Information You Can Trust_
**Track principal :** Éducation & Adéquation Emploi  
**Tracks complémentaires :** Transparency & Accountability / Safety, Reporting & Protection  
**Type de projet :** Proof of Concept — MVP extensible de hackathon
**Durée cible de développement :** 48 heures

---

## 1. Présentation du projet

### 1.1. Nom

# JOKALANTE

### 1.2. Signification

**Jokalante** signifie **« créer une connexion »**.

Le nom traduit la mission du projet : créer une connexion entre :

> **les personnes → le savoir → les compétences → les formations → les opportunités → le marché du travail.**

### 1.3. Signature

> **Jokalante — Créer la connexion entre savoir et opportunité.**

Alternative pour une présentation internationale :

> **Jokalante — Connecting people to trusted knowledge and opportunities.**

---

## 2. Contexte et problématique

Dans de nombreux contextes africains, les jeunes disposent aujourd'hui d'un accès croissant à Internet, aux réseaux sociaux et aux plateformes numériques.

Cependant, l'abondance d'information ne signifie pas nécessairement un meilleur accès aux opportunités.

Les informations relatives :

- aux formations ;
- aux compétences recherchées ;
- aux programmes d'accompagnement ;
- aux opportunités professionnelles ;
- aux certifications ;
- aux dispositifs publics ;
- aux centres de formation ;

sont souvent dispersées entre différents sites, réseaux sociaux, groupes WhatsApp, organismes et institutions.

Cette information peut également être :

- difficile à comprendre ;
- difficile à comparer ;
- incomplète ;
- géographiquement éloignée ;
- ancienne ;
- difficile à vérifier.

Le jeune se retrouve donc face à une question essentielle :

> **« Quelle information puis-je réellement croire et quelle action dois-je entreprendre ensuite ? »**

---

## 3. Problème central

Le problème que Jokalante cherche à résoudre n'est pas simplement le manque d'information.

Il s'agit du **manque d'information fiable, contextualisée et actionnable** permettant aux jeunes de prendre de meilleures décisions concernant leur formation et leur avenir professionnel.

### Problème formulé

> **Les jeunes ont accès à de nombreuses informations sur les formations et les opportunités, mais disposent rarement d'un moyen simple pour déterminer ce qui est pertinent pour leur profil, ce qui est fiable et quelle action concrète entreprendre ensuite.**

---

## 4. Objectif général

Jokalante a pour objectif de permettre à un utilisateur de passer :

> **d'une information dispersée à une décision éclairée, puis à une action concrète.**

Le système doit répondre à cinq questions :

1. Que devrais-je apprendre ?
2. Pourquoi cette compétence est-elle pertinente pour moi ?
3. Où puis-je l'apprendre ou la valider ?
4. Quelle opportunité ou quelle action puis-je entreprendre ensuite ?
5. Pourquoi puis-je faire confiance à cette recommandation et à cette opportunité ?

---

## 5. Objectifs spécifiques

Le MVP devra permettre de :

1. recueillir quelques informations simples sur l'utilisateur ;
2. identifier ses objectifs et contraintes ;
3. recommander des compétences pertinentes ;
4. expliquer la recommandation ;
5. proposer un micro-contenu pédagogique ;
6. présenter des formations ou opportunités locales ;
7. afficher clairement les sources utilisées ;
8. indiquer la date de dernière vérification ;
9. signaler les informations potentiellement obsolètes ;
10. fournir une prochaine action claire ;
11. fonctionner sur des appareils mobiles modestes ;
12. proposer au minimum deux langues pour la démonstration ;
13. construire un parcours personnalisé composé d'étapes progressives ;
14. permettre à l'utilisateur de comprendre les critères utilisés par l'IA ;
15. conserver les recommandations, la progression et la prochaine action dans un tableau de bord léger.

---

## 6. Public cible

### Persona principal — Moussa

**23 ans — Pikine, Sénégal**

- jeune diplômé ou déscolarisé ;
- recherche une opportunité ;
- dispose d'un smartphone Android d'entrée de gamme ;
- connexion Internet intermittente ;
- ne sait pas quelle compétence développer ;
- reçoit régulièrement des informations provenant de WhatsApp et des réseaux sociaux ;
- a des difficultés à vérifier leur authenticité.

### Besoin

> **« Aidez-moi à savoir quoi apprendre, où le faire et quelle opportunité est réellement accessible. »**

### Persona secondaire — Aïda

**19 ans**, étudiante ou jeune apprenante ayant peu accès à un accompagnement pédagogique individuel.

**Besoin :** apprendre une compétence de manière simple et adaptée à son niveau.

### Persona tertiaire — Fatou

Formatrice ou actrice locale connaissant les besoins de son territoire.

**Besoin :** disposer d'informations fiables et aider à maintenir l'écosystème local à jour.

---

## 7. Proposition de valeur

### Pour les jeunes

> **Jokalante vous aide à comprendre ce qu'il est pertinent d'apprendre et vous connecte à une opportunité réelle et vérifiable.**

### Pour les acteurs de formation

> **Jokalante permet de rendre leurs formations plus visibles auprès des personnes qui en ont réellement besoin.**

### Pour les institutions et organisations

> **Jokalante facilite la diffusion d'informations fiables, compréhensibles et localement pertinentes.**

---

## 8. Positionnement et principe fonctionnel central

Jokalante n'est ni un simple chatbot, ni un moteur de recherche, ni une plateforme de cours complète. C'est une **plateforme de confiance qui utilise l'IA pour transformer des informations vérifiées en parcours personnalisés et en actions concrètes**.

Grok est le moteur d'intelligence et d'interprétation. Il ne constitue jamais la source de vérité métier : les formations, compétences et opportunités affichées proviennent de données structurées et référencées dans Jokalante.

Le parcours utilisateur repose sur huit étapes :

```text
┌─────────────┐
│   PROFIL    │
│ Qui suis-je │
└──────┬──────┘
       ↓
┌─────────────┐
│ DIAGNOSTIC  │
│ Ce qui me manque │
└──────┬──────┘
       ↓
┌─────────────┐
│ INTELLIGENCE │
│ Analyse + explication │
└──────┬──────┘
       ↓
┌─────────────┐
│  PARCOURS   │
│ Étapes personnalisées │
└──────┬──────┘
       ↓
┌─────────────┐
│ APPRENDRE   │
│ Micro-contenu + exercice │
└──────┬──────┘
       ↓
┌─────────────┐
│ OPPORTUNITÉ │
│ Source + confiance │
└──────┬──────┘
       ↓
┌─────────────┐
│ CONNEXION   │
│ Consulter / contacter │
└──────┬──────┘
       ↓
┌─────────────┐
│   SUIVI     │
│ Progression + prochaine action │
└──────┬──────┘
└─────────────┘
```

---

## 9. Fonctionnalités du MVP

### F01 — Choix de langue

L'utilisateur sélectionne sa langue.

**MVP :**

- Français
- Wolof

**Évolution :**

- Pulaar ;
- Sérère ;
- Diola ;
- arabe ;
- portugais ;
- autres langues locales.

---

### F02 — Diagnostic rapide

Le diagnostic doit être réalisable en moins de **2 minutes**.

Informations recueillies :

- tranche d'âge ;
- zone géographique ;
- niveau d'étude ;
- objectif ;
- domaine d'intérêt ;
- expérience éventuelle ;
- disponibilité ;
- préférence linguistique.

**Aucune donnée personnelle sensible n'est nécessaire.**

L'utilisateur peut utiliser Jokalante **sans créer de compte**.

La zone géographique propose les **14 régions du Sénégal** afin d'éviter une recommandation limitée à Dakar. Après le choix de la région et de l'objectif, Groq propose un mini-catalogue de domaines et compétences à explorer, avec un nom, une description et une raison de pertinence.

---

### F03 — Moteur de recommandation IA

À partir du profil et du mini-catalogue proposé par Groq, Jokalante identifie les compétences les plus pertinentes.

Le catalogue proposé par Groq est une **proposition d'exploration**, pas une vérité métier. Une compétence déjà présente dans le catalogue vérifié peut conduire à une opportunité locale. Une nouvelle compétence doit être validée et documentée avant de pouvoir être associée à une opportunité présentée comme fiable.

Exemple :

```text
Profil

Niveau : Bac
Zone : Pikine
Objectif : trouver une activité
Domaine : numérique
Expérience : débutant
```

Résultat :

> **Compétence recommandée : Community Management**

Puis :

### Pourquoi ?

- adaptée au niveau ;
- possibilité de formation locale ;
- demande identifiée ;
- compatible avec les contraintes déclarées.

L'IA doit fournir une **explication compréhensible**.

---

### F04 — Explication de la recommandation

L'utilisateur doit pouvoir sélectionner :

> **Pourquoi cette recommandation ?**

Jokalante affiche :

- critères utilisés ;
- informations prises en compte ;
- sources ;
- limites éventuelles.

Objectif : éviter une recommandation opaque.

L'explication distingue toujours :

- les données déclarées par l'utilisateur ;
- les données vérifiées utilisées pour le matching ;
- l'interprétation produite par l'IA ;
- les limites ou incertitudes de la recommandation.

---

### F05 — Catalogue de compétences

Le MVP contiendra environ **5 à 8 compétences**.

Le catalogue peut être enrichi dynamiquement par Groq selon la région et l'objectif. Les propositions dynamiques sont affichées avec leur description et leur justification, puis comparées au catalogue Jokalante avant toute recommandation opérationnelle.

Chaque compétence possède :

- nom ;
- description ;
- niveau ;
- domaine ;
- compétences préalables ;
- contenus associés ;
- opportunités associées.

Pour les compétences retenues dans le parcours, Jokalante peut également définir :

- les compétences préalables ;
- les étapes suivantes ;
- une durée indicative ;
- le niveau attendu ;
- une ressource ou un micro-contenu associé.

Le MVP présente un parcours de démonstration de **3 à 5 étapes**, sans chercher à remplacer une formation diplômante.

---

### F06 — Micro-learning

Jokalante ne cherche pas à remplacer une école ou un LMS.

Il fournit un **contenu court permettant de commencer immédiatement**.

Exemple :

**Compétence : Community Management**

> Objectif : comprendre les bases de la création d'une publication professionnelle.

Durée : **3–5 minutes**

Format :

- texte ;
- illustrations éventuelles ;
- audio court ;
- mini-question.

---

### F07 — Opportunités locales

Chaque compétence peut être associée à des opportunités :

- formations ;
- programmes ;
- certifications ;
- stages ;
- emplois ;
- dispositifs d'accompagnement.

Chaque opportunité contient :

```text
Titre
Organisation
Localisation
Description
Conditions
Date limite
Contact
Source
Date de vérification
Statut
```

---

### F08 — Système de confiance

C'est une **fonctionnalité centrale du projet**.

Chaque information doit afficher son niveau de fiabilité.

- 🟢 **Vérifiée** — source identifiable et vérification récente.
- 🟡 **À vérifier** — information connue mais nécessitant une nouvelle vérification.
- 🔴 **Expirée** — date limite dépassée ou information devenue obsolète.

Exemple :

```text
Source
────────────
Organisation X

Publié le
────────────
05/09/2026

Dernière vérification
────────────
14/09/2026

Statut
────────────
🟢 Vérifiée
```

L'utilisateur doit pouvoir accéder à la **source originale**.

#### Trust Score explicable

Une note de confiance peut être affichée à titre de synthèse, mais elle ne doit jamais être arbitraire ni présentée comme une garantie. Elle est calculée à partir de critères visibles :

- source identifiable et, si possible, officielle ;
- date de publication connue ;
- vérification récente ;
- informations complètes ;
- date limite renseignée ;
- absence de signalement récent.

La fiche doit afficher les critères qui ont contribué au niveau obtenu. Le détail des critères prime sur le pourcentage.

---

### F09 — Signalement d'information

L'utilisateur peut signaler une information.

Motifs :

- information expirée ;
- mauvais contact ;
- mauvaise adresse ;
- conditions incorrectes ;
- information suspecte ;
- autre.

Processus :

```text
Information
     ↓
Signalement
     ↓
Vérification
     ↓
Mise à jour
```

---

### F10 — Prochaine action

Chaque parcours doit obligatoirement aboutir à une action.

Exemple :

> ### Votre prochaine étape

**Formation :** Maintenance informatique

📍 Pikine  
📅 Prochaine session : XX  
💰 Gratuit  
📄 Conditions : BFEM minimum

**Action :** Contacter le centre / Consulter la formation / Commencer le module préparatoire.

---

### F11 — Accessibilité

Le produit doit être pensé pour des utilisateurs ayant :

- une faible connexion ;
- un appareil peu puissant ;
- différents niveaux de littératie numérique.

Principes :

- interface mobile-first ;
- peu de JavaScript ;
- navigation simple ;
- boutons suffisamment grands ;
- langage simple ;
- contenus courts ;
- audio lorsque pertinent ;
- aucune dépendance à une connexion permanente.

---

### F12 — Mode faible connectivité

**MVP :**

- pages légères ;
- images compressées ;
- peu de requêtes ;
- cache des contenus déjà consultés si possible.

**Roadmap :**

- SMS ;
- USSD ;
- Progressive Web App complète ;
- synchronisation différée.

**SMS/USSD n'est pas obligatoire pour le MVP 48h.**

---

### F13 — Multilinguisme

Le système doit séparer :

```text
Interface
Contenu
Données
Traductions
```

Le MVP supporte :

> 🇫🇷 Français  
> 🇸🇳 Wolof

L'IA peut aider à adapter les explications.

**L'information source ne doit jamais être remplacée par la traduction IA.**

---

### F14 — Parcours personnalisé

À partir du profil, du diagnostic et des compétences disponibles, Jokalante propose un parcours lisible :

```text
Objectif : devenir développeur web
       ↓
HTML → CSS → JavaScript → PHP → Laravel
       ↓
Formation, certification ou opportunité
```

Chaque étape peut afficher :

- objectif ;
- durée estimée ;
- niveau ;
- prérequis ;
- micro-contenu ;
- exercice ou validation simple ;
- état : à commencer, en cours ou terminé.

**MVP :** un seul parcours personnalisé démontrable, alimenté par le catalogue local. La progression est enregistrée de manière anonyme lorsque l'utilisateur ne crée pas de compte.

---

### F15 — Assistant Jokalante avec Grok

L'utilisateur peut poser une question en français ou en wolof. L'assistant répond uniquement à partir :

- du profil et des préférences connus ;
- des compétences, contenus et opportunités disponibles ;
- des sources vérifiées associées à ces données.

Chaque réponse doit renvoyer vers les éléments utilisés et proposer une action concrète. Si l'information n'est pas disponible ou n'est pas suffisamment vérifiée, l'assistant doit le dire explicitement et ne pas l'inventer.

Le chat est une interface complémentaire : il ne remplace pas le parcours guidé, la fiche source ni les règles de confiance.

---

### F16 — Tableau de bord utilisateur

Un tableau de bord léger regroupe :

- l'objectif actuel ;
- les compétences recommandées ;
- la progression du parcours ;
- les opportunités sauvegardées ;
- la prochaine action ;
- les informations récemment consultées.

Le tableau de bord doit rester utilisable sans compte pour le MVP, avec une conservation locale ou une session anonyme lorsque cela est techniquement possible.

---

### F17 — Connexion aux opportunités

Pour chaque opportunité, l'utilisateur peut :

- consulter les conditions ;
- ouvrir la source originale ;
- sauvegarder l'opportunité ;
- contacter l'organisme via le canal publié ;
- signaler une information incorrecte.

Jokalante ne promet ni admission ni emploi. Il facilite une mise en relation traçable.

---

### F18 — Espaces partenaires (évolution)

Après le MVP, un espace formateur ou organisme pourra permettre de :

- publier une formation ;
- renseigner les prérequis, dates et zones ;
- mettre à jour le statut ;
- répondre aux signalements.

Un espace partenaires pourra ensuite relier centres de formation, entreprises, ONG, associations et institutions publiques. Ces espaces ne sont pas requis pour la démonstration des 48 heures.

---

## 10. Architecture fonctionnelle

```text
                  ┌──────────────────┐
                  │    UTILISATEUR   │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │    DIAGNOSTIC    │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │    IA / MATCHING │
                  └────────┬─────────┘
                           │
                ┌──────────┴──────────┐
                ▼                     ▼
        ┌──────────────┐      ┌──────────────┐
        │ COMPÉTENCES  │      │ OPPORTUNITÉS │
        └──────┬───────┘      └──────┬───────┘
               │                     │
               ▼                     ▼
        ┌──────────────┐      ┌──────────────┐
        │ MICRO-       │      │ SOURCE /     │
        │ CONTENU      │      │ VÉRIFICATION │
        └──────┬───────┘      └──────┬───────┘
               └──────────┬──────────┘
                          ▼
                 ┌─────────────────┐
                 │ PROCHAINE ACTION│
                 └─────────────────┘
```

---

## 11. Architecture technique

### Backend

**Laravel**

### Interface

**Livewire + Tailwind CSS**

### Base de données

**SQLite pour le PoC**

Migration possible vers :

**MySQL / PostgreSQL**

### IA

**Grok** est le fournisseur IA retenu pour le PoC. Il est appelé derrière une abstraction Laravel afin de pouvoir changer de fournisseur sans modifier le parcours métier.

L'API LLM est utilisée pour :

- recommandation ;
- explication ;
- simplification ;
- adaptation linguistique ;
- analyse conversationnelle contextualisée.

Le contexte transmis à Grok contient le profil, les compétences et les opportunités déjà connues par Jokalante. Le modèle `groq/compound` peut également utiliser l'outil `web_search` pour rechercher des formations, emplois, programmes ou bourses actuels lorsque le catalogue local est insuffisant.

Une source trouvée sur Internet est toujours affichée comme **source proposée — à vérifier**. Elle ne devient pas une information fiable tant que Jokalante n'a pas contrôlé son URL HTTPS, son organisme, sa date, ses conditions et sa cohérence avec l'opportunité. Groq ne doit jamais inventer une source ou transformer une page web en garantie.

### Audio

Optionnel pour le MVP.

### Déploiement

Environnement cloud simple adapté à Laravel.

---

## 12. Architecture applicative Laravel

```text
app/
├── Models/
│   ├── Competency.php
│   ├── LearningContent.php
│   ├── Opportunity.php
│   ├── Source.php
│   ├── UserProfile.php
│   └── Recommendation.php
│
├── Livewire/
│   ├── Onboarding/
│   ├── Diagnostic/
│   ├── Recommendation/
│   ├── Learning/
│   ├── Opportunities/
│   └── Reporting/
│
└── Services/
    ├── RecommendationService.php
       ├── AIServiceInterface.php
       ├── GrokAIService.php
    ├── VerificationService.php
    └── TranslationService.php
```

### Contrat d'intelligence artificielle

```php
interface AIServiceInterface
{
       public function analyzeProfile(
              array $profile,
              array $competences,
              array $opportunities
       ): array;
}
```

`GrokAIService` implémente ce contrat et centralise l'authentification, les délais d'attente, la gestion des erreurs, la limitation du contexte et la validation de la réponse. La clé API est conservée dans la configuration d'environnement et n'est jamais exposée au navigateur.

L'analyse retourne une recommandation structurée : compétence, opportunités sélectionnées par identifiant, synthèse du profil, forces, compétences à développer, métiers compatibles, justification et prochaine action. Jokalante filtre ensuite chaque identifiant contre sa base avant affichage.

---

## 13. Modèle de données

### `competencies`

```text
id
name
description
sector
level
created_at
updated_at
```

### `path_steps`

```text
id
competency_id
title
description
position
estimated_minutes
prerequisites
created_at
updated_at
```

### `learning_contents`

```text
id
competency_id
title
content
language
duration
source_id
created_at
updated_at
```

### `opportunities`

```text
id
competency_id
title
organization
description
location
eligibility
deadline
contact
source_id
status
verified_at
created_at
updated_at
```

### `sources`

```text
id
name
url
type
published_at
verified_at
status
```

### `user_profiles`

```text
id
language
location
education_level
goal
interests
experience_level
created_at
```

### `recommendations`

```text
id
profile_id
competency_id
reason
confidence
created_at
```

### `progress_records`

```text
id
profile_id
path_step_id
status
completed_at
created_at
updated_at
```

### `saved_opportunities`

```text
id
profile_id
opportunity_id
created_at
```

### `reports`

```text
id
opportunity_id
reason
description
status
created_at
```

Les champs `confidence` ou `trust_score` ne doivent pas être interprétés seuls : la réponse doit conserver les critères et les références qui les justifient.

---

## 14. Rôle de l'intelligence artificielle

L'IA ne doit pas être utilisée simplement pour ajouter un chatbot.

Elle doit résoudre des problèmes précis.

### IA 1 — Analyse de profil

**Profil → forces, objectif, niveau estimé et lacunes**

### IA 2 — Matching

**Profil → compétence**

### IA 3 — Explication

**Données → explication personnalisée**

### IA 4 — Assistant contextualisé

**Question → réponse fondée sur les données vérifiées**

### IA 5 — Simplification

**Information complexe → langage simple**

### IA 6 — Adaptation linguistique

**Français → Wolof**

---

## 15. Principe de sécurité de l'IA

### Règle fondamentale

> **L'IA ne crée pas l'information de référence.**

Elle travaille sur des informations provenant de sources identifiées.

```text
SOURCE FIABLE
      ↓
DONNÉE STRUCTURÉE
      ↓
IA
      ↓
EXPLICATION
```

et non :

```text
IA
 ↓
Information supposée vraie
```

Cela permet de réduire les risques d'hallucination.

Le flux attendu est :

```text
Profil utilisateur + données vérifiées
                    ↓
          Contexte contrôlé par Jokalante
                    ↓
                   Grok
                    ↓
      Réponse structurée + références + action
                    ↓
       Vérification des champs avant affichage
```

Une réponse refusée, incomplète ou sans référence exploitable doit être remplacée par une réponse prudente indiquant que l'information n'est pas disponible. Les résultats web sont limités à des URLs HTTPS et à cinq sources maximum par analyse.

---

## 16. Gestion de la confidentialité

Jokalante applique le principe :

> **Collecter le minimum nécessaire.**

Le diagnostic ne nécessite pas :

- nom ;
- numéro de téléphone ;
- adresse exacte ;
- pièce d'identité ;
- données sensibles.

Le système peut fonctionner avec un profil anonyme.

---

## 17. Périmètre géographique du MVP

Pour le hackathon, le projet doit être limité à **une zone pilote**.

Exemple :

> **Dakar et sa périphérie**

ou une zone encore plus précise.

Cette limitation permet d'avoir des données :

- cohérentes ;
- vérifiables ;
- localisées ;
- réalistes.

---

## 18. Données du PoC

Le MVP devra disposer de :

- **5–8 compétences**
- **5–10 opportunités**
- **3–5 sources identifiables**
- **2–3 micro-contenus**
- **2 langues**

Les données doivent être clairement identifiées comme :

> **Données de démonstration**

lorsqu'elles ne correspondent pas à des opportunités réellement vérifiées.

**Il ne faut jamais présenter une fausse opportunité comme réelle.**

---

## 19. Parcours de démonstration

### Étape 1

Moussa arrive sur Jokalante.

> **Choisir ma langue : Wolof**

### Étape 2

Il indique :

> 23 ans  
> Bac  
> Pikine  
> Sans emploi  
> Intérêt : numérique

### Étape 3

Jokalante analyse son profil.

### Étape 4

Grok produit une analyse encadrée par les données du catalogue.

Résultat :

> **Compétence recommandée**

avec une explication, les éléments utilisés et les limites éventuelles.

### Étape 5

Moussa consulte son parcours personnalisé et commence :

> **Micro-apprentissage**

### Étape 6

Jokalante affiche :

> **Opportunité locale**

avec son niveau de confiance, ses critères, sa source et sa date de vérification.

### Étape 7

Moussa consulte :

> **Source + date + statut + Trust Score explicable**

### Étape 8

Jokalante lui donne :

> **Sa prochaine action**, conservée dans son tableau de bord.

Une question libre en français ou en wolof peut être posée à l'assistant Grok. La réponse renvoie vers les mêmes données vérifiées et ne crée pas de nouvelle opportunité.

---

## 20. Indicateurs de succès

### KPI 1 — Rapidité

Parcours complet :

> **< 3 minutes**

### KPI 2 — Compréhension

Après le parcours, l'utilisateur doit pouvoir répondre :

> **« Que dois-je faire maintenant ? »**

### KPI 3 — Confiance

L'utilisateur doit pouvoir identifier :

> source + date + statut.

### KPI 4 — Accessibilité

Parcours utilisable avec une connexion fortement limitée.

### KPI 5 — Pertinence

Le testeur doit comprendre pourquoi la compétence lui a été recommandée.

### KPI 6 — Transparence IA

Le testeur doit pouvoir identifier les données utilisées, les sources citées et les limites de la réponse de Grok.

### KPI 7 — Passage à l'action

Le testeur doit pouvoir retrouver sa prochaine action depuis le tableau de bord.

---

## 21. Critères d'acceptation MVP

Le MVP sera considéré comme fonctionnel lorsque :

- [ ] un utilisateur peut démarrer sans compte ;
- [ ] il peut choisir sa langue ;
- [ ] il peut compléter un diagnostic ;
- [ ] le système produit une recommandation ;
- [ ] la recommandation est expliquée ;
- [ ] les critères utilisés par l'IA et les limites de la recommandation sont visibles ;
- [ ] un parcours personnalisé de 3 à 5 étapes est affiché ;
- [ ] la progression d'une étape peut être enregistrée ;
- [ ] un micro-contenu est accessible ;
- [ ] une opportunité locale est affichée ;
- [ ] la source est visible ;
- [ ] la date de vérification est visible ;
- [ ] le statut de confiance est visible ;
- [ ] le Trust Score, lorsqu'il est affiché, présente ses critères ;
- [ ] l'assistant Grok répond à partir d'un contexte vérifié ou indique que l'information est indisponible ;
- [ ] Groq peut proposer des sources web HTTPS lorsque le catalogue local est insuffisant ;
- [ ] les sources web proposées sont clairement marquées comme « à vérifier » ;
- [ ] une opportunité peut être sauvegardée ;
- [ ] le tableau de bord affiche la progression et la prochaine action ;
- [ ] une action suivante est proposée ;
- [ ] une information peut être signalée ;
- [ ] l'interface fonctionne correctement sur mobile.

---

## 22. Fonctionnalités hors MVP

À ne pas développer pendant les 48h :

- plateforme LMS complète ;
- certification Jokalante ;
- marketplace ;
- paiement ;
- réseau social ;
- recrutement automatisé ;
- CV builder complet ;
- scraping massif ;
- USSD complet ;
- couverture de tout le Sénégal ;
- dizaines de langues ;
- système administratif complexe ;
- espace partenaire complet avec gestion des comptes et modération avancée.

---

## 23. Roadmap post-hackathon

### Phase 2 — Accessibilité

- SMS ;
- USSD ;
- PWA offline ;
- davantage de langues locales.

### Phase 3 — Écosystème

- centres de formation ;
- ONG ;
- associations ;
- entreprises ;
- institutions publiques.

### Phase 4 — Intelligence

- analyse plus fine du marché ;
- recommandations personnalisées ;
- détection des informations obsolètes ;
- alertes sur les nouvelles opportunités ;
- amélioration de l'assistant conversationnel et de l'adaptation en langues locales.

### Phase 5 — Extension

Extension à d'autres villes et pays africains.

---

## 24. Risques

| Risque                              | Impact   | Réponse                              |
| ----------------------------------- | -------- | ------------------------------------ |
| Données obsolètes                   | 🔴 Élevé | Source + date + statut               |
| Hallucination IA                    | 🔴 Élevé | IA limitée à des données référencées |
| Données insuffisantes               | 🟠 Moyen | Zone pilote                          |
| Trop de fonctionnalités             | 🔴 Élevé | MVP strict                           |
| Mauvaise traduction                 | 🟠 Moyen | Validation humaine                   |
| Connexion faible                    | 🟠 Moyen | Interface légère                     |
| Faux sentiment de garantie d'emploi | 🔴 Élevé | Positionnement clair                 |
| Dépendance à l'API Grok             | 🟠 Moyen | Abstraction + réponse de repli       |
| Réponse IA sans preuve suffisante   | 🔴 Élevé | Contexte vérifié + validation        |
| Score de confiance mal compris      | 🟠 Moyen | Critères affichés, pas de garantie   |
| Complexité USSD                     | 🟠 Moyen | Roadmap                              |

---

## 25. Limites du projet

Jokalante **ne garantit pas** :

- l'obtention d'un emploi ;
- l'admission à une formation ;
- l'exactitude permanente d'une information externe ;
- la reconnaissance d'une certification.

Jokalante fournit :

> **une information contextualisée, traçable et destinée à aider l'utilisateur à prendre une décision.**

---

## 26. Différenciation

### Jokalante n'est pas un simple moteur de recherche

Il contextualise l'information.

### Jokalante n'est pas un simple chatbot

Il s'appuie sur des sources identifiables.

### Jokalante n'est pas une plateforme de cours

L'apprentissage est court et orienté vers l'action.

### Jokalante n'est pas un job board

Il connecte **compétence + formation + opportunité**.

### Jokalante n'est pas une plateforme de recommandations opaque

Il explique **pourquoi** une recommandation est faite.

---

## 27. Proposition de valeur finale

> **Jokalante crée une connexion entre les jeunes et les opportunités qui peuvent réellement les faire avancer.**
>
> **Il transforme des informations dispersées sur les compétences, les formations et les opportunités locales en recommandations compréhensibles, vérifiables et directement actionnables.**

---

## 28. Pitch court

> **« Le problème n'est pas toujours que l'information n'existe pas. Le problème, c'est qu'elle est dispersée, difficile à vérifier et souvent difficile à transformer en action.**
>
> **Jokalante — qui signifie "créer une connexion" en wolof — connecte les jeunes au savoir, aux compétences et aux opportunités de leur environnement.**
>
> **Grâce à l'IA, Jokalante analyse le profil d'un utilisateur, identifie les compétences pertinentes, lui propose un micro-apprentissage adapté et le connecte à une opportunité locale vérifiable.**
>
> **Chaque information affiche sa source, sa date de vérification et son niveau de confiance.**
>
> **Parce que trouver une information ne suffit pas. Il faut pouvoir la comprendre, lui faire confiance et savoir quoi faire ensuite.**
>
> **Jokalante : comprendre, vérifier, agir. »**

---

## 29. Ligne stratégique

> ### **Jokalante ne donne pas simplement plus d'informations. Il aide les jeunes à savoir quelle information croire, ce qu'elle signifie pour eux et quelle action entreprendre ensuite.**

Cette approche permet de positionner Jokalante non comme une simple plateforme EdTech, mais comme une réponse au défi **« Information You Can Trust »**.
