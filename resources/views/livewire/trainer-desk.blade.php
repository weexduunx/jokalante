<div>
    <h1 class="text-2xl font-semibold">{{ __('trainer.title') }}</h1>
    <p class="mt-2 text-ink/80">{{ __('trainer.lead') }}</p>

    @if ($saved)
        <p class="mt-3 rounded bg-forest/10 px-3 py-2 text-forest">{{ __('trainer.saved') }}</p>
    @endif

    <h2 class="mt-6 font-semibold">{{ __('content.flagged') }}</h2>
    <ul class="mt-3 space-y-3">
        @foreach ($competences as $competence)
            @foreach ($competence->contenus as $contenu)
                <li class="rounded-lg bg-white p-3 text-sm">
                    <p class="font-medium">{{ $competence->nom() }}</p>
                    <p class="text-ink/60">{{ $contenu->source }}</p>
                    <button type="button" wire:click="flag({{ $contenu->id }})" class="mt-2 rounded border border-ink/20 px-3 py-1">
                        {{ $contenu->signale_obsolete ? __('trainer.unflag') : __('trainer.flag') }}
                    </button>
                </li>
            @endforeach
        @endforeach
    </ul>

    <h2 class="mt-8 font-semibold">{{ __('trainer.add') }}</h2>
    <form wire:submit="addOpportunity" class="mt-3 space-y-3 rounded-lg bg-white p-4">
        <select wire:model="competence_id" class="w-full rounded border border-ink/20 px-3 py-2" required>
            <option value="">—</option>
            @foreach ($competences as $competence)
                <option value="{{ $competence->id }}">{{ $competence->nom() }}</option>
            @endforeach
        </select>
        <input wire:model="titre_fr" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="Titre (FR)" required>
        <input wire:model="titre_wo" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="Titre (WO)">
        <input wire:model="lieu" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="{{ __('next.place') }}" required>
        <input wire:model="contact" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="{{ __('next.contact') }}" required>
        <textarea wire:model="condition_fr" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="{{ __('next.eligibility') }}" required></textarea>
        <input wire:model="delai_fr" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="{{ __('next.deadline') }}" required>
        <input wire:model="source" class="w-full rounded border border-ink/20 px-3 py-2" placeholder="{{ __('result.source') }}" required>
        <button type="submit" class="w-full rounded-lg bg-forest px-4 py-3 text-white">{{ __('trainer.add') }}</button>
    </form>
</div>
