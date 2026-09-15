# Jokalante

**“Creating a connection” — in Wolof.**

Jokalante — Creating the connection between knowledge and opportunity.
Jokalante — Connecting people to trusted knowledge and opportunities.

Proof of Concept developed as part of the **OSF Hackathon — *Information You Can Trust***
Main track: **Education & Employment Alignment**
Additional tracks: *Transparency & Accountability* / *Safety, Reporting & Protection*

---

## Table of Contents

- [The problem](#-the-problem)
- [What Jokalante does](#-what-jokalante-does)
- [Target audience](#-target-audience)
- [Functional principle](#-functional-principle)
- [Technology stack](#-technology-stack)
- [Application architecture](#-application-architecture)
- [Data model](#-data-model)
- [Role and safeguards of AI](#-role-and-safeguards-of-ai)
- [MVP features](#-mvp-features)
- [Hackathon scope (48 hours)](#-hackathon-scope-48-hours)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Success indicators](#-success-indicators)
- [Project limitations](#-project-limitations)
- [Roadmap](#-roadmap)

---

## The problem

In many African contexts, young people have growing access to the Internet, but an abundance of information does not necessarily mean better access to opportunities. Information about training, skills, programmes and opportunities is scattered, difficult to compare, difficult to verify or already outdated.

> **“Which information can I actually trust, and what action should I take next?”**

The problem is therefore not a lack of information, but **a lack of reliable, contextualized and actionable information**.

## What Jokalante does

Jokalante helps users move **from scattered information to an informed decision, and then to concrete action**, by answering five questions:

1. What should I learn?
2. Why is this skill relevant to me?
3. Where can I learn or validate it?
4. What opportunity or action can I pursue next?
5. Why should I trust this recommendation?

Jokalante is **neither a chatbot, nor a search engine, nor a learning platform**. It is a trust platform that uses AI to transform verified information into personalized journeys and concrete actions.

## Target audience

| Persona | Profile | Need |
|---|---|---|
| **Moussa** (primary) | 23, from Pikine, recent graduate or out of school, entry-level Android smartphone, intermittent connectivity | Know what to learn, where to learn it and which opportunity is actually accessible |
| **Aïda** (secondary) | 19, student with limited access to educational support | Learn a skill in a simple way, at her own level |
| **Fatou** (tertiary) | Trainer / local stakeholder | Share reliable information and help keep the local ecosystem up to date |

## Functional principle

The user journey is based on eight steps:

```
PROFILE → DIAGNOSIS → INTELLIGENCE → JOURNEY → LEARN → OPPORTUNITY → CONNECTION → FOLLOW-UP
```

AI (Groq) is the interpretation engine, **never the source of business truth**: the skills and opportunities displayed come from structured and referenced data within Jokalante.

```
RELIABLE SOURCE → STRUCTURED DATA → AI → EXPLANATION
```

and not:

```
AI → Assumed-to-be-true information
```

##  Technology stack

| Component | Technology |
|---|---|
| Backend | **Laravel** |
| Interface | **Livewire** + **Tailwind CSS** |
| Database | **SQLite** (PoC) — can be migrated to MySQL / PostgreSQL |
| Artificial intelligence | **Groq API** (`groq/compound` model, with the `web_search` tool as a complement to the local catalogue) |
| Deployment | Simple Laravel-compatible cloud environment |

AI is called through a Laravel abstraction (`AIServiceInterface`) so that the provider can be changed without modifying the business journey. The Groq API key is stored server-side and is never exposed to the browser.

##  Application architecture

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

### Artificial intelligence contract

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

`GroqAIService` implements this contract and centralizes authentication, timeouts, error handling, context limitation and response validation. The analysis returns a structured recommendation (skill, opportunities by ID, profile summary, strengths, gaps, compatible occupations, rationale and next action), which Jokalante filters against its database before displaying it.

## 🗄 Data model

| Table | Purpose |
|---|---|
| `competencies` | Catalogue skills (name, description, sector, level) |
| `path_steps` | Journey steps for a skill |
| `learning_contents` | Micro-learning content |
| `opportunities` | Training, internships, jobs and support programmes — with status and verification date |
| `sources` | Information sources (URL, type, publication/verification date, status) |
| `user_profiles` | Anonymous profile (language, location, level, goal, interests, experience) |
| `recommendations` | Skill recommended to a profile, rationale and confidence level |
| `progress_records` | A profile’s progress through journey steps |
| `saved_opportunities` | Opportunities saved by a profile |
| `reports` | Reports submitted about an opportunity |

The `confidence` / `trust_score` fields must never be interpreted on their own: the response must always retain the criteria and references that justify them.

##  Role and safeguards of AI

AI (Groq) addresses six specific problems:

1. **Profile analysis** — profile → strengths, goal, level and gaps
2. **Matching** — profile → skill
3. **Explanation** — data → personalized explanation
4. **Contextual assistant** — question → answer based on verified data
5. **Simplification** — complex information → plain language
6. **Language adaptation** — French ↔ Wolof

**Safety rules:**

- AI never creates reference information; it works with structured and referenced data.
- A refused, incomplete or unusable response without a workable reference is replaced with a message stating that the information is unavailable.
- Web search results are limited to **HTTPS** URLs and a maximum of **five sources** per analysis.
- A source found on the Web is always displayed as a **“suggested source — needs checking”**, never as reliable information until it has been reviewed for organization, date, eligibility requirements and consistency.
- **A fictional opportunity must never be presented as real.**

### Trust system

Each piece of information displays its status:

- 🟢 **Verified** — identifiable source and recent verification
- 🟡 **Needs checking** — known information requiring a new verification
- 🔴 **Expired** — deadline passed or information outdated

An **explainable Trust Score** may be displayed as a summary, but it must always be accompanied by the criteria that produced it (identifiable source, publication date, recent verification, complete information, stated deadline and absence of recent reports) — never presented as a guarantee.

##  MVP features

- **F01** — Language selection (French / Wolof)
- **F02** — Quick diagnosis (< 2 min, no account, no sensitive data, 14 regions of Senegal)
- **F03** — AI recommendation engine (catalogue dynamically enriched by Groq and validated before display)
- **F04** — Recommendation explanation (criteria, data, AI interpretation and limitations)
- **F05** — Skills catalogue (5 to 8 skills)
- **F06** — Micro-learning (3-to-5-minute content)
- **F07** — Local opportunities (training, internships, jobs and support programmes)
- **F08** — Trust system (statuses + explainable Trust Score)
- **F09** — Information reporting
- **F10** — A clear next action at the end of every journey
- **F11** — Accessibility (mobile-first, limited JavaScript, plain language)
- **F12** — Low-connectivity mode (lightweight pages, caching)
- **F13** — Multilingual support (separation of interface / content / data / translations)
- **F14** — Personalized journey (3 to 5 steps, anonymous progress tracking)
- **F15** — Jokalante assistant powered by Groq (answers only from verified data)
- **F16** — User dashboard (goal, recommendations, progress, saved opportunities and next action)
- **F17** — Opportunity connection (view, save, contact and report)
- **F18** — Partner spaces *(post-hackathon evolution)*

##  Scope

**Pilot area:** Dakar and its surrounding area, or a more restricted zone.

**PoC data:**

- 5–8 skills
- 5–10 opportunities
- 3–5 identifiable sources
- 2–3 pieces of micro-learning content
- 2 languages (French and Wolof)

Information that has not been genuinely verified is clearly labelled as **“Demonstration data”**.

**Outside the MVP scope:** a complete LMS, Jokalante certification, marketplace, payments, social network, automated recruitment, complete CV builder, mass scraping, full USSD service, nationwide coverage, extensive multilingual support, a complex administrative system and a complete partner space.

## Installation

```bash
# Clone the project
git clone <repository-url> jokalante
cd jokalante

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Copy the environment file
cp .env.example .env
php artisan key:generate

# Configure the SQLite database
touch database/database.sqlite

# Run migrations and seeders (demonstration catalogue)
php artisan migrate --seed

# Start the server and build assets
composer run dev
```

## Configuration

In the `.env` file:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

GROQ_API_KEY=your-groq-api-key
GROQ_MODEL=groq/compound
```

The Groq key is never exposed on the client side: all calls go through `GroqAIService` on the server side.

## Success indicators

| KPI | Target |
|---|---|
| Speed | Complete journey in less than 3 minutes |
| Understanding | The user can answer “What should I do now?” |
| Trust | The user can identify the source, date and status |
| Accessibility | Journey usable with a highly limited connection |
| Relevance | The user understands why the skill was recommended |
| AI transparency | The data, sources and limitations of the Groq response are identifiable |
| Taking action | The next action can be found again from the dashboard |

## Project limitations

Jokalante **does not guarantee**:

- obtaining a job;
- admission to a training programme;
- the permanent accuracy of external information;
- recognition of a certification.

Jokalante provides **contextualized and traceable information intended to help users make a decision**.

## Roadmap

- **Phase 2 — Accessibility**: SMS, USSD, offline PWA and additional local languages
- **Phase 3 — Ecosystem**: training centres, NGOs, associations, companies and public institutions
- **Phase 4 — Intelligence**: deeper labour-market analysis, outdated-information detection, alerts and improvements to the conversational assistant
- **Phase 5 — Expansion**: additional African cities and countries

---

## Pitch

> The problem is not always that information does not exist. The problem is that it is scattered, difficult to verify and often difficult to turn into action.
>
> Jokalante — which means “creating a connection” in Wolof — connects young people to the knowledge, skills and opportunities around them through AI, while displaying a source, verification date and confidence status for every piece of information.
>
> **Jokalante: understand, verify, act.**
