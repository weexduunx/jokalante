<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1F4D3A">
    <title>{{ $title ?? 'Jokalante' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen text-ink antialiased">
    <header class="border-b border-ink/10 bg-cream/80 sticky top-0 z-50 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 ">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-forest text-lg font-black text-white shadow-lg shadow-forest/15">J</span>
                <span>
                    <span class="block text-lg font-black tracking-tight text-forest">Jokalante</span>
                    <span
                        class="hidden text-[10px] font-semibold uppercase tracking-[0.18em] text-ink/50 sm:block">Créer
                        la connexion</span>
                </span>
            </a>
            <div class="flex items-center gap-3 text-sm">
                <livewire:language-switcher />
                <a href="{{ route('dashboard') }}"
                    class="hidden rounded-full border border-ink/15 bg-white/60 px-4 py-2 font-semibold text-ink/70 hover:border-forest hover:text-forest sm:inline-flex">Mon
                    parcours</a>
                <a href="{{ route('trainer') }}"
                    class="hidden rounded-full border border-ink/15 bg-white/60 px-4 py-2 font-semibold text-ink/70 hover:border-forest hover:text-forest sm:inline-flex">{{ __('nav.trainer') }}</a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:py-10">
        {{ $slot }}
    </main>

    <footer
        class="mx-auto flex max-w-6xl flex-col gap-1 px-4 pb-8 text-xs text-ink/60 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <p>{{ __('privacy') }}</p>
        <p>{{ __('app.zone') }}</p>
    </footer>
</body>

</html>
