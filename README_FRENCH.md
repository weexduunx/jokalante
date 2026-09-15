# Jokalante

**« Créer une connexion » — en wolof.**

Jokalante — Créer la connexion entre savoir et opportunité.
Jokalante — Connecting people to trusted knowledge and opportunities.

Proof of Concept réalisé dans le cadre du **Hackathon OSF — *Information You Can Trust***
Track principal : **Éducation & Adéquation Emploi**
Tracks complémentaires : *Transparency & Accountability* / *Safety, Reporting & Protection*

---

## 📖 Sommaire

- [Le problème](#-le-problème)
- [Ce que fait Jokalante](#-ce-que-fait-jokalante)
- [Public cible](#-public-cible)
- [Principe fonctionnel](#-principe-fonctionnel)
- [Stack technique](#-stack-technique)
- [Architecture applicative](#-architecture-applicative)
- [Modèle de données](#-modèle-de-données)
- [Rôle et garde-fous de l'IA](#-rôle-et-garde-fous-de-lia)
- [Fonctionnalités du MVP](#-fonctionnalités-du-mvp)
- [Périmètre du hackathon (48h)](#-périmètre-du-hackathon-48h)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Indicateurs de succès](#-indicateurs-de-succès)
- [Limites du projet](#-limites-du-projet)
- [Roadmap](#-roadmap)

---

## 🎯 Le problème

Dans de nombreux contextes africains, les jeunes ont un accès croissant à Internet, mais l'abondance d'information ne veut pas dire un meilleur accès aux opportunités. Les informations sur les formations, compétences, programmes et opportunités sont dispersées, difficiles à comparer, à vérifier ou déjà obsolètes.

> **« Quelle information puis-je réellement croire et quelle action dois-je entreprendre ensuite ? »**

Le problème n'est donc pas le manque d'information, mais **le manque d'information fiable, contextualisée et actionnable**.

## 💡 Ce que fait Jokalante

Jokalante permet à un utilisateur de passer **d'une information dispersée à une décision éclairée, puis à une action concrète**, en répondant à cinq questions :

1. Que devrais-je apprendre ?
2. Pourquoi cette compétence est-elle pertinente pour moi ?
3. Où puis-je l'apprendre ou la valider ?
4. Quelle opportunité ou quelle action puis-je entreprendre ensuite ?
5. Pourquoi puis-je faire confiance à cette recommandation ?

Jokalante n'est **ni un chatbot, ni un moteur de recherche, ni une plateforme de cours**. C'est une plateforme de confiance qui utilise l'IA pour transformer des informations vérifiées en parcours personnalisés et en actions concrètes.

## 👥 Public cible

| Persona | Profil | Besoin |
|---|---|---|
| **Moussa** (principal) | 23 ans, Pikine, jeune diplômé/déscolarisé, smartphone Android d'entrée de gamme, connexion intermittente | Savoir quoi apprendre, où le faire et quelle opportunité est réellement accessible |
| **Aïda** (secondaire) | 19 ans, étudiante avec peu d'accompagnement pédagogique | Apprendre une compétence simplement, à son niveau |
| **Fatou** (tertiaire) | Formatrice / actrice locale | Diffuser des informations fiables et maintenir l'écosystème local à jour |

## 🔁 Principe fonctionnel

Le parcours utilisateur repose sur huit étapes :

```
PROFIL → DIAGNOSTIC → INTELLIGENCE → PARCOURS → APPRENDRE → OPPORTUNITÉ → CONNEXION → SUIVI
```

L'IA (Groq) est le moteur d'interprétation, **jamais la source de vérité métier** : les compétences et opportunités affichées proviennent des données structurées et référencées dans Jokalante.

```
SOURCE FIABLE → DONNÉE STRUCTURÉE → IA → EXPLICATION
```

et non :

```
IA → Information supposée vraie
```

## 🛠 Stack technique

| Composant | Technologie |
|---|---|
| Backend | **Laravel** |
| Interface | **Livewire** + **Tailwind CSS** |
| Base de données | **SQLite** (PoC) — migration possible vers MySQL / PostgreSQL |
| Intelligence artificielle | **Groq API** (modèle `groq/compound`, avec outil `web_search` en complément du catalogue local) |
| Déploiement | Environnement cloud simple compatible Laravel |

L'IA est appelée derrière une abstraction Laravel (`AIServiceInterface`) afin de pouvoir changer de fournisseur sans modifier le parcours métier. La clé API Groq est conservée côté serveur et n'est jamais exposée au navigateur.

## 🏗 Architecture applicative

```
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
    ├── GroqAIService.php
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

`GroqAIService` implémente ce contrat et centralise l'authentification, les délais d'attente, la gestion des erreurs, la limitation du contexte et la validation de la réponse. L'analyse retourne une recommandation structurée (compétence, opportunités par identifiant, synthèse du profil, forces, lacunes, métiers compatibles, justification, prochaine action), que Jokalante filtre contre sa base avant affichage.

## 🗄 Modèle de données

| Table | Rôle |
|---|---|
| `competencies` | Compétences du catalogue (nom, description, secteur, niveau) |
| `path_steps` | Étapes d'un parcours pour une compétence |
| `learning_contents` | Micro-contenus pédagogiques |
| `opportunities` | Formations, stages, emplois, dispositifs — avec statut et date de vérification |
| `sources` | Sources d'information (url, type, date de publication/vérification, statut) |
| `user_profiles` | Profil anonyme (langue, zone, niveau, objectif, intérêts, expérience) |
| `recommendations` | Compétence recommandée à un profil, raison, niveau de confiance |
| `progress_records` | Progression d'un profil sur les étapes du parcours |
| `saved_opportunities` | Opportunités sauvegardées par un profil |
| `reports` | Signalements sur une opportunité |

⚠️ Les champs `confidence` / `trust_score` ne doivent jamais être interprétés seuls : la réponse doit toujours conserver les critères et références qui les justifient.

## 🤖 Rôle et garde-fous de l'IA

L'IA (Groq) intervient sur six problèmes précis :

1. **Analyse de profil** — profil → forces, objectif, niveau, lacunes
2. **Matching** — profil → compétence
3. **Explication** — données → explication personnalisée
4. **Assistant contextualisé** — question → réponse fondée sur données vérifiées
5. **Simplification** — information complexe → langage simple
6. **Adaptation linguistique** — français ↔ wolof

**Règles de sécurité :**

- L'IA ne crée jamais l'information de référence ; elle travaille sur des données structurées et référencées.
- Une réponse refusée, incomplète ou sans référence exploitable est remplacée par un message indiquant que l'information n'est pas disponible.
- Les résultats de recherche web sont limités à des URLs **HTTPS** et à **5 sources maximum** par analyse.
- Une source trouvée sur le web est toujours affichée comme **« source proposée — à vérifier »**, jamais comme une information fiable tant qu'elle n'a pas été contrôlée (organisme, date, conditions, cohérence).
- **Il ne faut jamais présenter une fausse opportunité comme réelle.**

### Système de confiance

Chaque information affiche son statut :

- 🟢 **Vérifiée** — source identifiable et vérification récente
- 🟡 **À vérifier** — information connue nécessitant une nouvelle vérification
- 🔴 **Expirée** — date limite dépassée ou information obsolète

Un **Trust Score explicable** peut être affiché en synthèse, mais toujours accompagné des critères qui l'ont produit (source identifiable, date de publication, vérification récente, informations complètes, date limite renseignée, absence de signalement récent) — jamais comme une garantie.

## ✨ Fonctionnalités du MVP

- **F01** — Choix de langue (Français / Wolof)
- **F02** — Diagnostic rapide (< 2 min, sans compte, sans donnée sensible, 14 régions du Sénégal)
- **F03** — Moteur de recommandation IA (catalogue enrichi dynamiquement par Groq, validé avant affichage)
- **F04** — Explication de la recommandation (critères, données, interprétation IA, limites)
- **F05** — Catalogue de compétences (5 à 8 compétences)
- **F06** — Micro-learning (contenu de 3 à 5 minutes)
- **F07** — Opportunités locales (formations, stages, emplois, dispositifs)
- **F08** — Système de confiance (statuts + Trust Score explicable)
- **F09** — Signalement d'information
- **F10** — Prochaine action claire à chaque parcours
- **F11** — Accessibilité (mobile-first, peu de JS, langage simple)
- **F12** — Mode faible connectivité (pages légères, cache)
- **F13** — Multilinguisme (séparation interface / contenu / données / traductions)
- **F14** — Parcours personnalisé (3 à 5 étapes, progression anonyme)
- **F15** — Assistant Jokalante propulsé par Groq (répond uniquement à partir de données vérifiées)
- **F16** — Tableau de bord utilisateur (objectif, recommandations, progression, opportunités sauvegardées, prochaine action)
- **F17** — Connexion aux opportunités (consulter, sauvegarder, contacter, signaler)
- **F18** — Espaces partenaires *(évolution post-hackathon)*

## 🚧 Périmètre du hackathon (48h)

**Zone pilote :** Dakar et sa périphérie (ou zone plus restreinte).

**Données du PoC :**

- 5–8 compétences
- 5–10 opportunités
- 3–5 sources identifiables
- 2–3 micro-contenus
- 2 langues (français, wolof)

Les données non réellement vérifiées sont clairement identifiées comme **« Données de démonstration »**.

**Hors périmètre MVP :** plateforme LMS complète, certification Jokalante, marketplace, paiement, réseau social, recrutement automatisé, CV builder complet, scraping massif, USSD complet, couverture nationale, gestion multi-langues étendue, système administratif complexe, espace partenaire complet.

## ⚙️ Installation

```bash
# Cloner le projet
git clone <url-du-repo> jokalante
cd jokalante

# Installer les dépendances PHP
composer install

# Installer les dépendances front
npm install

# Copier le fichier d'environnement
cp .env.example .env
php artisan key:generate

# Configurer la base SQLite
touch database/database.sqlite

# Lancer les migrations et les seeders (catalogue de démonstration)
php artisan migrate --seed

# Compiler les assets
npm run dev

# Lancer le serveur
php artisan serve
```

## 🔐 Configuration

Dans le fichier `.env` :

```env
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/absolu/vers/database/database.sqlite

GROQ_API_KEY=your-groq-api-key
GROQ_MODEL=groq/compound
```

La clé Groq n'est jamais exposée côté client : tous les appels transitent par `GroqAIService`, côté serveur.

## 📊 Indicateurs de succès

| KPI | Cible |
|---|---|
| Rapidité | Parcours complet en moins de 3 minutes |
| Compréhension | L'utilisateur sait répondre à « Que dois-je faire maintenant ? » |
| Confiance | L'utilisateur identifie source + date + statut |
| Accessibilité | Parcours utilisable avec une connexion fortement limitée |
| Pertinence | L'utilisateur comprend pourquoi la compétence lui a été recommandée |
| Transparence IA | Les données, sources et limites de la réponse de Groq sont identifiables |
| Passage à l'action | La prochaine action est retrouvable depuis le tableau de bord |

## ⚠️ Limites du projet

Jokalante **ne garantit pas** :

- l'obtention d'un emploi ;
- l'admission à une formation ;
- l'exactitude permanente d'une information externe ;
- la reconnaissance d'une certification.

Jokalante fournit une **information contextualisée, traçable, destinée à aider l'utilisateur à prendre une décision**.

## 🗺 Roadmap

- **Phase 2 — Accessibilité** : SMS, USSD, PWA offline, davantage de langues locales
- **Phase 3 — Écosystème** : centres de formation, ONG, associations, entreprises, institutions publiques
- **Phase 4 — Intelligence** : analyse fine du marché, détection d'informations obsolètes, alertes, amélioration de l'assistant conversationnel
- **Phase 5 — Extension** : autres villes et pays africains

---

## Pitch

> Le problème n'est pas toujours que l'information n'existe pas. Le problème, c'est qu'elle est dispersée, difficile à vérifier et souvent difficile à transformer en action.
>
> Jokalante — qui signifie « créer une connexion » en wolof — connecte les jeunes au savoir, aux compétences et aux opportunités de leur environnement grâce à l'IA, avec une source, une date de vérification et un niveau de confiance affichés pour chaque information.
>
> **Jokalante : comprendre, vérifier, agir.**
