<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>P-TAMS - Dashboard Pelaporan &amp; Aset</title>
<!-- Tailwind CSS CDN with forms and container-queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Inter & Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind Configuration -->
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              navy: '#0f172a',
              dark: '#0e1e38',
              cardDark: '#0b192e',
              border: '#e2e8f0',
              grayBg: '#f8fafc',
            },
            status: {
              pending: '#ef4444',
              process: '#eab308',
              success: '#22c55e',
            }
          },
          boxShadow: {
            card: '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03)',
            elevated: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
          }
        }
      }
    }
  </script>
<!-- BEGIN: Custom Styles -->
<style data-purpose="base-styling">
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      color: #0f172a;
      -webkit-font-smoothing: antialiased;
    }
    
    /* Custom scrollbar for clean dashboard feel */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
  </style>
<!-- END: Custom Styles -->
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex flex-col md:flex-row">
<!-- BEGIN: Mobile Backdrop -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden md:hidden transition-opacity duration-300" id="mobileBackdrop" onclick="toggleSidebar()"></div>
<!-- END: Mobile Backdrop -->
<!-- BEGIN: Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-100 flex flex-col justify-between py-6 px-4 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 md:static md:h-screen md:sticky md:top-0 select-none" id="sidebar">
<div>
<!-- Brand Logo Header -->
<div class="flex items-center justify-between px-3 mb-8">
<div class="flex items-center space-x-2.5">
<!-- Logo Icon Mark (Custom geometric shape as in original UI) -->
<div class="w-8 h-8 rounded-full flex items-center justify-center relative bg-transparent">
<svg class="w-8 h-8 text-[#142340]" fill="none" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
<path d="M12 6C8.68629 6 6 8.68629 6 12V20C6 23.3137 8.68629 26 12 26C15.3137 26 18 23.3137 18 20V12C18 8.68629 15.3137 6 12 6Z" fill="#15284b"></path>
<circle cx="21" cy="11" fill="#15284b" r="5"></circle>
</svg>
</div>
<span class="text-xl font-bold tracking-tight text-[#15284b]">P-TAMS</span>
</div>
<!-- Mobile close button -->
<button class="md:hidden text-slate-400 hover:text-slate-600 p-1" onclick="toggleSidebar()">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
</div>
<!-- Main Navigation Menu -->
<nav class="space-y-1.5" data-purpose="sidebar-nav">
<!-- Dashboard (Active) -->
<a class="sidebar-nav-item active flex items-center space-x-3.5 px-4 py-3 rounded-lg text-sm font-medium bg-[#142340] text-white shadow-sm transition-all" href="#" onclick="setActiveNav(this)">
<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<rect height="7" rx="1.5" stroke-width="2" width="7" x="3" y="3"></rect>
<rect height="7" rx="1.5" stroke-width="2" width="7" x="14" y="3"></rect>
<rect height="7" rx="1.5" stroke-width="2" width="7" x="14" y="14"></rect>
<rect height="7" rx="1.5" stroke-width="2" width="7" x="3" y="14"></rect>
</svg>
<span>Dashboard</span>
</a>
<!-- Perangkat saya -->
<a class="sidebar-nav-item flex items-center space-x-3.5 px-4 py-3 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all" href="#" onclick="setActiveNav(this)">
<svg class="w-5 h-5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<rect height="14" rx="2" stroke-width="1.8" width="20" x="2" y="3"></rect>
<line stroke-linecap="round" stroke-width="1.8" x1="8" x2="16" y1="21" y2="21"></line>
<line stroke-width="1.8" x1="12" x2="12" y1="17" y2="21"></line>
</svg>
<span>Perangkat saya</span>
</a>
<!-- Tiket Saya -->
<a class="sidebar-nav-item flex items-center space-x-3.5 px-4 py-3 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all" href="#" onclick="setActiveNav(this)">
<svg class="w-5 h-5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
<span>Tiket Saya</span>
</a>
<!-- Buat Tiket -->
<a class="sidebar-nav-item flex items-center space-x-3.5 px-4 py-3 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all" href="#" onclick="setActiveNav(this)">
<svg class="w-5 h-5 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="9" stroke-width="1.8"></circle>
<line stroke-linecap="round" stroke-width="1.8" x1="12" x2="12" y1="8" y2="16"></line>
<line stroke-linecap="round" stroke-width="1.8" x1="8" x2="16" y1="12" y2="12"></line>
</svg>
<span>Buat Tiket</span>
</a>
<!-- Logout -->
<a class="sidebar-nav-item flex items-center space-x-3.5 px-4 py-3 rounded-lg text-sm font-medium text-[#ef4444] hover:bg-red-50/70 transition-all" href="#" onclick="confirmLogout(event)">
<svg class="w-5 h-5 flex-shrink-0 text-[#ef4444]" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
<span>Logout</span>
</a>
</nav>
</div>
<!-- Bottom QR Scanner Card -->
<div class="mt-auto px-1" data-purpose="qr-cta-card">
<div class="bg-[#0b1728] text-white p-4 rounded-xl shadow-lg relative overflow-hidden">
<!-- Subtle background glow decoration -->
<div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-500/10 rounded-full blur-xl pointer-events-none"></div>
<!-- QR Icon in white rounded box -->
<div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-[#0b1728] mb-3">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<rect height="6" rx="1" stroke-width="1.8" width="6" x="3" y="3"></rect>
<rect height="6" rx="1" stroke-width="1.8" width="6" x="15" y="3"></rect>
<rect height="6" rx="1" stroke-width="1.8" width="6" x="3" y="15"></rect>
<path d="M15 15h2v2h-2zm4 0h2v4h-4v-2h2zm-4 4h2v2h-2z" stroke-linecap="round" stroke-width="1.8"></path>
</svg>
</div>
<h4 class="font-bold text-sm tracking-tight text-white mb-1.5 leading-snug">Scan<br/>QR Perangkat</h4>
<p class="text-[11px] text-slate-400 font-normal leading-relaxed mb-3.5">
          Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.
        </p>
<!-- QR Scan Trigger Button -->
<button class="w-full py-2 px-3 bg-[#1e2e4a] hover:bg-[#283b5e] text-slate-200 hover:text-white rounded-lg text-xs font-semibold text-center transition-colors shadow-sm block cursor-pointer" onclick="openQrModal()">
          Mulai Scan QR
        </button>
</div>
</div>
</aside>
<!-- END: Sidebar -->
<!-- BEGIN: Main Page Content -->
<div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
<!-- Top Navigation Header -->
<header class="bg-white border-b border-slate-100 sticky top-0 z-30 px-6 py-4 flex items-center justify-between gap-4">
<div class="flex items-center gap-3 flex-1 max-w-xl">
<!-- Mobile Menu Toggle Button -->
<button class="md:hidden p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg focus:outline-none" onclick="toggleSidebar()">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
<!-- Top Search Bar -->
<div class="relative w-full">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400 bg-white" placeholder="Lakukan pencarian..." type="text"/>
</div>
</div>
<!-- User Profile & Notifications -->
<div class="flex items-center space-x-4 pl-2">
<!-- Notification Bell with Notification Indicator -->
<button class="relative p-2 text-slate-700 hover:text-slate-900 rounded-full hover:bg-slate-50 focus:outline-none" onclick="showToast('Anda memiliki 3 notifikasi belum dibaca')" title="Notifikasi">
<svg class="w-5 h-5 text-slate-800" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
<!-- Red notification indicator dot -->
<span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
</button>
<!-- User Profile Pill -->
<div class="flex items-center space-x-3 cursor-pointer group">
<div class="w-9 h-9 rounded-full overflow-hidden bg-slate-200 ring-1 ring-slate-200/80">
<img alt="Fikri Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDKsl-b8oLu9bC-WtOYDI4O8KQ5-UHUI2lbsY9t-CKq4dX1Z_cTYsY0F2r142G7VOmap6t1fMrtsCOtTxyCCKjBjOKk1Qe1f0yX-0fJG-Bhr73nrDlErsytp3zFLH_i9FOMvBW9oKBRFXTT-SWdNkg5QjlMUtRUJT76yPZIL3U8z6S4l6N5we3pPt4Bs7hu1bynAMRc2yMQfclb7x4yNJGkNd3iCJa7LViVuxdrQP4"/>
</div>
<div class="text-left hidden sm:block">
<h5 class="text-sm font-bold text-slate-900 leading-tight">Fikri</h5>
<p class="text-xs text-slate-400 font-medium">Admin</p>
</div>
</div>
</div>
</header>
<!-- Main Workspace Container -->
<main class="p-6 md:p-8 space-y-6 max-w-7xl mx-auto w-full">
<!-- BEGIN: Hero Welcome Section -->
<section class="space-y-1" data-purpose="dashboard-greeting">
<h1 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-900">Selamat Datang, Fikri</h1>
<p class="text-sm text-slate-500 font-normal">Pantau status perbaikan dan riwayat laporan anda</p>
</section>
<!-- END: Hero Welcome Section -->
<!-- BEGIN: Metric Summary Cards -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5" data-purpose="metrics-grid">
<!-- Card 1: Total Laporan Saya (Highlighted Dark Card) -->
<div class="bg-[#0b1728] text-white p-5 rounded-xl shadow-card relative flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex items-start justify-between">
<span class="text-sm font-medium text-slate-200">Total Laporan Saya</span>
<!-- White rounded icon container -->
<div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[#0b1728] flex-shrink-0">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<rect height="14" rx="2" stroke-width="2" width="20" x="2" y="3"></rect>
<line stroke-linecap="round" stroke-width="2" x1="8" x2="16" y1="21" y2="21"></line>
<line stroke-width="2" x1="12" x2="12" y1="17" y2="21"></line>
</svg>
</div>
</div>
<div class="mt-4">
<div class="text-3xl md:text-4xl font-bold tracking-tight text-white mb-1">4</div>
<p class="text-xs text-slate-300 font-normal">Total laporan dibuat</p>
</div>
</div>
<!-- Card 2: Tiket Pending -->
<div class="bg-white border border-slate-100 p-5 rounded-xl shadow-card flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex items-start justify-between">
<span class="text-sm font-semibold text-slate-900">Tiket Pending</span>
<div class="text-emerald-500">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="9"></circle>
<polyline points="12 7 12 12 15 15"></polyline>
</svg>
</div>
</div>
<div class="mt-4">
<div class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-1">4</div>
<p class="text-xs text-slate-500 font-normal">Menunggu penanganan</p>
</div>
</div>
<!-- Card 3: Sedang Diperbaiki (Wrench/Process) -->
<div class="bg-white border border-slate-100 p-5 rounded-xl shadow-card flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex items-start justify-between">
<span class="text-sm font-semibold text-slate-900">Sedang Diperbaiki</span>
<div class="text-rose-500">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<rect height="16" rx="2" width="18" x="3" y="4"></rect>
<path d="M16 2v4M8 2v4M3 10h18"></path>
<circle cx="16" cy="15" r="2"></circle>
</svg>
</div>
</div>
<div class="mt-4">
<div class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-1">4</div>
<p class="text-xs text-slate-500 font-normal">Dalam proses perbaikan</p>
</div>
</div>
<!-- Card 4: Sedang Diperbaiki (Document/Done) -->
<div class="bg-white border border-slate-100 p-5 rounded-xl shadow-card flex flex-col justify-between hover:shadow-md transition-shadow">
<div class="flex items-start justify-between">
<span class="text-sm font-semibold text-slate-900">Sedang Diperbaiki</span>
<div class="text-emerald-500">
<svg class="w-5 h-5 stroke-[2]" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
</svg>
</div>
</div>
<div class="mt-4">
<div class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-1">4</div>
<p class="text-xs text-slate-500 font-normal">Dalam proses perbaikan</p>
</div>
</div>
</section>
<!-- END: Metric Summary Cards -->
<!-- BEGIN: Pembaruan Status Terkini (Recent Updates) -->
<section class="bg-white border border-slate-100 rounded-xl p-6 shadow-card" data-purpose="recent-activity-section">
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-100 gap-2">
<div>
<h2 class="text-base font-bold text-slate-900">Pembaruan Status Terkini</h2>
<p class="text-xs text-slate-400 mt-0.5">Notifikasi perkembangan pengerjaan perangkat anda</p>
</div>
<a class="inline-flex items-center text-xs font-medium text-slate-500 hover:text-slate-800 transition-colors group self-start sm:self-auto" href="#" onclick="showToast('Membuka riwayat aktivitas lengkap...')">
<span>Lihat semua aktivitas</span>
<svg class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</a>
</div>
<!-- Activity Timeline / List Items -->
<div class="divide-y divide-slate-50 pt-1">
<!-- Activity 1 -->
<div class="py-4 flex items-start justify-between gap-4 hover:bg-slate-50/50 rounded-lg px-2 transition-colors cursor-pointer" onclick="showToast('Detail Tiket #TC-104')">
<div class="flex items-start space-x-3.5 min-w-0">
<!-- Amber/Yellow Icon Circle -->
<div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center flex-shrink-0 text-amber-500 ring-4 ring-amber-50/50">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
</div>
<div class="min-w-0">
<p class="text-xs font-semibold text-slate-900 leading-snug truncate sm:whitespace-normal">
                  Teknisi Haikal telah memulai menangani tiket #TC-104 (Laptop Thinkpad T14)
                </p>
<p class="text-[11px] text-slate-400 mt-1">Notifikasi perkembangan pengerjaan perangkat anda</p>
</div>
</div>
<div class="text-[11px] text-slate-400 whitespace-nowrap flex-shrink-0 text-right pt-0.5">
              16 jam yang lalu
            </div>
</div>
<!-- Activity 2 -->
<div class="py-4 flex items-start justify-between gap-4 hover:bg-slate-50/50 rounded-lg px-2 transition-colors cursor-pointer" onclick="showToast('Detail Tiket #TC-098')">
<div class="flex items-start space-x-3.5 min-w-0">
<!-- Teal/Green Icon Circle -->
<div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 text-emerald-500 ring-4 ring-emerald-50/50">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
</svg>
</div>
<div class="min-w-0">
<p class="text-xs font-semibold text-slate-900 leading-snug truncate sm:whitespace-normal">
                  Tiket #TC-098 (Printer Epson L3110) Telah selesai diperbaiki
                </p>
<p class="text-[11px] text-slate-400 mt-1">Perangkat siap diambil di ruang IT Support</p>
</div>
</div>
<div class="text-[11px] text-slate-400 whitespace-nowrap flex-shrink-0 text-right pt-0.5">
              2 jam yang lalu
            </div>
</div>
<!-- Activity 3 -->
<div class="py-4 flex items-start justify-between gap-4 hover:bg-slate-50/50 rounded-lg px-2 transition-colors cursor-pointer" onclick="showToast('Detail Tiket #TC-0105')">
<div class="flex items-start space-x-3.5 min-w-0">
<!-- Sky/Blue Icon Circle -->
<div class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center flex-shrink-0 text-sky-500 ring-4 ring-sky-50/50">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="9" stroke-width="1.8"></circle>
<polyline points="12 7 12 12 15 15" stroke-width="1.8"></polyline>
</svg>
</div>
<div class="min-w-0">
<p class="text-xs font-semibold text-slate-900 leading-snug truncate sm:whitespace-normal">
                  Tiket #TC-0105 (AC Ruangan 204) berhasil disubmit &amp; menunggu verifikasi
                </p>
<p class="text-[11px] text-slate-400 mt-1">Menunggu penetapan teknisi</p>
</div>
</div>
<div class="text-[11px] text-slate-400 whitespace-nowrap flex-shrink-0 text-right pt-0.5">
              7 jam yang lalu
            </div>
</div>
</div>
</section>
<!-- END: Pembaruan Status Terkini -->
<!-- BEGIN: Riwayat Laporan Tiket Saya (Tickets Table Section) -->
<section class="bg-white border border-slate-100 rounded-xl p-6 shadow-card space-y-5" data-purpose="tickets-history-card">
<!-- Table Top Controls Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
<div>
<h2 class="text-base font-bold text-slate-900">Riwayat Laporan Tiket Saya</h2>
<p class="text-xs text-slate-400 mt-0.5">Menampilkan laporan kerusakan yang pernah anda buat.</p>
</div>
<!-- Search & Filter Controls -->
<div class="flex items-center gap-3">
<!-- Search Inside History -->
<div class="relative w-full sm:w-64">
<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</span>
<input class="w-full pl-9 pr-3 py-1.5 text-xs border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="ticketSearchInput" oninput="handleSearch()" placeholder="Lakukan Pencarian..." type="text"/>
</div>
<!-- Status Filter Dropdown -->
<div class="relative">
<select class="appearance-none bg-white border border-slate-200 text-xs font-medium text-slate-700 py-1.5 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-1 focus:ring-slate-400 cursor-pointer" id="statusFilterSelect" onchange="handleFilterChange(this.value)">
<option value="Semua">Semua Status</option>
<option selected="" value="Pending">Pending</option>
<option value="Diproses">Diproses</option>
<option value="Selesai">Selesai</option>
</select>
<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
</div>
</div>
</div>
<!-- Table Container with soft border wrapper -->
<div class="border border-slate-100 rounded-lg overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left text-xs border-collapse" id="ticketsTable">
<thead>
<tr class="bg-slate-50/70 border-b border-slate-100 text-slate-800 font-semibold">
<th class="py-3 px-6 font-semibold">ID Tiket</th>
<th class="py-3 px-6 font-semibold">Perangkat</th>
<th class="py-3 px-6 font-semibold">Pelapor</th>
<th class="py-3 px-6 font-semibold">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-slate-700 font-medium" id="ticketTableBody">
<!-- Row 1 -->
<tr class="hover:bg-slate-50/60 transition-colors" data-search="#tc-001 pc kantor fikri" data-status="Pending">
<td class="py-3.5 px-6 font-medium text-slate-900">#TC-001</td>
<td class="py-3.5 px-6 text-slate-600">PC Kantor</td>
<td class="py-3.5 px-6 text-slate-600">Fikri</td>
<td class="py-3.5 px-6">
<span class="inline-flex items-center text-red-500 font-semibold">
<span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>
                      Pending
                    </span>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-slate-50/60 transition-colors" data-search="#tc-002 printer fikri" data-status="Diproses">
<td class="py-3.5 px-6 font-medium text-slate-900">#TC-002</td>
<td class="py-3.5 px-6 text-slate-600">Printer</td>
<td class="py-3.5 px-6 text-slate-600">Fikri</td>
<td class="py-3.5 px-6">
<span class="inline-flex items-center text-amber-500 font-semibold">
<span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2"></span>
                      Diproses
                    </span>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-slate-50/60 transition-colors" data-search="#tc-003 ac ruangan fikri" data-status="Selesai">
<td class="py-3.5 px-6 font-medium text-slate-900">#TC-003</td>
<td class="py-3.5 px-6 text-slate-600">AC Ruangan</td>
<td class="py-3.5 px-6 text-slate-600">Fikri</td>
<td class="py-3.5 px-6">
<span class="inline-flex items-center text-emerald-500 font-semibold">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                      Selesai
                    </span>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-slate-50/60 transition-colors" data-search="#tc-004 laptop fikri" data-status="Pending">
<td class="py-3.5 px-6 font-medium text-slate-900">#TC-004</td>
<td class="py-3.5 px-6 text-slate-600">Laptop</td>
<td class="py-3.5 px-6 text-slate-600">Fikri</td>
<td class="py-3.5 px-6">
<span class="inline-flex items-center text-red-500 font-semibold">
<span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-2"></span>
                      Pending
                    </span>
</td>
</tr>
<!-- Row 5 -->
<tr class="hover:bg-slate-50/60 transition-colors" data-search="#tc-005 hp fikri" data-status="Diproses">
<td class="py-3.5 px-6 font-medium text-slate-900">#TC-005</td>
<td class="py-3.5 px-6 text-slate-600">Hp</td>
<td class="py-3.5 px-6 text-slate-600">Fikri</td>
<td class="py-3.5 px-6">
<span class="inline-flex items-center text-amber-500 font-semibold">
<span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2"></span>
                      Diproses
                    </span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Table Bottom Action Button -->
<div class="flex justify-end pt-2">
<button class="inline-flex items-center px-4 py-2 bg-[#12223a] hover:bg-[#1b2f4f] text-white rounded-lg text-xs font-semibold tracking-wide transition-all shadow-sm" onclick="showToast('Menampilkan seluruh arsip tiket...')">
<span>Lihat Semuanya</span>
<svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
</div>
</section>
<!-- END: Riwayat Laporan Tiket Saya -->
</main>
</div>
<!-- END: Main Page Content -->
<!-- BEGIN: Interactive QR Scanner Modal -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm hidden px-4" data-purpose="qr-modal" id="qrModal">
<div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl relative animate-in fade-in zoom-in duration-200 text-center">
<button class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1 rounded-full" onclick="closeQrModal()">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
<div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-800">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<rect height="6" rx="1" stroke-width="2" width="6" x="3" y="3"></rect>
<rect height="6" rx="1" stroke-width="2" width="6" x="15" y="3"></rect>
<rect height="6" rx="1" stroke-width="2" width="6" x="3" y="15"></rect>
<path d="M15 15h3v3h-3z" stroke-width="2"></path>
</svg>
</div>
<h3 class="text-base font-bold text-slate-900 mb-1">Scan QR Perangkat</h3>
<p class="text-xs text-slate-500 mb-5">Arahkan kamera ke barcode stiker perangkat IT untuk cek riwayat otomatis.</p>
<!-- Simulated camera viewfinder -->
<div class="w-48 h-48 mx-auto border-2 border-dashed border-blue-500 rounded-xl relative bg-slate-900/5 flex items-center justify-center overflow-hidden mb-5">
<div class="w-36 h-36 border border-blue-400/40 rounded-lg flex items-center justify-center relative">
<!-- Scanning animated laser line -->
<div class="w-full h-0.5 bg-blue-500 absolute animate-pulse"></div>
<span class="text-[10px] text-blue-600 font-mono">ARAHKAN KODE</span>
</div>
</div>
<div class="flex gap-2">
<button class="flex-1 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg" onclick="closeQrModal()">Batal</button>
<button class="flex-1 py-2 text-xs font-semibold bg-[#12223a] text-white hover:bg-[#1b2f4f] rounded-lg" onclick="simulateScanResult()">Simulasi Sukses</button>
</div>
</div>
</div>
<!-- END: Interactive QR Scanner Modal -->
<!-- BEGIN: Interactive Toast Notification -->
<div class="fixed bottom-5 right-5 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none" id="toastMessage">
<div class="bg-slate-900 text-white text-xs font-medium px-4 py-3 rounded-lg shadow-xl flex items-center space-x-2">
<svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<span id="toastText">Aksi berhasil dilakukan</span>
</div>
</div>
<!-- END: Interactive Toast Notification -->
<!-- BEGIN: Core Interactive Script -->
<script data-purpose="dashboard-functionality">
    // Toggle Mobile Drawer Sidebar
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('mobileBackdrop');
      
      const isClosed = sidebar.classList.contains('-translate-x-full');
      if (isClosed) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
      }
    }

    // Set Active Nav Item Styling
    function setActiveNav(element) {
      document.querySelectorAll('.sidebar-nav-item').forEach(item => {
        item.classList.remove('bg-[#142340]', 'text-white');
        if (!item.classList.contains('text-[#ef4444]')) {
          item.classList.add('text-slate-600');
        }
      });

      if (!element.classList.contains('text-[#ef4444]')) {
        element.classList.add('bg-[#142340]', 'text-white');
        element.classList.remove('text-slate-600');
      }
    }

    // Logout Confirmation Toast
    function confirmLogout(e) {
      e.preventDefault();
      if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
        showToast('Berhasil keluar. Mengalihkan...');
      }
    }

    // QR Modal Controls
    function openQrModal() {
      document.getElementById('qrModal').classList.remove('hidden');
    }

    function closeQrModal() {
      document.getElementById('qrModal').classList.add('hidden');
    }

    function simulateScanResult() {
      closeQrModal();
      showToast('QR Terdeteksi: Perangkat #TC-001 (PC Kantor - Fikri)');
    }

    // Toast Popup Helper
    let toastTimeout;
    function showToast(message) {
      const toast = document.getElementById('toastMessage');
      const text = document.getElementById('toastText');
      text.innerText = message;
      
      toast.classList.remove('translate-y-24', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');
      
      clearTimeout(toastTimeout);
      toastTimeout = setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-24', 'opacity-0');
      }, 3000);
    }

    // Live Table Filtering by Status & Search Term
    function filterTable() {
      const selectedStatus = document.getElementById('statusFilterSelect').value;
      const searchTerm = document.getElementById('ticketSearchInput').value.toLowerCase().trim();
      const rows = document.querySelectorAll('#ticketTableBody tr');

      rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        const rowSearch = row.getAttribute('data-search');

        const matchesStatus = (selectedStatus === 'Semua' || rowStatus === selectedStatus);
        const matchesSearch = searchTerm === '' || rowSearch.includes(searchTerm);

        if (matchesStatus && matchesSearch) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function handleFilterChange(value) {
      filterTable();
      showToast(`Filter diubah ke: ${value}`);
    }

    function handleSearch() {
      filterTable();
    }

    // Run table initial setup
    window.addEventListener('DOMContentLoaded', () => {
      // By default the screenshot shows Pending in the dropdown and displays all 5 rows or filters
      // We set filter to show initially
      filterTable();
    });
  </script>
<!-- END: Core Interactive Script -->
</body></html>