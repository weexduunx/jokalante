# Cahier des charges — Jokalante

**Projet :** Jokalante  
**Signification :** « créer une connexion » en wolof  
**Contexte :** Hackathon OSF — *Information You Can Trust*  
**Track principal :** Éducation & Adéquation Emploi  
**Tracks complémentaires :** Transparency & Accountability / Safety, Reporting & Protection  
**Type de projet :** Proof of Concept — MVP de hackathon  
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

Le système doit répondre à quatre questions :

1. Que devrais-je apprendre ?
2. Pourquoi cette compétence est-elle pertinente pour moi ?
3. Où puis-je l'apprendre ou la valider ?
4. Quelle opportunité ou quelle action puis-je entreprendre ensuite ?

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
12. proposer au minimum deux langues pour la démonstration.

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

## 8. Principe fonctionnel central

Le parcours utilisateur repose sur quatre étapes :

```text
┌─────────────┐
│   PROFIL    │
│ Qui suis-je │
└──────┬──────┘
       ↓
┌─────────────┐
│ RECOMMANDER │
│ Que choisir │
└──────┬──────┘
       ↓
┌─────────────┐
│  APPRENDRE  │
│ Microcontenu│
└──────┬──────┘
       ↓
┌─────────────┐
│    AGIR     │
│ Opportunité │
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

---

### F03 — Moteur de recommandation IA

À partir du profil, Jokalante identifie les compétences les plus pertinentes.

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

---

### F05 — Catalogue de compétences

Le MVP contiendra environ **5 à 8 compétences**.

Chaque compétence possède :

- nom ;
- description ;
- niveau ;
- domaine ;
- compétences préalables ;
- contenus associés ;
- opportunités associées.

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

Une API LLM utilisée pour :

- recommandation ;
- explication ;
- simplification ;
- adaptation linguistique.

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
    ├── AIService.php
    ├── VerificationService.php
    └── TranslationService.php
```

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

### `reports`

```text
id
opportunity_id
reason
description
status
created_at
```

---

## 14. Rôle de l'intelligence artificielle

L'IA ne doit pas être utilisée simplement pour ajouter un chatbot.

Elle doit résoudre des problèmes précis.

### IA 1 — Matching

**Profil → compétence**

### IA 2 — Explication

**Données → explication personnalisée**

### IA 3 — Simplification

**Information complexe → langage simple**

### IA 4 — Adaptation linguistique

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

Résultat :

> **Compétence recommandée**

avec une explication.

### Étape 5

Il consulte :

> **Micro-apprentissage**

### Étape 6

Jokalante affiche :

> **Opportunité locale**

### Étape 7

Moussa consulte :

> **Source + date + statut de vérification**

### Étape 8

Jokalante lui donne :

> **Sa prochaine action.**

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

---

## 21. Critères d'acceptation MVP

Le MVP sera considéré comme fonctionnel lorsque :

- [ ] un utilisateur peut démarrer sans compte ;
- [ ] il peut choisir sa langue ;
- [ ] il peut compléter un diagnostic ;
- [ ] le système produit une recommandation ;
- [ ] la recommandation est expliquée ;
- [ ] un micro-contenu est accessible ;
- [ ] une opportunité locale est affichée ;
- [ ] la source est visible ;
- [ ] la date de vérification est visible ;
- [ ] le statut de confiance est visible ;
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
- système administratif complexe.

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
- alertes sur les nouvelles opportunités.

### Phase 5 — Extension

Extension à d'autres villes et pays africains.

---

## 24. Risques

| Risque | Impact | Réponse |
|---|---|---|
| Données obsolètes | 🔴 Élevé | Source + date + statut |
| Hallucination IA | 🔴 Élevé | IA limitée à des données référencées |
| Données insuffisantes | 🟠 Moyen | Zone pilote |
| Trop de fonctionnalités | 🔴 Élevé | MVP strict |
| Mauvaise traduction | 🟠 Moyen | Validation humaine |
| Connexion faible | 🟠 Moyen | Interface légère |
| Faux sentiment de garantie d'emploi | 🔴 Élevé | Positionnement clair |
| Complexité USSD | 🟠 Moyen | Roadmap |

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
