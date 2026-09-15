<div class="page-reveal">
    @if (!$learner || !$diagnostic || !$competence)
        <section class="mx-auto max-w-3xl rounded-3xl bg-forest p-8 text-white sm:p-12">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-mint">Mon parcours</p>
            <h1 class="display-title mt-4 text-4xl leading-tight sm:text-5xl">Ton tableau de bord commence avec ton
                diagnostic.</h1>
            <p class="mt-5 max-w-xl leading-relaxed text-white/70">Réponds à quelques questions pour obtenir une piste,
                une roadmap et une prochaine action adaptée à ta situation.</p>
            <a href="{{ route('home') }}"
                class="mt-8 inline-flex rounded-xl bg-saffron px-5 py-3 font-bold text-ink">Lancer mon diagnostic <span
                    class="ml-2">→</span></a>
        </section>
    @else
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-terracotta">Espace utilisateur</p>
                <h1 class="display-title mt-2 text-4xl text-forest sm:text-5xl">Mon parcours</h1>
                <p class="mt-3 text-ink/65">Une vue simple de ta direction, de tes progrès et de la prochaine action.
                </p>
            </div>
            <a href="{{ route('home') }}"
                class="rounded-xl border border-ink/15 bg-white px-4 py-2.5 text-sm font-bold text-ink/70 hover:border-forest hover:text-forest">Refaire
                le diagnostic</a>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="app-panel overflow-hidden bg-forest text-white">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-saffron">Objectif actuel</p>
                            <h2 class="mt-3 text-3xl font-black">{{ $competence->nom() }}</h2>
                        </div><span
                            class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-bold">{{ __('niveau.' . $competence->niveau) }}</span>
                    </div>
                    <p class="mt-4 max-w-2xl leading-relaxed text-white/70">
                        {{ $diagnostic->analyse_ia['profile_summary'] ?? $competence->description() }}</p>
                    <div class="mt-8 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-4xl font-black">{{ $progressPercent }}%</p>
                            <p class="text-xs text-white/60">{{ $completedSteps }} étape(s) terminée(s) sur
                                {{ $steps->count() }}</p>
                        </div>
                        <div class="w-1/2">
                            <div class="h-2 rounded-full bg-white/15">
                                <div class="h-full rounded-full bg-saffron" style="width: {{ $progressPercent }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-px bg-white/10">
                    <div class="bg-forest p-5"><span
                            class="block text-2xl font-black">{{ count($diagnostic->analyse_ia['strengths'] ?? []) }}</span><span
                            class="text-xs text-white/60">forces détectées</span></div>
                    <div class="bg-forest p-5"><span
                            class="block text-2xl font-black">{{ count($diagnostic->analyse_ia['skills_to_develop'] ?? []) }}</span><span
                            class="text-xs text-white/60">compétences à développer</span></div>
                    <div class="bg-saffron p-5 text-ink"><span
                            class="block text-2xl font-black">{{ $savedOpportunities->count() }}</span><span
                            class="text-xs">opportunités sauvegardées</span></div>
                </div>
            </section>

            <aside class="app-panel p-6 sm:p-7">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-terracotta">Pourquoi cette piste ?</p>
                <p class="mt-3 text-lg font-black text-forest">
                    {{ $diagnostic->analyse_ia['reason'] ?? 'Une piste adaptée à ton profil et au catalogue local.' }}
                </p>
                <div class="mt-5 space-y-2 text-sm text-ink/65">
                    @foreach ($diagnostic->analyse_ia['strengths'] ?? [] as $strength)
                        <p class="flex gap-2"><span class="font-bold text-forest">✓</span>{{ $strength }}</p>
                    @endforeach
                </div>
            </aside>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
            <section class="app-panel p-6 sm:p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-forest">Roadmap personnalisée</p>
                        <h2 class="mt-2 text-2xl font-black text-forest">Les prochaines étapes</h2>
                    </div><span
                        class="rounded-full bg-mint px-3 py-1.5 text-xs font-bold text-forest">{{ $steps->count() }}
                        étapes</span>
                </div>
                <div class="mt-7 space-y-4">
                    @forelse ($steps as $step)
                        <div class="flex gap-4 rounded-xl border border-ink/10 p-4"><button type="button"
                                wire:click="toggleStep({{ $step->id }})"
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2 {{ ($progress[$step->id]->statut ?? '') === 'termine' ? 'border-forest bg-forest text-white' : 'border-ink/20 text-transparent' }}">✓</button>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col justify-between gap-1 sm:flex-row">
                                    <h3
                                        class="font-bold {{ ($progress[$step->id]->statut ?? '') === 'termine' ? 'text-ink/45 line-through' : 'text-forest' }}">
                                        {{ $step->titre() }}</h3><span
                                        class="text-xs font-semibold text-ink/45">{{ $step->duree_minutes }} min</span>
                                </div>
                                <p class="mt-1 text-sm leading-relaxed text-ink/60">{{ $step->description() }}</p>
                            </div>
                    </div>@empty<p class="rounded-xl bg-cream p-4 text-sm text-ink/60">La roadmap sera disponible
                            dès que le catalogue aura ses étapes.</p>
                    @endforelse
                </div>
            </section>

            <aside class="space-y-6">
                @if ($opportunity)
                    <section class="rounded-2xl border border-forest/15 bg-mint/70 p-6">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-forest">Prochaine action</p>
                            <span class="text-xl text-terracotta">→</span>
                        </div>
                        <h2 class="mt-3 text-xl font-black text-forest">{{ $opportunity->titre() }}</h2>
                        <p class="mt-2 text-sm text-ink/65">{{ $opportunity->lieu }}</p>
                        <p class="mt-3 text-xs font-semibold text-ink/55">{{ $opportunity->delai() }}</p>
                        <div class="mt-5 flex gap-2"><a href="{{ $opportunity->source_url ?: '#' }}" target="_blank"
                                rel="noopener noreferrer"
                                class="rounded-lg bg-forest px-4 py-2.5 text-sm font-bold text-white">Voir les
                                conditions</a><button type="button"
                                wire:click="toggleSavedOpportunity({{ $opportunity->id }})"
                                class="rounded-lg border border-forest px-4 py-2.5 text-sm font-bold text-forest">Sauvegarder</button>
                        </div>
                    </section>
                @endif
                <section class="app-panel p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-terracotta">Mes opportunités</p>
                    <h2 class="mt-2 text-xl font-black text-forest">À garder sous la main</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($savedOpportunities as $saved)
                            <div class="rounded-xl border border-ink/10 p-3">
                                <p class="text-sm font-bold text-forest">{{ $saved->opportunite->titre() }}</p>
                                <p class="mt-1 text-xs text-ink/55">{{ $saved->opportunite->lieu }}</p><button
                                    type="button" wire:click="toggleSavedOpportunity({{ $saved->opportunite_id }})"
                                    class="mt-2 text-xs font-bold text-terracotta underline">Retirer</button>
                        </div>@empty<p class="text-sm leading-relaxed text-ink/55">Sauvegarde une opportunité depuis
                                cette page pour la retrouver ici.</p>
                        @endforelse
                    </div>
                </section>
            </aside>
        </div>
    @endif
</div>
