<div class="flex gap-1 text-sm" role="group" aria-label="Langue">
    <button type="button" wire:click="setLocale('fr')" class="rounded px-2 py-1 {{ app()->getLocale() === 'fr' ? 'bg-forest text-white' : 'bg-cream text-ink' }}">
        {{ __('lang.fr') }}
    </button>
    <button type="button" wire:click="setLocale('wo')" class="rounded px-2 py-1 {{ app()->getLocale() === 'wo' ? 'bg-forest text-white' : 'bg-cream text-ink' }}">
        {{ __('lang.wo') }}
    </button>
</div>
