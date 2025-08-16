<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (function () {
            const appearance = '{{ $appearance ?? "system" }}';
            if (appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        html { background-color: oklch(1 0 0); }
        html.dark { background-color: oklch(0.145 0 0); }
    </style>

    @php
        $siteName     = config('app.name', 'Choreli');
        $defaultTitle = 'Choreli — Track chores. Earn points. Get rewards.';
        $description  = 'Choreli makes chores fun: complete tasks, earn points, and redeem rewards. Great for families, roommates, and teams.';
        $imageUrl     = asset('img/choreli-mark.png'); // your logo
        $canonical    = url()->current();
    @endphp

    {{-- Absolute canonical for crawlers --}}
    <link rel="canonical" href="{{ $canonical }}"/>

    {{-- Favicon / icons --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    {{-- DEFAULT SEO (pages may override with <Head>) --}}
    <title>{{ $defaultTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="index,follow">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta property="og:title" content="{{ $defaultTitle }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $imageUrl }}">
    <meta property="og:image:alt" content="Choreli logo">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $defaultTitle }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $imageUrl }}">
    {{-- <meta name="twitter:site" content="@yourhandle"> --}}

    {{-- Browser theme color (light/dark aware) --}}
    <meta name="theme-color" content="#e6f2ff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0a0a0a" media="(prefers-color-scheme: dark)">

    @routes
    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
