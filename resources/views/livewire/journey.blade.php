<div>
    @php
        $steps = ['diagnostic' => 1, 'result' => 1, 'content' => 2, 'next' => 3, 'sms' => 3];
        $current = $steps[$screen] ?? 0;
    @endphp

    @if ($current)
        <ol class="mb-5 flex gap-2 text-xs font-medium">
            <li class="flex-1 rounded px-2 py-1 {{ $current >= 1 ? 'bg-forest text-white' : 'bg-white text-ink/50' }}">1. {{ __('step.diagnostic') }}</li>
            <li class="flex-1 rounded px-2 py-1 {{ $current >= 2 ? 'bg-forest text-white' : 'bg-white text-ink/50' }}">2. {{ __('step.content') }}</li>
            <li class="flex-1 rounded px-2 py-1 {{ $current >= 3 ? 'bg-forest text-white' : 'bg-white text-ink/50' }}">3. {{ __('step.next') }}</li>
        </ol>
    @endif

    @if ($screen === 'welcome')
        <h1 class="text-2xl font-semibold leading-tight">{{ __('welcome.title') }}</h1>
        <p class="mt-3 text-ink/80">{{ __('welcome.lead') }}</p>
        <p class="mt-2 text-sm text-terracotta">{{ __('app.tagline') }}</p>
        <div class="mt-6 flex flex-col gap-3">
            <button type="button" wire:click="start" class="rounded-lg bg-forest px-4 py-3 text-white">{{ __('welcome.cta') }}</button>
            <button type="button" wire:click="openSms" class="rounded-lg border border-ink/20 bg-white px-4 py-3">{{ __('welcome.sms') }}</button>
        </div>
    @endif

    @if ($screen === 'diagnostic')
        @php $q = $questions[$question]; @endphp
        <p class="text-sm text-ink/60">{{ $question + 1 }} / 4</p>
        <h2 class="mt-1 text-xl font-semibold">{{ $q['label'] }}</h2>
        <div class="mt-4 flex flex-col gap-2">
            @foreach ($q['options'] as $value => $label)
                <button type="button" wire:click="answer('{{ $q['field'] }}', '{{ $value }}')" class="rounded-lg border border-ink/15 bg-white px-4 py-3 text-left hover:border-forest">
                    {{ $label }}
                </button>
            @endforeach
        </div>
        <button type="button" wire:click="back" class="mt-4 text-sm underline">{{ __('back') }}</button>
    @endif

    @if ($screen === 'result' && $competence)
        <h2 class="text-xl font-semibold">{{ __('result.title') }}</h2>
        <p class="mt-2 text-2xl text-forest">{{ $competence->nom() }}</p>
        <p class="mt-2">{{ $competence->description() }}</p>
        <p class="mt-3 text-sm">{{ __('result.why', ['count' => $competence->demande_locale]) }}</p>
        <div class="mt-4 rounded-lg bg-white p-3 text-sm">
            <p><span class="font-medium">{{ __('result.source') }} :</span> {{ $competence->justification_source }}</p>
            <p class="mt-1">{{ __('result.updated') }} {{ $competence->source_updated_on->format('d/m/Y') }}</p>
            @if ($competence->sourceIsStale())
                <p class="mt-2 inline-block rounded bg-terracotta/15 px-2 py-1 text-terracotta">{{ __('badge.verify') }}</p>
            @else
                <p class="mt-2 inline-block rounded bg-forest/10 px-2 py-1 text-forest">{{ __('badge.ok') }}</p>
            @endif
        </div>
        <button type="button" wire:click="openContent" class="mt-5 w-full rounded-lg bg-forest px-4 py-3 text-white">{{ __('next') }}</button>
        <button type="button" wire:click="back" class="mt-3 text-sm underline">{{ __('back') }}</button>
    @endif

    @if ($screen === 'content' && $competence && $contenu)
        <p class="text-sm">{{ __('content.level') }} : {{ __('niveau.'.$competence->niveau) }}</p>
        <h2 class="mt-1 text-xl font-semibold">{{ $competence->nom() }}</h2>
        <p class="mt-2 text-sm text-ink/70">{{ __('content.not_a_course') }}</p>
        @if ($contenu->signale_obsolete)
            <p class="mt-2 rounded bg-terracotta/15 px-2 py-1 text-sm text-terracotta">{{ __('content.flagged') }}</p>
        @endif
        <div class="mt-4 whitespace-pre-line rounded-lg bg-white p-4 leading-relaxed">{{ $contenu->corps() }}</div>
        <p class="mt-2 text-xs text-ink/50">{{ $contenu->source }} · {{ $contenu->updated_at->format('d/m/Y') }}</p>
        <button
            type="button"
            class="mt-4 rounded-lg border border-forest px-4 py-2 text-forest"
            data-audio="{{ e($contenu->scriptAudio()) }}"
            onclick="window.jokalanteSpeak(this)"
        >{{ __('listen') }}</button>
        <button type="button" wire:click="openNext" class="mt-4 w-full rounded-lg bg-forest px-4 py-3 text-white">{{ __('next') }}</button>
        <button type="button" wire:click="back" class="mt-3 text-sm underline">{{ __('back') }}</button>
    @endif

    @if ($screen === 'next' && $opportunite)
        <h2 class="text-xl font-semibold">{{ __('next.title') }}</h2>
        <p class="mt-2 text-lg text-forest">{{ $opportunite->titre() }}</p>
        <dl class="mt-4 space-y-3 rounded-lg bg-white p-4 text-sm">
            <div>
                <dt class="font-medium">{{ __('next.place') }}</dt>
                <dd>{{ $opportunite->lieu }}</dd>
            </div>
            <div>
                <dt class="font-medium">{{ __('next.contact') }}</dt>
                <dd>{{ $opportunite->contact }}</dd>
            </div>
            <div>
                <dt class="font-medium">{{ __('next.eligibility') }}</dt>
                <dd>{{ $opportunite->conditionEligibilite() }}</dd>
            </div>
            <div>
                <dt class="font-medium">{{ __('next.deadline') }}</dt>
                <dd>{{ $opportunite->delai() }}</dd>
            </div>
            <div>
                <dt class="font-medium">{{ __('result.source') }}</dt>
                <dd>{{ $opportunite->source }} — {{ $opportunite->source_updated_on->format('d/m/Y') }}</dd>
            </div>
            @if ($opportunite->sourceIsStale())
                <p class="rounded bg-terracotta/15 px-2 py-1 text-terracotta">{{ __('badge.verify') }}</p>
            @endif
        </dl>
        <button type="button" wire:click="openSms" class="mt-4 w-full rounded-lg border border-ink/20 bg-white px-4 py-3">{{ __('welcome.sms') }}</button>
        <button type="button" wire:click="restart" class="mt-3 w-full text-sm underline">{{ __('next.restart') }}</button>
    @endif

    @if ($screen === 'sms')
        <h2 class="text-xl font-semibold">{{ __('sms.title') }}</h2>
        <p class="mt-2 text-sm text-ink/80">{{ __('sms.lead') }}</p>
        <div class="mx-auto mt-5 max-w-xs rounded-[2rem] border-8 border-ink bg-ink p-3">
            <div class="rounded-2xl bg-[#e5ffd8] p-3 text-sm text-ink">
                <p class="text-xs font-semibold text-forest">{{ __('sms.from') }}</p>
                @if ($competence && $opportunite)
                    <p class="mt-2">Jokalante: {{ $competence->nom() }}. {{ $opportunite->titre() }}. {{ $opportunite->lieu }}. {{ $opportunite->contact }}. {{ $opportunite->delai() }}</p>
                @else
                    <p class="mt-2">Jokalante: Envoie DIAG au 2121 — 4 questions, 1 compétence, 1 lieu. Aucun nom demandé.</p>
                @endif
            </div>
        </div>
        <button type="button" wire:click="start" class="mt-5 w-full rounded-lg bg-forest px-4 py-3 text-white">{{ __('welcome.cta') }}</button>
        <button type="button" wire:click="back" class="mt-3 text-sm underline">{{ __('back') }}</button>
    @endif
</div>
