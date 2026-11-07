<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'P-TAMS')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandNavy: '#0F1E36',
                        brandBlueActive: '#172B4D',
                        brandSidebarBg: '#FFFFFF',
                        brandBodyBg: '#F8FAFC',
                        brandBorder: '#E2E8F0',
                        brandTextDark: '#1E293B',
                        brandMuted: '#64748B',
                        brandLightBlueBg: '#F0F5FA',
                        brandRedAction: '#B91C1C'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', '-apple-system', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="min-h-screen bg-[#F8FAFC] font-sans text-slate-800 antialiased">
    @yield('content')

    <script src="{{ asset('js/tickets.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
