<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Detail Laporan Kerusakan &amp; Monitoring Servis - P-TAMS</title>
<!-- Tailwind CSS CDN with forms and container queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f0f7ff',
              100: '#e0effe',
              500: '#0284c7',
              600: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
              dark: '#0b192c',
              navy: '#0f172a'
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif']
          }
        }
      }
    }
  </script>
<style data-purpose="custom-styling">
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    /* Timeline connecting line */
    .timeline-line::before {
      content: '';
      position: absolute;
      top: 28px;
      bottom: -16px;
      left: 17px;
      width: 2px;
      background-color: #e2e8f0;
      z-index: 0;
    }
    .timeline-item:last-child .timeline-line::before {
      display: none;
    }
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex flex-col">
<!-- BEGIN: MobileSidebarBackdrop -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300" id="sidebar-backdrop" onclick="toggleSidebar()"></div>
<!-- END: MobileSidebarBackdrop -->
<div class="flex flex-1 min-h-screen">
<!-- BEGIN: LeftSidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col justify-between p-6 transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shrink-0" id="main-sidebar">
<div class="space-y-8">
<!-- Logo Header -->
<div class="flex items-center justify-between">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center text-white font-black text-lg tracking-tighter">
<span class="inline-block transform -rotate-12">P</span>
</div>
<span class="font-extrabold text-xl tracking-tight text-slate-900">P-TAMS</span>
</div>
<button class="lg:hidden text-slate-400 hover:text-slate-600 focus:outline-none" onclick="toggleSidebar()">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
</div>
<!-- Navigation Links -->
<nav aria-label="Menu Utama" class="space-y-1.5">
<a class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
<span>Perangkat saya</span>
</a>
<!-- Active Menu Item: Tiket Saya -->
<a class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg bg-[#0b1b33] text-white font-medium text-sm shadow-sm transition-all" href="#">
<svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span>Tiket Saya</span>
</a>
<a class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
<span>Buat Tiket</span>
</a>
<a class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-rose-600 hover:bg-rose-50 font-medium text-sm transition-colors pt-2" href="#">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span>Logout</span>
</a>
</nav>
</div>
<!-- Scan QR Promo Card in Sidebar -->
<div class="mt-8 rounded-xl bg-[#0b192c] p-4 text-white text-left shadow-lg">
<div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mb-3">
<svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<h4 class="font-bold text-sm text-white">Scan QR Perangkat</h4>
<p class="text-[11px] text-slate-300 mt-1 leading-relaxed">
          Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.
        </p>
<button class="w-full mt-3 py-2 bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-100 rounded-lg border border-slate-700 transition" onclick="openScanModal()">
          Mulai Scan QR
        </button>
</div>
</aside>
<!-- END: LeftSidebar -->
<!-- BEGIN: MainContentArea -->
<div class="flex-1 flex flex-col min-w-0">
<!-- BEGIN: TopBar -->
<header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between gap-4 sticky top-0 z-30">
<div class="flex items-center gap-3 flex-1 max-w-xl">
<button class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100" onclick="toggleSidebar()">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
<!-- Search Bar -->
<div class="relative w-full">
<span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</span>
<input class="w-full pl-9 pr-4 py-1.5 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" placeholder="Lakukan pencarian..." type="text"/>
</div>
</div>
<!-- Top Right Actions: Bell & Profile -->
<div class="flex items-center gap-4 sm:gap-6">
<button class="relative text-slate-500 hover:text-slate-700 focus:outline-none">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
</button>
<!-- User Card -->
<div class="flex items-center gap-2.5">
<img alt="Avatar Fikri" class="w-8 h-8 rounded-full object-cover border border-slate-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlZRxaRuE_mCr73d69iO8dQfeMp0Rov6T0w7NxF5D2HgYeSAfVrRYMLAfO7uLl6HtVCwOSicdYOW63vxfny3yeOcVjfOwYVgvznV4bj36uapb1bMboClh3vZgivxjW6DIWPnVmzs6HQsYiFq6ya2X7zIjUAGnYSbZ5nIlwIJmcjhz84WXjWhdmvw107p3G71rhisloEq3f537j1aQqzX3Y2E4CH7orjM8l7YjOyAc"/>
<div class="hidden sm:block text-left">
<p class="text-xs font-bold text-slate-800 leading-tight">Fikri</p>
<p class="text-[10px] text-slate-400 leading-tight">Admin</p>
</div>
</div>
</div>
</header>
<!-- END: TopBar -->
<!-- Main Body Container -->
<main class="p-4 sm:p-8 max-w-[1400px] w-full mx-auto space-y-6">
<!-- BEGIN: PageHeading -->
<div class="space-y-4">
<!-- Back button -->
<button class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-[#0d1d33] text-white text-xs font-semibold hover:bg-slate-800 transition" onclick="window.history.back()">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span>Tiket Saya</span>
</button>
<!-- Title & Badges Row -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
<div>
<h1 class="text-2xl sm:text-3xl font-extrabold text-[#091b34] tracking-tight">Detail Laporan Kerusakan &amp; Monitoring Servis</h1>
<p class="text-xs sm:text-sm text-slate-500 mt-1">Lacak tahapan perbaikan, verifikasi suku cadang , dan perbaruan teknisi langsung dari sistem Pusat</p>
</div>
<!-- Status & Priority Badges -->
<div class="flex flex-wrap items-center gap-2 sm:gap-3">
<div class="bg-white px-3.5 py-2 rounded-lg border border-slate-200 shadow-sm flex flex-col justify-center">
<span class="text-[9px] uppercase tracking-wider font-bold text-slate-400">STATUS SAAT INI</span>
<div class="flex items-center gap-1.5 mt-0.5">
<span class="w-2 h-2 rounded-full bg-amber-500"></span>
<span class="text-xs font-bold text-amber-600">Sedang Diproses</span>
</div>
</div>
<div class="bg-white px-3.5 py-2 rounded-lg border border-slate-200 shadow-sm flex flex-col justify-center">
<span class="text-[9px] uppercase tracking-wider font-bold text-slate-400">PRIORITAS</span>
<div class="flex items-center gap-1.5 mt-0.5">
<span class="w-2 h-2 rounded-full bg-rose-600"></span>
<span class="text-xs font-bold text-rose-600">Tinggi (UrgentSLA)</span>
</div>
</div>
</div>
</div>
</div>
<!-- END: PageHeading -->
<!-- BEGIN: 2ColumnGrid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
<!-- ================= LEFT COLUMN (8 cols) ================= -->
<div class="lg:col-span-8 space-y-6">
<!-- 1. Dark Ticket Banner Card -->
<div class="bg-[#0b192c] rounded-2xl p-6 sm:p-7 text-white shadow-md relative overflow-hidden flex flex-col md:flex-row justify-between md:items-center gap-6">
<div class="flex items-start gap-4">
<div class="w-12 h-12 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center shrink-0">
<svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
</div>
<div>
<h3 class="text-sm font-semibold text-slate-200">Nomor Registrasi Tiket</h3>
<p class="text-xs text-slate-400 mt-0.5">Kategori : Hardware / Output Device / Printer</p>
<p class="text-3xl font-extrabold tracking-tight mt-2 text-white">#TC-024</p>
<p class="text-[11px] text-slate-400 mt-2">Kerusakan dilaporkan oleh Granitul (Divisi Bendahara)<br class="hidden sm:inline"/> pada 12 oktober 2026, 10:00 WIB</p>
</div>
</div>
<!-- Status inside dark card -->
<div class="bg-slate-900/90 border border-slate-700/80 rounded-xl p-4 md:w-60 shrink-0">
<div class="flex items-center gap-1.5 justify-start md:justify-center">
<span class="text-[10px] font-bold text-slate-300 uppercase tracking-wide">TAHAP PENANGANAN</span>
<span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
</div>
<p class="text-xs font-bold text-white text-left md:text-center mt-1">Tahap 3 dari 4 (Perbaikan Fisik)</p>
<p class="text-[10px] text-slate-400 text-left md:text-center mt-1">Estimasi penguji operasional: ~2 jam</p>
</div>
</div>
<!-- 2. Spesifikasi & Informasi Lengkap Laporan Card -->
<div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-6">
<div class="flex flex-col sm:flex-row sm:items-center gap-4">
<!-- Isometric Laptop SVG Graphic -->
<div class="w-20 h-16 shrink-0 flex items-center justify-center">
<svg class="w-full h-full text-blue-500" fill="none" viewbox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
<rect fill="#93c5fd" height="42" rx="4" stroke="#3b82f6" stroke-width="2" width="65" x="25" y="15"></rect>
<rect fill="#eff6ff" height="32" rx="2" width="55" x="30" y="20"></rect>
<path d="M40 32h15v12H40z" fill="#60a5fa"></path>
<path d="M60 30h20m-20 6h16m-16 6h12" stroke="#3b82f6" stroke-linecap="round" stroke-width="2"></path>
<path d="M15 58h85l8 12H7l8-12z" fill="#bfdbfe" stroke="#3b82f6" stroke-width="2"></path>
<rect fill="#3b82f6" height="4" rx="2" width="30" x="42" y="60"></rect>
<circle cx="85" cy="30" fill="#1e40af" fill-opacity="0.85" r="14"></circle>
<path d="M85 22v16m-8-8h16" stroke="white" stroke-linecap="round" stroke-width="2"></path>
</svg>
</div>
<div>
<h2 class="text-lg font-bold text-slate-900">Spesifikasi &amp; Informasi Lengkap Laporan</h2>
<p class="text-xs text-slate-400 mt-0.5">Data terverifikasi otomatis dari master basis data aset P-TAMS</p>
</div>
</div>
<!-- 3 Info Sub-cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<!-- Subcard 1: Nama Perangkat -->
<div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col justify-between">
<div class="flex items-center gap-2 text-slate-700">
<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-xs font-medium">Nama Perangkat</span>
</div>
<div class="mt-3">
<h3 class="font-bold text-sm text-slate-900">Laptop Acer</h3>
<p class="text-[11px] text-slate-500"># Serial No: <span class="font-semibold text-slate-700">ACR-Aspire-7729X</span></p>
<span class="inline-block mt-2 px-2 py-0.5 text-[10px] font-bold text-sky-700 bg-sky-100 rounded">Hardware</span>
</div>
</div>
<!-- Subcard 2: Lokasi Perangkat -->
<div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col justify-between">
<div class="text-slate-700">
<span class="text-xs font-medium">Lokasi Perangkat</span>
</div>
<div class="mt-3">
<h3 class="font-bold text-sm text-slate-900">Ruang Meeting A</h3>
<p class="text-[11px] text-slate-400 mt-1 leading-snug">Gedung utama lantai 3 - operasional</p>
</div>
</div>
<!-- Subcard 3: Nama Pelapor -->
<div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col justify-between">
<div class="flex items-center gap-2 text-slate-700">
<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-xs font-medium">Nama Pelapor</span>
</div>
<div class="mt-3">
<h3 class="font-bold text-sm text-slate-900">Budi Pratama</h3>
<p class="text-[11px] text-slate-500 mt-1">NIP : <span class="font-medium text-slate-700">1999999999</span></p>
</div>
</div>
</div>
</div>
<!-- 3. Isi Laporan / Keluhan Card -->
<div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-6">
<div>
<h2 class="text-lg font-bold text-slate-900">Isi Laporan / Keluhan</h2>
<p class="text-xs text-slate-400 mt-0.5">Detail keluhan teknis dan catatan kendala operasional yang dilaporkan oleh pengguna</p>
</div>
<!-- Deskripsi Masalah Box -->
<div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-3">
<div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center shrink-0 mt-0.5">
<span class="text-xs font-bold">!</span>
</div>
<div class="space-y-1">
<h3 class="text-xs font-bold text-slate-800">Deskripsi Masalah</h3>
<p class="text-xs text-slate-600 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.
                  </p>
</div>
</div>
<!-- Lampiran Berkas Pendukung -->
<div class="space-y-3">
<div class="flex items-center gap-2 text-slate-800 font-bold text-xs">
<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span>Lampiran Berkas Pendukung</span>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
<!-- File item -->
<div class="flex items-center justify-between p-3 rounded-xl border border-slate-200 bg-slate-50">
<div class="flex items-center gap-3">
<div class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 border border-teal-200 flex items-center justify-center">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<p class="text-xs font-bold text-slate-800">Lampiran Berkas Pendukung</p>
<p class="text-[10px] text-slate-400">2.4 MB</p>
</div>
</div>
</div>
<!-- Image Placeholder Box -->
<div class="h-28 rounded-xl bg-slate-200/70 border border-dashed border-slate-300 flex items-center justify-center">
<svg class="w-8 h-8 text-slate-400" fill="currentColor" viewbox="0 0 24 24"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm1 2v10h14V7H5zm2 8l3-3.86 2.14 2.58 3-3.86L17 15H7z"></path></svg>
</div>
</div>
</div>
</div>
<!-- 4. Riwayat & Alur Penanganan Servis (Timeline) -->
<div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-6">
<div class="flex items-center gap-4">
<div class="w-16 h-14 shrink-0 flex items-center justify-center">
<svg class="w-full h-full text-blue-500" fill="none" viewbox="0 0 120 100" xmlns="http://www.w3.org/2000/svg">
<rect fill="#93c5fd" height="42" rx="4" stroke="#3b82f6" stroke-width="2" width="65" x="25" y="15"></rect>
<rect fill="#eff6ff" height="32" rx="2" width="55" x="30" y="20"></rect>
<path d="M15 58h85l8 12H7l8-12z" fill="#bfdbfe" stroke="#3b82f6" stroke-width="2"></path>
<circle cx="85" cy="30" fill="#2563eb" r="14"></circle>
<path d="M80 30l4 4 8-8" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<div>
<h2 class="text-lg font-bold text-slate-900">Riwayat &amp; Alur Penanganan Servis</h2>
<p class="text-xs text-slate-400 mt-0.5">Data terverifikasi otomatis dari master basis data aset P-TAMS</p>
</div>
</div>
<!-- Stepper List -->
<div class="space-y-4 pt-2">
<!-- Tahap 1 -->
<div class="relative flex items-start gap-4 timeline-item timeline-line">
<div class="w-8 h-8 rounded-full bg-emerald-50 border-2 border-emerald-500 flex items-center justify-center text-emerald-600 shrink-0 z-10 bg-white">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path></svg>
</div>
<div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl p-4">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
<div class="flex items-center gap-2">
<span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-700 rounded">TAHAP 1 • SELESAI</span>
<h4 class="text-xs font-bold text-slate-900">Laporan Dibuat &amp; Tiket Terbit</h4>
</div>
<span class="text-[11px] text-slate-400">12 Okt 2026 • 10:00 WIB</span>
</div>
<p class="text-[11px] text-slate-600 leading-relaxed mt-2">
                      Tiket berhasil diajukan melalui sistem pemindaian QR Code pada stiker aset printer oleh pelapor <strong class="text-slate-800">Budi Pratama</strong>. Sistem otomatis melakukan reservasi nomor antrean Helpdesk.
                    </p>
</div>
</div>
<!-- Tahap 2 -->
<div class="relative flex items-start gap-4 timeline-item timeline-line">
<div class="w-8 h-8 rounded-full bg-emerald-50 border-2 border-emerald-500 flex items-center justify-center text-emerald-600 shrink-0 z-10 bg-white">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path></svg>
</div>
<div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl p-4">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
<div class="flex items-center gap-2">
<span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-700 rounded">TAHAP 2 • SELESAI</span>
<h4 class="text-xs font-bold text-slate-900">Konfirmasi Kerusakan</h4>
</div>
<span class="text-[11px] text-slate-400">12 Okt 2026 • 10:00 WIB</span>
</div>
<p class="text-[11px] text-slate-600 leading-relaxed mt-2">
                      Kerusakan pada perangkat sedang dicek dan dikonfirmasi jikalau device mengalami kerusakan sesuai dengan apa yang dilaporkan. Kami akan segera memperbaiki perangkat. Mohon maaf atas ketidaknyamanannya
                    </p>
</div>
</div>
<!-- Tahap 3 (Active) -->
<div class="relative flex items-start gap-4 timeline-item timeline-line">
<div class="w-8 h-8 rounded-full bg-blue-900 border-2 border-blue-900 flex items-center justify-center text-white shrink-0 z-10">
<span class="w-2.5 h-2.5 rounded-full bg-white"></span>
</div>
<div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl p-4">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
<div class="flex items-center gap-2">
<span class="px-2 py-0.5 text-[10px] font-bold bg-blue-900 text-white rounded">TAHAP 3 • SEDANG BERJALAN</span>
<h4 class="text-xs font-bold text-slate-900">Proses</h4>
</div>
<span class="text-[11px] text-slate-400">12 Okt 2026 • 10:00 WIB</span>
</div>
<p class="text-[11px] text-slate-600 leading-relaxed mt-2">
                      Teknisi sedang melakukan pembongkaran roller penarik kertas (pickup roller), pembersihan sisa robekan kertas, kalibrasi sensor optical encoder, serta pencucian head nozzle printer.
                    </p>
</div>
</div>
<!-- Tahap 4 (Pending) -->
<div class="relative flex items-start gap-4 timeline-item">
<div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-slate-300 flex items-center justify-center text-slate-400 shrink-0 z-10 bg-white">
<span class="w-2 h-2 rounded-full bg-slate-300"></span>
</div>
<div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl p-4">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
<div class="flex items-center gap-2">
<span class="px-2 py-0.5 text-[10px] font-bold bg-slate-200 text-slate-600 rounded">TAHAP 4 • MENUNGGU</span>
<h4 class="text-xs font-bold text-slate-900">Selesai</h4>
</div>
<span class="text-[11px] text-slate-400">12 Okt 2026 • 10:00 WIB</span>
</div>
<p class="text-[11px] text-slate-400 leading-relaxed mt-1">
                      Menunggu pembaruan dari sisi admin
                    </p>
<div class="text-right mt-2">
<span class="text-[10px] font-semibold text-slate-400">Menunggu penyelesaian tahap 3</span>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- ================= RIGHT COLUMN (4 cols) ================= -->
<div class="lg:col-span-4 space-y-6">
<!-- 1. Ringkasan Validitas Tiket Card -->
<div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
<div class="flex items-center justify-between">
<h3 class="text-xs font-bold text-slate-800 tracking-wider uppercase">RINGKASAN VALIDITAS TIKET</h3>
<button class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-bold text-[10px] hover:bg-blue-200 transition" onclick="zoomQrModal()">PUBLIC QR</button>
</div>
<!-- QR Area -->
<div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center">
<!-- Authentic Stylized Vector QR Code -->
<div class="inline-block p-3 bg-white rounded-xl shadow-sm border border-slate-100 cursor-pointer" onclick="zoomQrModal()">
<svg class="w-36 h-36" fill="none" viewbox="0 0 140 140" xmlns="http://www.w3.org/2000/svg">
<!-- Corner Top Left -->
<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="10" y="10"></rect>
<rect fill="#1e293b" height="16" width="16" x="20" y="20"></rect>
<!-- Corner Top Right -->
<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="94" y="10"></rect>
<rect fill="#1e293b" height="16" width="16" x="104" y="20"></rect>
<!-- Corner Bottom Left -->
<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="10" y="94"></rect>
<rect fill="#1e293b" height="16" width="16" x="20" y="104"></rect>
<!-- Custom QR Matrix Dots -->
<rect fill="#1e293b" height="8" width="8" x="56" y="14"></rect>
<rect fill="#1e293b" height="8" width="10" x="74" y="14"></rect>
<rect fill="#1e293b" height="8" width="16" x="56" y="32"></rect>
<rect fill="#1e293b" height="18" width="6" x="80" y="32"></rect>
<rect fill="#1e293b" height="8" width="12" x="20" y="56"></rect>
<rect fill="#1e293b" height="8" width="18" x="42" y="56"></rect>
<rect fill="#1e293b" height="18" width="8" x="70" y="56"></rect>
<rect fill="#1e293b" height="8" width="18" x="88" y="56"></rect>
<rect fill="#1e293b" height="8" width="14" x="116" y="56"></rect>
<rect fill="#1e293b" height="8" width="18" x="14" y="74"></rect>
<rect fill="#1e293b" height="18" width="8" x="42" y="74"></rect>
<rect fill="#1e293b" height="8" width="18" x="60" y="80"></rect>
<rect fill="#1e293b" height="8" width="14" x="94" y="74"></rect>
<rect fill="#1e293b" height="18" width="12" x="118" y="74"></rect>
<rect fill="#1e293b" height="8" width="16" x="56" y="102"></rect>
<rect fill="#1e293b" height="18" width="8" x="82" y="102"></rect>
<rect fill="#1e293b" height="8" width="18" x="100" y="102"></rect>
<rect fill="#1e293b" height="10" width="28" x="60" y="120"></rect>
<rect fill="#1e293b" height="10" width="16" x="100" y="120"></rect>
</svg>
</div>
<div class="mt-4">
<h4 class="font-extrabold text-xs text-slate-800 tracking-wider">ID : PTAMS-TC-024</h4>
<p class="text-[10px] text-slate-500 mt-1 max-w-[200px] mx-auto leading-relaxed">Pindai barcode ini kapan saja menggunakan kamera ponsel untuk memantau status langsung tanpa login</p>
</div>
</div>
<!-- Ticket Info Rows -->
<div class="space-y-3 pt-1">
<div class="flex items-center justify-between text-xs">
<span class="text-slate-600 font-medium">Nomor Registrasi :</span>
<span class="font-bold text-slate-900">#TC-024</span>
</div>
<div class="flex items-center justify-between text-xs">
<span class="text-slate-600 font-medium">Prioritas Respon :</span>
<span class="px-3 py-1 rounded-md border border-rose-500 text-rose-600 font-bold text-[11px]">Level 1 – Urgent</span>
</div>
</div>
</div>
<!-- 2. Pusat Bantuan Card -->
<div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
<div class="flex items-center gap-2">
<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<h3 class="font-bold text-sm text-slate-900">Pusat Bantuan</h3>
</div>
<!-- Contacts -->
<div class="space-y-2.5">
<!-- IT Helpdesk -->
<a class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-slate-100/70 transition" href="tel:4022">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-lg bg-blue-100/70 text-blue-700 flex items-center justify-center shrink-0">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<p class="text-xs font-bold text-slate-800">IT Helpdesk Extension</p>
<p class="text-[10px] text-slate-400">Jam Kerja 08:00 - 17:00</p>
</div>
</div>
<span class="text-xs font-bold text-blue-950">ext . 4022</span>
</a>
<!-- Hotline WhatsApp -->
<a class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-slate-100/70 transition" href="https://wa.me/628112090400" rel="noopener noreferrer" target="_blank">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-lg bg-emerald-100/70 text-emerald-700 flex items-center justify-center shrink-0">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<p class="text-xs font-bold text-slate-800">Hotline WhatsApp Servis</p>
<p class="text-[10px] text-slate-400">Respon cepat kendala aset</p>
</div>
</div>
<span class="text-[11px] font-bold text-slate-800">+62 811-2090-400</span>
</a>
</div>
</div>
<!-- 3. Panduan Pelapor & FAQ Card -->
<div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
<div class="flex items-center gap-2">
<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<h3 class="font-bold text-sm text-slate-900">Panduan Pelapor &amp; FAQ</h3>
</div>
<!-- FAQ Accordion List -->
<div class="space-y-2 text-xs divide-y divide-slate-100">
<!-- Item 1 -->
<div class="pt-2">
<button class="w-full text-left font-bold text-slate-800 flex items-start gap-2 hover:text-blue-700" onclick="toggleFaq('faq-1')">
<span class="mt-1 text-slate-900">•</span>
<span>Bagaimana cara melaporkan kerusakan perangkat</span>
</button>
<div class="mt-1 pl-3 text-[11px] text-slate-500 leading-relaxed" id="faq-1">
                    Scan QR Code yang tersedia, kemudian isi formulir laporan dengan menjelaskan kendala yang dialami.
                  </div>
</div>
<!-- Item 2 -->
<div class="pt-2">
<button class="w-full text-left font-bold text-slate-800 flex items-start gap-2 hover:text-blue-700" onclick="toggleFaq('faq-2')">
<span class="mt-1 text-slate-900">•</span>
<span>Bagaimana mengetahui status penanganan?</span>
</button>
<div class="mt-1 pl-3 text-[11px] text-slate-500 leading-relaxed" id="faq-2">
                    Pelapor dapat memantau perkembangan laporan melalui halaman riwayat atau detail tiket pengaduan.
                  </div>
</div>
<!-- Item 3 -->
<div class="pt-2">
<button class="w-full text-left font-bold text-slate-800 flex items-start gap-2 hover:text-blue-700" onclick="toggleFaq('faq-3')">
<span class="mt-1 text-slate-900">•</span>
<span>Berapa lama proses penanganan perangkat?</span>
</button>
<div class="mt-1 pl-3 text-[11px] text-slate-500 leading-relaxed" id="faq-3">
                    Durasi penanganan bergantung pada jenis kerusakan, tingkat prioritas, dan ketersediaan komponen atau sparepart.
                  </div>
</div>
<!-- Item 4 -->
<div class="pt-2">
<button class="w-full text-left font-bold text-slate-800 flex items-start gap-2 hover:text-blue-700" onclick="toggleFaq('faq-4')">
<span class="mt-1 text-slate-900">•</span>
<span>Bagaimana proses setelah perbaikan selesai?</span>
</button>
<div class="mt-1 pl-3 text-[11px] text-slate-500 leading-relaxed" id="faq-4">
                    Teknisi akan memperbarui status penanganan dan mengembalikan perangkat kepada lokasi atau penanggung jawab terkait.
                  </div>
</div>
<!-- Item 5 -->
<div class="pt-2">
<button class="w-full text-left font-bold text-slate-800 flex items-start gap-2 hover:text-blue-700" onclick="toggleFaq('faq-5')">
<span class="mt-1 text-slate-900">•</span>
<span>Bagaimana jika perangkat membutuhkan penanganan darurat?</span>
</button>
<div class="mt-1 pl-3 text-[11px] text-slate-500 leading-relaxed" id="faq-5">
                    Hubungi administrator atau petugas IT terkait untuk mendapatkan tindak lanjut sesuai tingkat urgensi permasalahan.
                  </div>
</div>
</div>
<!-- SOP Document Footer -->
<div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
<span class="text-slate-400">SOP Pemeliharaan Sarana IT v4.2</span>
<a class="font-bold text-slate-800 hover:text-blue-600 transition" href="#">Unduh PDF SOP</a>
</div>
</div>
</div>
<!-- END: Right Column -->
</div>
<!-- END: 2ColumnGrid -->
</main>
<!-- END: MainContentArea -->
</div>
</div>
<!-- BEGIN: Interactive Modals -->
<!-- Scan QR Camera Modal Simulation -->
<div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden" id="scan-modal">
<div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center space-y-4 shadow-2xl relative">
<button class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" onclick="closeScanModal()">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
<div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto">
<svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<h3 class="text-base font-bold text-slate-900">Pemindai Kamera Aktif</h3>
<p class="text-xs text-slate-500 mt-1">Arahkan kamera smartphone ke QR Code perangkat untuk identifikasi instan.</p>
</div>
<div class="h-44 bg-slate-900 rounded-xl flex items-center justify-center relative overflow-hidden border-2 border-slate-700">
<span class="absolute inset-x-4 top-1/2 h-0.5 bg-red-500 shadow-md"></span>
<p class="text-[11px] text-slate-400">Menunggu fokus QR code...</p>
</div>
<button class="w-full py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800 transition" onclick="closeScanModal()">
        Tutup Pemindai
      </button>
</div>
</div>
<!-- QR Code Zoom Modal -->
<div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden" id="qr-modal">
<div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center space-y-4 shadow-2xl relative">
<button class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" onclick="zoomQrModal()">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
<h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Public Ticket QR Code</h3>
<div class="p-4 bg-slate-50 rounded-xl inline-block border border-slate-200">
<svg class="w-48 h-48 mx-auto" fill="none" viewbox="0 0 140 140" xmlns="http://www.w3.org/2000/svg">
<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="10" y="10"></rect>
<rect fill="#1e293b" height="16" width="16" x="20" y="20"></rect>
<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="94" y="10"></rect>
<rect fill="#1e293b" height="16" width="16" x="104" y="20"></rect>
<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="10" y="94"></rect>
<rect fill="#1e293b" height="16" width="16" x="20" y="104"></rect>
<rect fill="#1e293b" height="8" width="8" x="56" y="14"></rect>
<rect fill="#1e293b" height="8" width="10" x="74" y="14"></rect>
<rect fill="#1e293b" height="8" width="16" x="56" y="32"></rect>
<rect fill="#1e293b" height="18" width="6" x="80" y="32"></rect>
<rect fill="#1e293b" height="8" width="12" x="20" y="56"></rect>
<rect fill="#1e293b" height="8" width="18" x="42" y="56"></rect>
<rect fill="#1e293b" height="18" width="8" x="70" y="56"></rect>
<rect fill="#1e293b" height="8" width="18" x="88" y="56"></rect>
<rect fill="#1e293b" height="8" width="14" x="116" y="56"></rect>
<rect fill="#1e293b" height="8" width="18" x="14" y="74"></rect>
<rect fill="#1e293b" height="18" width="8" x="42" y="74"></rect>
<rect fill="#1e293b" height="8" width="18" x="60" y="80"></rect>
<rect fill="#1e293b" height="8" width="14" x="94" y="74"></rect>
<rect fill="#1e293b" height="18" width="12" x="118" y="74"></rect>
<rect fill="#1e293b" height="8" width="16" x="56" y="102"></rect>
<rect fill="#1e293b" height="18" width="8" x="82" y="102"></rect>
<rect fill="#1e293b" height="8" width="18" x="100" y="102"></rect>
<rect fill="#1e293b" height="10" width="28" x="60" y="120"></rect>
<rect fill="#1e293b" height="10" width="16" x="100" y="120"></rect>
</svg>
</div>
<p class="text-xs font-bold text-slate-800">#TC-024 • PTAMS-TC-024</p>
<button class="w-full py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800 transition" onclick="zoomQrModal()">
        Selesai
      </button>
</div>
</div>
<!-- END: Interactive Modals -->
<!-- JavaScript Interaction handlers -->
<script data-purpose="event-handlers">
    // Sidebar toggle for mobile responsive view
    function toggleSidebar() {
      const sidebar = document.getElementById('main-sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      sidebar.classList.toggle('-translate-x-full');
      backdrop.classList.toggle('hidden');
    }

    // Toggle FAQ answers collapse/expand
    function toggleFaq(id) {
      const el = document.getElementById(id);
      if (el) {
        el.classList.toggle('hidden');
      }
    }

    // QR scanner modal open/close
    function openScanModal() {
      document.getElementById('scan-modal').classList.remove('hidden');
    }
    function closeScanModal() {
      document.getElementById('scan-modal').classList.add('hidden');
    }

    // QR zoom modal toggle
    function zoomQrModal() {
      document.getElementById('qr-modal').classList.toggle('hidden');
    }
  </script>
</body></html>