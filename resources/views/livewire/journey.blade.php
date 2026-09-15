<div class="page-reveal">
    @php
        $steps = ['diagnostic' => 1, 'result' => 1, 'content' => 2, 'next' => 3, 'sms' => 3];
        $current = $steps[$screen] ?? 0;
    @endphp

    @if ($current)
        <ol
            class="mx-auto mb-8 flex max-w-3xl items-center gap-2 text-xs font-bold uppercase tracking-[0.12em] text-ink/50 sm:gap-4">
            <li class="flex items-center gap-2 {{ $current >= 1 ? 'text-forest' : '' }}"><span
                    class="flex h-8 w-8 items-center justify-center rounded-full {{ $current >= 1 ? 'bg-forest text-white' : 'bg-white' }}">1</span><span
                    class="hidden sm:inline">{{ __('step.diagnostic') }}</span></li>
            <span class="h-px flex-1 bg-ink/10"></span>
            <li class="flex items-center gap-2 {{ $current >= 2 ? 'text-forest' : '' }}"><span
                    class="flex h-8 w-8 items-center justify-center rounded-full {{ $current >= 2 ? 'bg-forest text-white' : 'bg-white' }}">2</span><span
                    class="hidden sm:inline">{{ __('step.content') }}</span></li>
            <span class="h-px flex-1 bg-ink/10"></span>
            <li class="flex items-center gap-2 {{ $current >= 3 ? 'text-forest' : '' }}"><span
                    class="flex h-8 w-8 items-center justify-center rounded-full {{ $current >= 3 ? 'bg-forest text-white' : 'bg-white' }}">3</span><span
                    class="hidden sm:inline">{{ __('step.next') }}</span></li>
        </ol>
    @endif

    @if ($screen === 'welcome')
        <div class="grid items-center gap-8 lg:grid-cols-[1.15fr_0.85fr] lg:gap-14">
            <section class="max-w-2xl">
                <div
                    class="mb-5 inline-flex items-center gap-2 rounded-full border border-forest/20 bg-mint/70 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-forest">
                    <span class="h-2 w-2 rounded-full bg-terracotta"></span> Information vérifiée · action locale
                </div>
                <h1 class="display-title max-w-xl text-4xl leading-[0.98] text-forest sm:text-6xl">
                    {{ __('welcome.title') }}</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink/75">{{ __('welcome.lead') }}</p>
                <p class="mt-4 text-sm font-bold uppercase tracking-[0.14em] text-terracotta">{{ __('app.tagline') }}
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <button type="button" wire:click="start"
                        class="lift-on-hover inline-flex items-center justify-center gap-3 rounded-xl bg-forest px-5 py-3.5 font-bold text-white shadow-xl shadow-forest/20">{{ __('welcome.cta') }}
                        <span aria-hidden="true">→</span></button>
                    <button type="button" wire:click="openSms"
                        class="inline-flex items-center justify-center rounded-xl border border-ink/15 bg-white/70 px-5 py-3.5 font-bold text-ink hover:border-forest hover:text-forest">{{ __('welcome.sms') }}</button>
                </div>
                <div class="mt-10 grid max-w-xl grid-cols-3 gap-3 border-t border-ink/10 pt-5 text-xs text-ink/60">
                    <div><strong class="block text-lg text-forest">01</strong>Profil simple</div>
                    <div><strong class="block text-lg text-forest">02</strong>IA explicable</div>
                    <div><strong class="block text-lg text-forest">03</strong>Action vérifiée</div>
                </div>
            </section>

            <aside class="app-panel relative overflow-hidden bg-forest p-6 text-white sm:p-8">
                <div class="absolute -right-12 -top-12 h-36 w-36 rounded-full border-[18px] border-saffron/30"></div>
                <div class="relative">
                    <div
                        class="flex items-center justify-between text-xs font-bold uppercase tracking-[0.16em] text-mint">
                        <span>Jokalante AI</span><span class="rounded-full bg-white/10 px-2 py-1">GROQ</span>
                    </div>
                    <h2 class="mt-10 max-w-xs text-3xl font-black leading-tight">Du profil à une prochaine étape
                        crédible.</h2>
                    <div class="mt-8 space-y-3 text-sm">
                        <div class="flex items-center gap-3 rounded-xl bg-white/10 p-3"><span
                                class="text-saffron">01</span><span>Comprendre ton objectif</span></div>
                        <div class="flex items-center gap-3 rounded-xl bg-white/10 p-3"><span
                                class="text-saffron">02</span><span>Comparer les compétences</span></div>
                        <div class="flex items-center gap-3 rounded-xl bg-saffron p-3 font-bold text-ink">
                            <span>03</span><span>Agir avec une source</span>
                        </div>
                    </div>
                    <p class="mt-8 text-xs leading-relaxed text-white/65">Les recommandations sont générées à partir de
                        données locales et vérifiables. Groq interprète ; Jokalante garde la vérité métier.</p>
                </div>
            </aside>
        </div>
    @endif

    @if ($screen === 'diagnostic')
        @php $q = $questions[$question]; @endphp
        @if (in_array($question, [4, count($questions) - 1], true))
            <div wire:loading.flex wire:target="answer" role="status" aria-live="polite"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-ink/70 px-6 backdrop-blur-sm">
                <div
                    class="w-full max-w-sm rounded-3xl bg-forest p-8 text-center text-white shadow-2xl shadow-black/30">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/10">
                        <div class="h-9 w-9 animate-spin rounded-full border-4 border-white/25 border-t-saffron"></div>
                    </div>
                    <p class="mt-6 text-xs font-bold uppercase tracking-[0.16em] text-saffron">Jokalante AI</p>
                    <p class="mt-2 text-2xl font-black">
                        {{ $question === 4 ? 'Préparation de tes pistes' : 'Analyse de ton profil' }}</p>
                    <p class="mt-3 text-sm leading-relaxed text-white/70">
                        {{ $question === 4 ? 'Groq adapte le catalogue à ton objectif et à ta région.' : 'Nous croisons ton objectif, ta région et les opportunités disponibles.' }}
                    </p>
                </div>
            </div>
        @endif
        <div class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-[0.72fr_1.28fr]">
            <aside class="app-panel hidden bg-forest p-7 text-white lg:block">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-mint">Ton profil</p>
                <h2 class="mt-4 text-3xl font-black leading-tight">On construit une direction qui te ressemble.</h2>
                <div class="mt-10 flex items-end gap-3"><span
                        class="text-5xl font-black">{{ $question + 1 }}</span><span class="pb-1 text-white/60">/
                        {{ count($questions) }} réponses</span></div>
                <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/15">
                    <div class="h-full rounded-full bg-saffron"
                        style="width: {{ (($question + 1) / count($questions)) * 100 }}%"></div>
                </div>
                <p class="mt-8 text-sm leading-relaxed text-white/70">Pas de formulaire administratif. Tes réponses
                    servent à relier ton objectif, tes contraintes et les opportunités autour de toi.</p>
            </aside>

            <section class="app-panel p-5 sm:p-8">
                <div
                    class="flex items-center justify-between text-xs font-bold uppercase tracking-[0.14em] text-ink/50">
                    <span>Diagnostic intelligent</span><span>{{ $question + 1 }} / {{ count($questions) }}</span>
                </div>
                <h2 class="mt-4 max-w-xl text-2xl font-black leading-tight sm:text-3xl">{{ $q['label'] }}</h2>
                @if ($q['field'] === 'interet')
                    <p class="mt-2 text-sm leading-relaxed text-ink/60">Ces pistes sont proposées à partir de ton
                        objectif, de ta région et des compétences disponibles dans Jokalante.</p>
                @elseif ($q['field'] === 'zone')
                    <p class="mt-2 text-sm leading-relaxed text-ink/60">Choisis l’une des 14 régions du Sénégal pour
                        recevoir des pistes et opportunités mieux localisées.</p>
                @endif
                <div class="mt-7 grid gap-3 sm:grid-cols-2">
                    @foreach ($q['options'] as $value => $label)
                        @php $catalogueItem = $q['field'] === 'interet' ? collect($suggestedCatalogue)->firstWhere('slug', $value) : null; @endphp
                        <button type="button" wire:click="answer('{{ $q['field'] }}', '{{ $value }}')"
                            wire:loading.attr="disabled"
                            class="lift-on-hover min-h-16 rounded-xl border border-ink/12 bg-cream/60 px-4 py-4 text-left font-semibold hover:border-forest hover:bg-mint/50">
                            <span class="mr-2 text-terracotta">→</span><span>{{ $label }}</span>
                            @if ($catalogueItem)
                                <span
                                    class="mt-1 block pl-5 text-xs font-normal leading-relaxed text-ink/55">{{ $catalogueItem['description'] }}</span>
                                <span
                                    class="mt-1 block pl-5 text-[11px] font-semibold text-forest/70">{{ $catalogueItem['reason'] }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>
                <button type="button" wire:click="back"
                    class="mt-7 text-sm font-bold text-ink/55 underline decoration-ink/20 underline-offset-4 hover:text-forest">{{ __('back') }}</button>
            </section>
        </div>
    @endif

    @if ($screen === 'result' && $competence)
        <div class="mx-auto max-w-5xl">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-terracotta">Analyse terminée</p>
                    <h2 class="display-title mt-2 text-4xl text-forest sm:text-5xl">{{ __('result.title') }}</h2>
                </div>
                <span class="rounded-full bg-mint px-3 py-1.5 text-xs font-bold text-forest">Recommandation
                    expliquée</span>
            </div>
            <div class="mt-7 grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
                <section class="app-panel overflow-hidden bg-forest text-white">
                    <div class="border-b border-white/10 p-6 sm:p-8">
                        <p class="text-sm font-bold uppercase tracking-[0.14em] text-saffron">Piste prioritaire</p>
                        <h3 class="mt-4 text-3xl font-black leading-tight sm:text-4xl">{{ $competence->nom() }}</h3>
                        <p class="mt-4 max-w-xl leading-relaxed text-white/75">{{ $competence->description() }}</p>
                        <div class="mt-7 flex flex-wrap gap-2 text-xs font-bold"><span
                                class="rounded-full bg-white/10 px-3 py-1.5">{{ __('niveau.' . $competence->niveau) }}</span><span
                                class="rounded-full bg-white/10 px-3 py-1.5">{{ count($analysis['local_structures'] ?? []) }}
                                structures trouvées</span></div>
                    </div>
                    <div class="grid grid-cols-3 gap-px bg-white/10">
                        <div class="bg-forest p-5"><span class="block text-2xl font-black">01</span><span
                                class="mt-1 block text-xs text-white/60">Comprendre</span></div>
                        <div class="bg-forest p-5"><span class="block text-2xl font-black">02</span><span
                                class="mt-1 block text-xs text-white/60">Pratiquer</span></div>
                        <div class="bg-saffron p-5 text-ink"><span class="block text-2xl font-black">03</span><span
                                class="mt-1 block text-xs">Agir</span></div>
                    </div>
                </section>

                <aside class="app-panel p-6 sm:p-7">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black">Pourquoi cette piste ?</h3><span
                            class="text-xl text-terracotta">✦</span>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-ink/70">
                        {{ __('result.why', ['count' => $competence->demande_locale]) }}</p>
                    @if (!empty($analysis['profile_summary']))
                        <p class="mt-4 rounded-xl bg-mint/60 p-3 text-sm leading-relaxed text-ink/75">
                            {{ $analysis['profile_summary'] }}</p>
                    @endif
                    <div class="mt-5 space-y-3 text-sm">
                        @foreach (array_slice($analysis['strengths'] ?? [], 0, 3) as $strength)
                            <div class="flex gap-3"><span
                                    class="text-forest">✓</span><span>{{ $strength }}</span>
                            </div>
                        @endforeach
                        <div class="flex gap-3"><span class="text-forest">✓</span><span>La demande locale est
                                documentée.</span></div>
                    </div>
                    @if (!empty($analysis['skills_to_develop']))
                        <div class="mt-5 border-t border-ink/10 pt-4">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">Compétences à
                                développer</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($analysis['skills_to_develop'] as $skill)
                                    <span
                                        class="rounded-full bg-cream px-2.5 py-1 text-xs font-semibold">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (!empty($analysis['next_action']))
                        <div class="mt-5 rounded-xl bg-terracotta/10 p-3 text-sm font-semibold text-terracotta">
                            Prochaine action · {{ $analysis['next_action'] }}</div>
                        @if (!empty($analysis['local_structures']))
                            <div class="mt-5 border-t border-ink/10 pt-4">
                                <p class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">Employeurs et
                                    structures à vérifier</p>
                                <div class="mt-3 space-y-3">
                                    @foreach ($analysis['local_structures'] as $structure)
                                        <a href="{{ $structure['url'] }}" target="_blank" rel="noopener noreferrer"
                                            class="block rounded-xl bg-cream p-3 hover:bg-mint">
                                            <div class="flex items-start justify-between gap-3"><span
                                                    class="font-bold text-forest">{{ $structure['name'] }}</span><span
                                                    class="text-terracotta">↗</span></div><span
                                                class="mt-1 block text-xs text-ink/55">{{ $structure['sector'] }} ·
                                                {{ $structure['region'] }}</span><span
                                                class="mt-1 block text-xs text-ink/65">{{ $structure['evidence'] }}</span><span
                                                class="mt-2 block text-[11px] font-bold uppercase tracking-[0.1em] text-terracotta">À
                                                vérifier avant contact</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @elseif ($competence->demande_locale === 0)
                            <div class="mt-5 rounded-xl bg-saffron/15 p-3 text-sm text-ink/70">Aucun employeur
                                vérifiable n’a été trouvé pour l’instant. Jokalante ne transforme pas une hypothèse en
                                recrutement.</div>
                        @endif
                    @endif
                    <details class="mt-6 border-t border-ink/10 pt-4 text-sm">
                        <summary class="cursor-pointer font-bold">{{ __('result.why_details') }}</summary>
                        <p class="mt-3 text-ink/60">{{ __('result.criteria') }} : {{ __('q.age') }},
                            {{ __('q.education') }}, {{ __('q.goal') }}, {{ __('q.zone') }},
                            {{ __('q.interet') }}, {{ __('q.experience') }}.</p>
                        <p class="mt-3 text-ink/60">{{ __('result.limit') }}</p>
                    </details>
                </aside>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-[0.8fr_1.2fr]">
                <div class="rounded-2xl border border-forest/15 bg-mint/70 p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-forest">Confiance</p>
                    <p class="mt-3 text-3xl font-black text-forest">
                        {{ $competence->sourceIsStale() ? 'À vérifier' : 'Source récente' }}</p>
                    <p class="mt-2 text-sm text-ink/65">{{ __('result.source') }} ·
                        {{ $competence->justification_source }}</p>
                    <p class="mt-3 text-xs font-semibold text-ink/55">{{ __('result.updated') }}
                        {{ $competence->source_updated_on->format('d/m/Y') }}</p>
                </div>
                <div class="app-panel flex flex-col justify-between gap-5 p-6 sm:flex-row sm:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-terracotta">Prochaine étape</p>
                        <a href="{{ route('dashboard') }}"
                            class="mt-6 inline-flex rounded-xl border border-forest bg-white px-5 py-3 font-bold text-forest hover:bg-mint">Ouvrir
                            mon parcours <span class="ml-2">→</span></a>
                        <p class="mt-2 text-xl font-black">Commencer le micro-apprentissage</p>
                        <p class="mt-1 text-sm text-ink/60">Un geste court avant de contacter une opportunité locale.
                        </p>
                    </div><button type="button" wire:click="openContent"
                        class="shrink-0 rounded-xl bg-forest px-5 py-3 font-bold text-white shadow-lg shadow-forest/15 hover:translate-y-[-2px]">{{ __('next') }}
                        <span aria-hidden="true">→</span></button>
                </div>
            </div>
            @if (!empty($analysis['web_sources']))
                <section class="app-panel mt-6 p-6 sm:p-7">
                    <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-terracotta">Recherche web Groq
                            </p>
                            <h3 class="mt-1 text-xl font-black text-forest">Sources proposées pour aller plus loin</h3>
                        </div><span class="rounded-full bg-saffron/25 px-3 py-1.5 text-xs font-bold text-ink/70">À
                            vérifier avant action</span>
                    </div>
                    <div class="mt-5 grid gap-3 md:grid-cols-2">
                        @foreach ($analysis['web_sources'] as $source)
                            <a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer"
                                class="lift-on-hover rounded-xl border border-ink/10 bg-cream/60 p-4 hover:border-forest">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="font-bold text-forest">{{ $source['title'] }}</p><span
                                        class="shrink-0 text-terracotta">↗</span>
                                </div>
                                <p class="mt-2 text-xs font-semibold text-ink/55">{{ $source['publisher'] }}
                                    @if ($source['published_at'])
                                        · {{ $source['published_at'] }}
                                    @endif
                                </p>
                                <p class="mt-2 text-sm leading-relaxed text-ink/65">{{ $source['reason'] }}</p>
                            </a>
                        @endforeach
                    </div>
                    <p class="mt-4 text-xs leading-relaxed text-ink/50">Ces liens ont été trouvés par Groq sur le web.
                        Ils ne deviennent pas des informations vérifiées tant que Jokalante n’a pas confirmé leur
                        organisme, leur date et leurs conditions.</p>
                </section>
            @endif
            <button type="button" wire:click="back"
                class="mt-5 text-sm font-bold text-ink/55 underline underline-offset-4">{{ __('back') }}</button>
        </div>
    @endif

    @if ($screen === 'content' && $competence && $contenu)
        <div class="mx-auto max-w-4xl">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-terracotta">Étape 02 · apprendre</p>
                    <h2 class="display-title mt-2 text-4xl text-forest">{{ $competence->nom() }}</h2>
                </div><span
                    class="rounded-full bg-white px-3 py-1.5 text-xs font-bold text-ink/60">{{ __('content.level') }}
                    · {{ __('niveau.' . $competence->niveau) }}</span>
            </div>
            <div class="mt-7 grid gap-6 lg:grid-cols-[1.25fr_0.75fr]">
                <article class="app-panel p-6 sm:p-9">
                    <div class="flex items-center justify-between border-b border-ink/10 pb-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-forest">Micro-contenu</p>
                            <p class="mt-1 text-sm text-ink/55">3 à 5 minutes · un geste utile</p>
                        </div><span class="text-3xl text-saffron">◒</span>
                    </div>
                    @if ($contenu->signale_obsolete)
                        <p class="mt-5 rounded-lg bg-terracotta/15 px-3 py-2 text-sm font-semibold text-terracotta">
                            {{ __('content.flagged') }}</p>
                    @endif
                    <div class="mt-7 whitespace-pre-line text-lg leading-relaxed text-ink/85">{{ $contenu->corps() }}
                    </div>
                    <p class="mt-8 border-t border-ink/10 pt-4 text-xs text-ink/50">Source pédagogique ·
                        {{ $contenu->source }} · {{ $contenu->updated_at->format('d/m/Y') }}</p>
                    <button type="button"
                        class="mt-5 rounded-xl border border-forest px-4 py-2.5 font-bold text-forest hover:bg-mint"
                        data-audio="{{ e($contenu->scriptAudio()) }}"
                        onclick="window.jokalanteSpeak(this)">{{ __('listen') }}</button>
                </article>
                <aside class="rounded-2xl bg-forest p-6 text-white sm:p-7">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-mint">Ton parcours</p>
                    <div class="mt-6 space-y-5">
                        <div class="flex gap-3"><span
                                class="flex h-7 w-7 items-center justify-center rounded-full bg-saffron text-xs font-black text-ink">✓</span>
                            <div>
                                <p class="font-bold">Recommandation</p>
                                <p class="mt-1 text-xs text-white/60">Piste choisie pour ton profil</p>
                            </div>
                        </div>
                        <div class="flex gap-3"><span
                                class="flex h-7 w-7 items-center justify-center rounded-full bg-saffron text-xs font-black text-ink">2</span>
                            <div>
                                <p class="font-bold">Micro-apprentissage</p>
                                <p class="mt-1 text-xs text-white/60">Tu es ici</p>
                            </div>
                        </div>
                        <div class="flex gap-3 opacity-55"><span
                                class="flex h-7 w-7 items-center justify-center rounded-full border border-white/30 text-xs">3</span>
                            <div>
                                <p class="font-bold">Opportunité vérifiée</p>
                                <p class="mt-1 text-xs text-white/60">La prochaine connexion</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 h-1.5 rounded-full bg-white/15">
                        <div class="h-full w-2/3 rounded-full bg-saffron"></div>
                    </div>
                </aside>
            </div>
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-between"><button type="button"
                    wire:click="back"
                    class="order-2 text-sm font-bold text-ink/55 underline underline-offset-4 sm:order-1">{{ __('back') }}</button><button
                    type="button" wire:click="openNext"
                    class="order-1 rounded-xl bg-forest px-5 py-3 font-bold text-white shadow-lg shadow-forest/15 sm:order-2">Voir
                    l’opportunité <span aria-hidden="true">→</span></button></div>
        </div>
    @endif

    @if ($screen === 'next' && $opportunite)
        <div class="mx-auto max-w-4xl">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-terracotta">Étape 03 · agir</p>
                    <h2 class="display-title mt-2 text-4xl text-forest">{{ __('next.title') }}</h2>
                </div><span class="rounded-full bg-mint px-3 py-1.5 text-xs font-bold text-forest">Connexion
                    locale</span>
            </div>
            <div class="mt-7 grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
                <section class="app-panel overflow-hidden">
                    <div class="border-b border-ink/10 bg-mint/55 p-6 sm:p-8">
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-forest">Opportunité recommandée
                        </p>
                        <p class="mt-3 text-2xl font-black text-forest">{{ $opportunite->titre() }}</p>
                        <p class="mt-3 text-sm text-ink/65">Une action proche, avec un contact et des conditions que tu
                            peux vérifier.</p>
                    </div>
                    <dl class="grid gap-5 p-6 text-sm sm:grid-cols-2 sm:p-8">
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">
                                {{ __('next.place') }}</dt>
                            <dd class="mt-1 font-semibold">{{ $opportunite->lieu }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">
                                {{ __('next.contact') }}</dt>
                            <dd class="mt-1 font-semibold">{{ $opportunite->contact }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">
                                {{ __('next.eligibility') }}</dt>
                            <dd class="mt-1 font-semibold">{{ $opportunite->conditionEligibilite() }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">
                                {{ __('next.deadline') }}</dt>
                            <dd class="mt-1 font-semibold">{{ $opportunite->delai() }}</dd>
                        </div>
                        <div class="sm:col-span-2 border-t border-ink/10 pt-5">
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-ink/45">
                                {{ __('result.source') }}</dt>
                            <dd class="mt-1 font-semibold">{{ $opportunite->source }} —
                                {{ $opportunite->source_updated_on->format('d/m/Y') }}</dd>
                            <dd class="mt-2 font-bold text-forest">{{ __('result.status') }} :
                                {{ $opportunite->statutLabel() }}</dd>
                            @if ($opportunite->source_url)
                                <dd class="mt-1"><a href="{{ $opportunite->source_url }}" target="_blank"
                                        rel="noreferrer"
                                        class="font-bold text-terracotta underline underline-offset-4">{{ __('result.original_source') }}
                                        ↗</a></dd>
                            @endif
                        </div>
                        @if ($opportunite->sourceIsStale())
                            <p
                                class="sm:col-span-2 rounded-lg bg-terracotta/15 px-3 py-2 font-semibold text-terracotta">
                                {{ __('badge.verify') }}</p>
                        @endif
                    </dl>
                </section>
                <aside class="rounded-2xl bg-forest p-6 text-white sm:p-7">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-mint">Fiche de confiance</p><span
                            class="text-2xl text-saffron">✓</span>
                    </div>
                    <p class="mt-5 text-4xl font-black">
                        {{ $opportunite->sourceIsStale() ? 'À vérifier' : 'Vérifiée' }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-white/65">Ce statut repose sur une source identifiable,
                        une date de mise à jour et les informations publiées par l’organisme.</p>
                    <div class="mt-7 space-y-3 border-t border-white/10 pt-5 text-sm">
                        <p class="flex gap-2"><span class="text-saffron">✓</span> Organisme identifiable</p>
                        <p class="flex gap-2"><span class="text-saffron">✓</span> Contact publié</p>
                        <p class="flex gap-2"><span class="text-saffron">✓</span> Conditions visibles</p>
                    </div>
                </aside>
            </div>
            @if ($reportSent)
                <p class="mt-4 rounded bg-forest/10 px-3 py-2 text-sm text-forest">{{ __('report.sent') }}</p>
            @else
                <form wire:submit="reportOpportunity" class="mt-4 rounded-lg border border-ink/10 bg-white p-3">
                    <label class="text-sm font-medium" for="reportReason">{{ __('report.title') }}</label>
                    <select id="reportReason" wire:model="reportReason"
                        class="mt-2 w-full rounded border border-ink/20 px-3 py-2" required>
                        <option value="">{{ __('report.choose') }}</option>
                        <option value="expiree">{{ __('report.expired') }}</option>
                        <option value="contact_incorrect">{{ __('report.contact') }}</option>
                        <option value="conditions_incorrectes">{{ __('report.conditions') }}</option>
                        <option value="suspecte">{{ __('report.suspicious') }}</option>
                    </select>
                    <button type="submit" class="mt-3 text-sm underline">{{ __('report.submit') }}</button>
                </form>
            @endif
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-between"><button type="button"
                    wire:click="openSms"
                    class="rounded-xl border border-ink/15 bg-white px-5 py-3 font-bold hover:border-forest">{{ __('welcome.sms') }}</button><button
                    type="button" wire:click="restart"
                    class="text-sm font-bold text-ink/55 underline underline-offset-4">{{ __('next.restart') }}</button>
            </div>
        </div>
    @endif

    @if ($screen === 'sms')
        <h2 class="text-xl font-semibold">{{ __('sms.title') }}</h2>
        <p class="mt-2 text-sm text-ink/80">{{ __('sms.lead') }}</p>
        <div class="mx-auto mt-5 max-w-xs rounded-4xl border-8 border-ink bg-ink p-3">
            <div class="rounded-2xl bg-[#e5ffd8] p-3 text-sm text-ink">
                <p class="text-xs font-semibold text-forest">{{ __('sms.from') }}</p>
                @if ($competence && $opportunite)
                    <p class="mt-2">Jokalante: {{ $competence->nom() }}. {{ $opportunite->titre() }}.
                        {{ $opportunite->lieu }}. {{ $opportunite->contact }}. {{ $opportunite->delai() }}</p>
                @else
                    <p class="mt-2">Jokalante: Envoie DIAG au 2121 — 4 questions, 1 compétence, 1 lieu. Aucun nom
                        demandé.</p>
                @endif
            </div>
        </div>
        <button type="button" wire:click="start"
            class="mt-5 w-full rounded-lg bg-forest px-4 py-3 text-white">{{ __('welcome.cta') }}</button>
        <button type="button" wire:click="back" class="mt-3 text-sm underline">{{ __('back') }}</button>
    @endif
</div>
