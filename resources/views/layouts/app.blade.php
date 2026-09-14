<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1F4D3A">
    <title>{{ $title ?? 'Jokalante' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream text-ink antialiased">
    <header class="border-b border-ink/10 bg-white">
        <div class="mx-auto flex max-w-lg items-center justify-between gap-3 px-4 py-3">
            <a href="{{ route('home') }}" class="font-semibold tracking-tight text-forest">Jokalante</a>
            <div class="flex items-center gap-3 text-sm">
                <livewire:language-switcher />
                <a href="{{ route('trainer') }}" class="text-ink/70 underline-offset-2 hover:underline">{{ __('nav.trainer') }}</a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-lg px-4 py-6">
        {{ $slot }}
    </main>

    <footer class="mx-auto max-w-lg px-4 pb-8 text-xs text-ink/60">
        <p>{{ __('privacy') }}</p>
        <p class="mt-1">{{ __('app.zone') }}</p>
    </footer>
</body>
</html>
