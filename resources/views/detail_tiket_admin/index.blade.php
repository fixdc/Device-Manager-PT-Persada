<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Detail Laporan Kerusakan &amp; Monitoring Servis - P-TAMS Admin</title>
<!-- Google Fonts: Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS v3 with Plugins -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          },
          colors: {
            brand: {
              navy: '#0b192c',
              dark: '#0f172a',
              cardDark: '#0d1f36',
              accent: '#2563eb',
            }
          }
        }
      }
    }
  </script>
<style data-purpose="custom-scrollbars-and-resets">
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      color: #1e293b;
    }
    .toast-animate-in {
      animation: toastSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes toastSlideUp {
      from {
        opacity: 0;
        transform: translateY(16px) scale(0.96);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
  </style>
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-800 antialiased flex flex-col lg:flex-row relative">
<!-- BEGIN: Mobile Drawer & Backdrop -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden transition-opacity lg:hidden" id="mobile-drawer-backdrop" onclick="toggleMobileMenu()"></div>
<aside class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col justify-between p-6 shadow-2xl overflow-y-auto" id="mobile-drawer">
<div class="space-y-6">
<!-- Drawer Header -->
<div class="flex items-center justify-between px-2">
<div class="flex items-center gap-3">
<div class="w-9 h-9 rounded-full bg-[#0b192c] flex items-center justify-center text-white shadow-sm">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24">
<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"></path>
</svg>
</div>
<span class="text-xl font-bold tracking-tight text-[#0b192c]">P-TAMS</span>
</div>
<button aria-label="Tutup Menu" class="p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100" onclick="toggleMobileMenu()">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12"></path>
</svg>
</button>
</div>
<!-- Navigation Menu Items -->
<nav aria-label="Mobile Navigation" class="space-y-1.5">
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="7" rx="1" width="7" x="3" y="3"></rect>
<rect height="7" rx="1" width="7" x="14" y="3"></rect>
<rect height="7" rx="1" width="7" x="14" y="14"></rect>
<rect height="7" rx="1" width="7" x="3" y="14"></rect>
</svg>
        Dashboard
      </a>
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="14" rx="2" width="20" x="2" y="3"></rect>
<path d="M8 21h8m-4-4v4"></path>
</svg>
        Kelola Device
      </a>
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
        Kelola User
      </a>
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl bg-[#0b192c] text-white font-medium text-sm shadow-sm transition-colors" href="#">
<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"></path>
<path d="M13 5v2m0 4v2m0 4v2"></path>
</svg>
        Kelola Ticket
      </a>
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="10"></circle>
<polyline points="12 6 12 12 16 14"></polyline>
</svg>
        Riwayat Kerusakan
      </a>
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-rose-600 hover:bg-rose-50 font-medium text-sm transition-colors pt-2" href="#">
<svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
<polyline points="16 17 21 12 16 7"></polyline>
<line x1="21" x2="9" y1="12" y2="12"></line>
</svg>
        Logout
      </a>
</nav>
</div>
<!-- Mobile Bottom Scan Card -->
<div class="bg-[#0b192c] rounded-2xl p-4 text-white text-center mt-6">
<div class="w-10 h-10 mx-auto rounded-lg bg-white/10 flex items-center justify-center mb-3">
<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="7" width="7" x="3" y="3"></rect>
<rect height="7" width="7" x="14" y="3"></rect>
<rect height="7" width="7" x="3" y="14"></rect>
<path d="M14 14h3v3h-3z"></path>
<path d="M20 14v3h-3"></path>
<path d="M14 20h6"></path>
</svg>
</div>
<h3 class="font-bold text-sm text-left leading-tight">Scan<br/>QR Perangkat</h3>
<p class="text-[11px] text-left text-slate-300 mt-2 leading-relaxed font-normal">
      Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.
    </p>
<button class="w-full mt-4 py-2 px-3 text-xs font-semibold rounded-lg bg-[#4b5563]/50 hover:bg-[#4b5563]/70 text-slate-100 transition-colors">
      Mulai Scan QR
    </button>
</div>
</aside>
<!-- END: Mobile Drawer & Backdrop -->
<!-- BEGIN: SidebarNavigation (Desktop) -->
<aside class="hidden lg:flex flex-col w-64 min-w-[16rem] bg-white border-r border-slate-200/80 min-h-screen justify-between p-6 shrink-0" data-purpose="sidebar">
<div class="space-y-8">
<!-- Logo Branding -->
<div class="flex items-center gap-3 px-2">
<div class="w-9 h-9 rounded-full bg-[#0b192c] flex items-center justify-center text-white">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24">
<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"></path>
</svg>
</div>
<span class="text-xl font-bold tracking-tight text-[#0b192c]">P-TAMS</span>
</div>
<!-- Navigation Menu Items -->
<nav aria-label="Main Navigation" class="space-y-1.5">
<!-- Dashboard -->
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="7" rx="1" width="7" x="3" y="3"></rect>
<rect height="7" rx="1" width="7" x="14" y="3"></rect>
<rect height="7" rx="1" width="7" x="14" y="14"></rect>
<rect height="7" rx="1" width="7" x="3" y="14"></rect>
</svg>
          Dashboard
        </a>
<!-- Kelola Device -->
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="14" rx="2" width="20" x="2" y="3"></rect>
<path d="M8 21h8m-4-4v4"></path>
</svg>
          Kelola Device
        </a>
<!-- Kelola User -->
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
          Kelola User
        </a>
<!-- Kelola Ticket (Active) -->
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl bg-[#0b192c] text-white font-medium text-sm shadow-sm transition-colors" href="#">
<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"></path>
<path d="M13 5v2m0 4v2m0 4v2"></path>
</svg>
          Kelola Ticket
        </a>
<!-- Riwayat Kerusakan -->
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-colors" href="#">
<svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="10"></circle>
<polyline points="12 6 12 12 16 14"></polyline>
</svg>
          Riwayat Kerusakan
        </a>
<!-- Logout -->
<a class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl text-rose-600 hover:bg-rose-50 font-medium text-sm transition-colors pt-2" href="#">
<svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
<polyline points="16 17 21 12 16 7"></polyline>
<line x1="21" x2="9" y1="12" y2="12"></line>
</svg>
          Logout
        </a>
</nav>
</div>
<!-- Sidebar Bottom Promo Card: Scan QR Perangkat -->
<div class="bg-[#0b192c] rounded-2xl p-4 text-white text-center mt-6" data-purpose="qr-scan-card">
<div class="w-10 h-10 mx-auto rounded-lg bg-white/10 flex items-center justify-center mb-3">
<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="7" width="7" x="3" y="3"></rect>
<rect height="7" width="7" x="14" y="3"></rect>
<rect height="7" width="7" x="3" y="14"></rect>
<path d="M14 14h3v3h-3z"></path>
<path d="M20 14v3h-3"></path>
<path d="M14 20h6"></path>
</svg>
</div>
<h3 class="font-bold text-sm text-left leading-tight">Scan<br/>QR Perangkat</h3>
<p class="text-[11px] text-left text-slate-300 mt-2 leading-relaxed font-normal">
        Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.
      </p>
<button class="w-full mt-4 py-2 px-3 text-xs font-semibold rounded-lg bg-[#4b5563]/50 hover:bg-[#4b5563]/70 text-slate-100 transition-colors">
        Mulai Scan QR
      </button>
</div>
</aside>
<!-- END: SidebarNavigation -->
<!-- BEGIN: MainContentWrapper -->
<div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
<!-- Top Header Bar -->
<header class="bg-white border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between sticky top-0 z-20">
<!-- Left side: Hamburger Toggle (Mobile/Tablet) + Search Input -->
<div class="flex items-center gap-3 flex-1 min-w-0 mr-3">
<button aria-label="Buka Menu" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 shrink-0" onclick="toggleMobileMenu()">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M4 6h16M4 12h16M4 18h16"></path>
</svg>
</button>
<form action="/api/v1/search" class="w-full max-w-[200px] sm:max-w-md lg:max-w-xl relative" id="global-search-form" method="GET" role="search">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" x2="16.65" y1="12" y2="16.65"></line>
</svg>
</span>
<input autocomplete="off" class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 border border-slate-200 rounded-lg text-xs sm:text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400 transition" id="global-search-input" name="q" placeholder="Lakukan pencarian..." type="search"/>
</form>
</div>
<!-- Header Right Utilities (Notifications + Profile) -->
<div class="flex items-center gap-3 sm:gap-6 shrink-0">
<!-- Notification Bell -->
<button aria-label="Notifikasi" class="text-slate-600 hover:text-slate-800 relative p-1.5 sm:p-1 transition">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
</svg>
<span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
</button>
<!-- User Profile Pill -->
<div class="flex items-center gap-2.5 sm:gap-3 pl-1 sm:pl-2">
<img alt="Fikri Admin Avatar" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover ring-1 ring-slate-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJQfa7D_LdeFxcdsNmx1mfF_94VueM0SAMbDe7qJbZFf15qyeQEK4rp67qJUZglnsG0wReOB0hRzU5QG6R4H1pbj1lKsWlZR8mnZoJKc7JElLgmcVdOZJ0WS-dgD0DDdz6lS659PF-is5tJPMCnTxfrYPawcjqsSeacxR77tBGfXwjaoJTSC4Q5ziQpMkmP2hp3J0qjpDyJpU4y3yPLzeUJVAIqJ-J0snRhVHbG_Gk"/>
<div class="text-left text-xs hidden sm:block">
<div class="font-bold text-slate-800 leading-tight">Fikri</div>
<div class="text-slate-400 font-medium">Admin</div>
</div>
</div>
</div>
</header>
<!-- Main Viewport Section -->
<main class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-[1400px] w-full mx-auto" data-endpoint="/api/v1/tickets/TC-024" data-ticket-code="PTAMS-TC-024" data-ticket-id="TC-024">
<!-- Back Button -->
<div>
<a class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#0b192c] text-white text-xs font-semibold rounded-lg shadow-sm hover:bg-slate-800 transition" href="#">
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewbox="0 0 24 24">
<path d="M19 12H5m7-7l-7 7 7 7"></path>
</svg>
          Tiket Saya
        </a>
</div>
<!-- Page Heading & Status Callouts -->
<section class="flex flex-col sm:flex-row sm:items-start justify-between gap-4" data-purpose="page-header">
<div>
<h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[#0b192c] tracking-tight">
            Detail Laporan Kerusakan &amp; Monitoring Servis
          </h1>
<p class="text-slate-500 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
            Lacak tahapan perbaikan, verifikasi suku cadang , dan perbaruan teknisi langsung dari sistem Pusat
          </p>
</div>
<!-- Current Status and Priority Badges -->
<div class="flex items-center gap-3 shrink-0 flex-wrap">
<!-- Status Pill -->
<div class="bg-white border border-slate-200/90 rounded-xl px-3.5 sm:px-4 py-2 sm:py-2.5 shadow-sm text-left" data-field="display-status" data-status="in_progress">
<div class="text-[10px] tracking-wider text-slate-400 font-semibold uppercase">Status Saat Ini</div>
<div class="flex items-center gap-1.5 text-xs font-bold text-amber-500 mt-0.5" id="header-status-indicator">
<span class="w-2 h-2 rounded-full bg-amber-500 inline-block" id="header-status-dot"></span>
<span id="header-status-text">Sedang Diproses</span>
</div>
</div>
<!-- Priority Pill -->
<div class="bg-white border border-slate-200/90 rounded-xl px-3.5 sm:px-4 py-2 sm:py-2.5 shadow-sm text-left" data-field="display-priority" data-priority="urgent">
<div class="text-[10px] tracking-wider text-slate-400 font-semibold uppercase">Prioritas</div>
<div class="flex items-center gap-1.5 text-xs font-bold text-rose-600 mt-0.5">
<span class="w-2 h-2 rounded-full bg-rose-600 inline-block"></span>
              Tinggi (UrgentSLA)
            </div>
</div>
</div>
</section>
<!-- Grid Content Layout: 2 Columns (8 Cols / 4 Cols) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
<!-- BEGIN: LeftColumnContent -->
<div class="lg:col-span-8 space-y-6 w-full">
<!-- Ticket Registration Dark Hero Card -->
<div class="bg-[#0b192c] rounded-2xl p-5 sm:p-6 text-white shadow-md flex flex-col sm:flex-row justify-between gap-5 sm:gap-6 relative overflow-hidden" data-category="Hardware / Output Device / Printer" data-purpose="ticket-hero-banner" data-reported-at="2026-10-12T10:00:00+07:00" data-reporter-division="Bendahara" data-reporter-name="Granitul" data-ticket-id="TC-024">
<div class="space-y-3 z-10">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center border border-white/10 shrink-0">
<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"></path>
<path d="M13 5v2m0 4v2m0 4v2"></path>
</svg>
</div>
<div>
<h2 class="text-sm font-semibold text-slate-100">Nomor Registrasi Tiket</h2>
<p class="text-xs text-slate-400">Kategori : Hardware / Output Device / Printer</p>
</div>
</div>
<div class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white pt-1">
                #TC-024
              </div>
<p class="text-xs text-slate-300 font-normal leading-relaxed">
                Kerusakan dilaporkan oleh Granitul (Divisi Bendahara)<br/>
                pada 12 oktober 2026, 10:00 WIB
              </p>
</div>
<!-- Mini Progress Stage Box -->
<div class="sm:self-center shrink-0 w-full sm:w-auto" data-stage="3" data-stage-name="Perbaikan Fisik" data-total-stages="4">
<div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-xl p-4 min-w-[200px] text-left">
<div class="flex items-center justify-between text-[11px] font-semibold tracking-wide text-slate-200">
<span>TAHAP PENANGANAN</span>
<span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
</div>
<div class="text-xs font-bold text-white mt-1.5">
                  Tahap 3 dari 4 (Perbaikan Fisik)
                </div>
<div class="text-[10px] text-slate-300 mt-1">
                  Estimasi penguji operasional: ~2 jam
                </div>
</div>
</div>
</div>
<!-- Specifications and Details Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm" data-device-category="Hardware" data-device-id="DEV-ACR-7729X" data-device-location="Ruang Meeting A" data-device-name="Laptop Acer" data-device-serial="ACR-Aspire-7729X" data-purpose="specifications-card" data-reporter-nip="1999999999">
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 pb-6 border-b border-slate-100">
<!-- Illustration Graphic -->
<div class="w-24 sm:w-32 h-20 sm:h-24 shrink-0 flex items-center justify-center mx-auto sm:mx-0">
<svg class="w-full h-full" fill="none" viewbox="0 0 160 120">
<!-- Server block -->
<path d="M100 20 L135 35 L135 85 L100 70 Z" fill="#93c5fd"></path>
<path d="M100 20 L75 32 L75 82 L100 70 Z" fill="#60a5fa"></path>
<path d="M75 32 L110 44 L135 35 L100 20 Z" fill="#bfdbfe"></path>
<!-- Laptop Base -->
<path d="M25 80 L90 80 L115 102 L40 102 Z" fill="#cbd5e1" stroke="#94a3b8" stroke-width="1.5"></path>
<!-- Laptop Screen -->
<path d="M35 40 L95 40 L95 80 L35 80 Z" fill="#1e293b" rx="2"></path>
<rect fill="#3b82f6" fill-opacity="0.8" height="32" rx="1" width="52" x="39" y="44"></rect>
<!-- Gear icon on screen -->
<circle cx="65" cy="60" fill="none" r="7" stroke="white" stroke-width="2"></circle>
<!-- Checkmark badge -->
<circle cx="95" cy="78" fill="#3b82f6" r="8"></circle>
<path d="M92 78 L94 80 L98 76" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
<!-- QR code floating card -->
<rect fill="white" height="26" rx="2" stroke="#cbd5e1" stroke-width="1.5" width="22" x="18" y="55"></rect>
<rect fill="#3b82f6" height="4" width="4" x="22" y="59"></rect>
<rect fill="#3b82f6" height="4" width="4" x="32" y="59"></rect>
<rect fill="#3b82f6" height="4" width="4" x="22" y="69"></rect>
<rect fill="#3b82f6" height="2" width="2" x="28" y="65"></rect>
<rect fill="#3b82f6" height="4" width="4" x="32" y="69"></rect>
</svg>
</div>
<!-- Section Text Intro -->
<div class="text-left pt-1">
<h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                  Spesifikasi &amp; Informasi Lengkap Laporan
                </h3>
<p class="text-xs text-slate-500 mt-1 leading-relaxed">
                  Data terverifikasi otomatis dari master basis data aset P-TAMS
                </p>
</div>
</div>
<!-- Detailed Grid Items -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 mt-6">
<!-- Item 1: Nama Perangkat -->
<div class="p-4 rounded-xl border border-slate-100 bg-[#f8fafc]/50 flex flex-col justify-between" data-device-item="name-card">
<div>
<div class="flex items-center gap-2 text-xs font-semibold text-slate-700">
<svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="14" rx="2" width="20" x="2" y="3"></rect>
<path d="M8 21h8m-4-4v4"></path>
</svg>
    Nama Perangkat
  </div>
<div class="mt-3">
<div class="text-base font-bold text-slate-900 leading-snug" data-field="device_name">Laptop Acer</div>
<div class="text-[11px] text-slate-500 font-medium mt-0.5" data-field="serial_number"># Serial No : ACR-Aspire-7729X</div>
</div>
</div>
<div class="mt-3">
<span class="inline-block px-2.5 py-0.5 text-[10px] font-semibold rounded-md bg-blue-50 text-blue-600 border border-blue-100" data-field="category">
    Hardware
  </span>
</div>
</div>
<!-- Item 2: Lokasi Perangkat -->
<div class="p-4 rounded-xl border border-slate-100 bg-[#f8fafc]/50 flex flex-col justify-between" data-device-item="location-card">
<div>
<div class="text-[11px] font-medium text-slate-500">Lokasi Perangkat</div>
<div class="text-sm font-bold text-slate-900 mt-2" data-field="location_room">Ruang Meeting A</div>
</div>
<div class="text-[10px] text-slate-500 mt-2 leading-tight" data-field="location_detail">Gedung utama lantai 3 – operasional</div>
</div>
<!-- Item 3: Nama Pelapor -->
<div class="p-4 rounded-xl border border-slate-100 bg-[#f8fafc]/50 flex flex-col justify-between" data-device-item="reporter-card">
<div>
<div class="text-[11px] font-medium text-slate-500">Nama Pelapor</div>
<div class="text-sm font-bold text-slate-900 mt-2" data-field="reporter_name">Budi Pratama</div>
</div>
<div class="text-[10px] text-slate-500 mt-2" data-field="reporter_nip">NIP : 1999999999</div>
</div>
</div>
</div>
<!-- Issue Details & Attachments Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm space-y-6" data-purpose="issue-description-card">
<div>
<h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Isi Laporan / Keluhan</h3>
<p class="text-xs text-slate-500 mt-0.5">Detail keluhan teknis dan catatan kendala operasional yang dilaporkan oleh pengguna</p>
</div>
<!-- Problem Description Callout -->
<div class="rounded-xl border border-slate-200/70 bg-[#f8fafc] p-4 flex items-start gap-3" data-field="issue_description_wrapper">
<div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center shrink-0 mt-0.5">
<svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 24 24">
<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
</svg>
</div>
<div class="space-y-1">
<h4 class="text-xs font-bold text-slate-800">Deskripsi Masalah</h4>
<p class="text-xs text-slate-600 leading-relaxed" data-field="issue_description">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit animi id est laborum.
                </p>
</div>
</div>
<!-- Attachments Section -->
<div class="space-y-3 pt-1">
<div class="flex items-center gap-2 text-xs font-bold text-slate-800">
<svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
</svg>
                Lampiran Berkas Pendukung
              </div>
<!-- Attachments Layout (Document Card + Photo Container) -->
<div class="flex flex-col sm:flex-row items-stretch gap-4 pt-1">
<!-- Document Mini Card with interactive data attributes -->
<a class="w-full sm:w-60 border border-slate-200/90 rounded-xl p-3 flex items-center justify-between bg-white shadow-xs hover:border-slate-300 hover:shadow-sm transition-all group cursor-pointer text-left" data-attachment-id="att_1" data-download-url="/api/v1/tickets/TC-024/attachments/att_1/download" data-file-name="Lampiran Berkas Pendukung.pdf" data-file-size="2516582" href="/api/v1/tickets/TC-024/attachments/att_1/download" id="attachment-doc-card" onclick="handleAttachmentDownload(event, this)">
<div class="flex items-center gap-3 min-w-0">
<div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center shrink-0 group-hover:bg-sky-200 transition-colors">
<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.75" viewbox="0 0 24 24">
<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8z"></path>
<polyline points="14 2 14 8 20 8"></polyline>
</svg>
</div>
<div class="truncate">
<div class="text-xs font-bold text-slate-800 leading-snug group-hover:text-blue-600 transition-colors truncate">Lampiran Berkas Pendukung</div>
<div class="text-[10px] text-slate-400 mt-0.5">2.4 MB</div>
</div>
</div>
<span class="text-slate-400 group-hover:text-blue-600 pl-2 shrink-0" title="Unduh Berkas">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
</svg>
</span>
</a>
<!-- Attached Preview Placeholder -->
<div class="w-full sm:w-60 h-28 bg-[#dbe2ed] rounded-xl flex items-center justify-center border border-slate-200 relative group overflow-hidden" data-attachment-id="att_img_1" data-preview-url="/api/v1/tickets/TC-024/attachments/att_img_1/preview">
<svg class="w-10 h-10 text-slate-400" fill="currentColor" viewbox="0 0 24 24">
<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"></path>
</svg>
<span class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity text-white text-[11px] font-semibold gap-1.5 cursor-pointer backdrop-blur-2xs" onclick="showToast('Membuka pratinjau gambar...', 'info')">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
  Lihat Foto
</span>
</div>
</div>
</div>
</div>
</div>
<!-- END: LeftColumnContent -->
<!-- BEGIN: RightColumnContent -->
<div class="lg:col-span-4 space-y-6 w-full">
<!-- Ticket Validity Summary Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm text-center" data-purpose="ticket-validity-card" data-qr-payload="https://p-tams.internal/tickets/public/PTAMS-TC-024">
<!-- Header with Public QR button -->
<div class="flex items-center justify-between pb-4">
<h3 class="text-xs font-bold text-slate-800 tracking-wider">RINGKASAN VALIDITAS TIKET</h3>
<button class="px-2.5 py-1 text-[10px] font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md tracking-wider uppercase transition inline-flex items-center gap-1 active:scale-95" id="btn-copy-public-qr" onclick="copyPublicQrLink()" title="Salin Tautan Publik QR" type="button">
<svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                PUBLIC QR
              </button>
</div>
<!-- Big QR Card -->
<div class="bg-[#f8fafc] rounded-2xl p-5 sm:p-6 my-2 border border-slate-100 flex flex-col items-center max-w-xs mx-auto lg:max-w-none relative group">
<div class="w-40 h-40 sm:w-48 sm:h-48 bg-white p-3 rounded-xl shadow-xs border border-slate-200/60 flex items-center justify-center transition-transform group-hover:scale-[1.01]">
<!-- Standard High-fidelity Scalable Vector QR Code -->
<svg class="w-full h-full text-slate-700" fill="currentColor" viewbox="0 0 100 100">
<!-- Outer corners -->
<path d="M10 10 H35 V35 H10 Z M15 15 V30 H30 V15 Z M20 20 H25 V25 H20 Z"></path>
<path d="M65 10 H90 V35 H65 Z M70 15 V30 H85 V15 Z M75 20 H80 V25 H75 Z"></path>
<path d="M10 65 H35 V90 H10 Z M15 70 V85 H30 V70 Z M20 75 H25 V80 H20 Z"></path>
<!-- Data patterns -->
<rect height="15" width="5" x="42" y="10"></rect>
<rect height="8" width="5" x="52" y="10"></rect>
<rect height="5" width="15" x="42" y="30"></rect>
<rect height="10" width="10" x="45" y="40"></rect>
<rect height="5" width="10" x="10" y="42"></rect>
<rect height="10" width="8" x="25" y="45"></rect>
<rect height="5" width="12" x="65" y="42"></rect>
<rect height="10" width="8" x="82" y="42"></rect>
<rect height="10" width="10" x="65" y="55"></rect>
<rect height="12" width="6" x="40" y="60"></rect>
<rect height="6" width="6" x="52" y="62"></rect>
<rect height="6" width="12" x="78" y="68"></rect>
<rect height="6" width="18" x="40" y="80"></rect>
<rect height="8" width="8" x="68" y="82"></rect>
<rect height="8" width="8" x="82" y="82"></rect>
</svg>
</div>
<!-- ID string -->
<div class="mt-4 font-extrabold text-slate-800 text-sm tracking-wide" data-field="ticket_code">
                ID : PTAMS–TC-024
              </div>
<p class="text-[11px] text-slate-400 mt-2 leading-relaxed px-2 font-normal">
                Pindai barcode ini kapan saja menggunakan kamera ponsel untuk memantau status langsung tanpa login
              </p>
</div>
<!-- Summary Key Values -->
<div class="mt-5 space-y-3.5 text-xs text-left px-1">
<div class="flex items-center justify-between">
<span class="text-slate-600 font-medium">Nomor Registrasi :</span>
<span class="font-bold text-slate-900" data-field="registration_no">#TC-024</span>
</div>
<div class="flex items-center justify-between">
<span class="text-slate-600 font-medium">Prioritas Respon :</span>
<span class="px-3 py-1 rounded-md text-[11px] font-bold text-rose-600 border border-rose-500 bg-rose-50/50" data-field="priority_label">
                  Level 1 – Urgent
                </span>
</div>
</div>
</div>
<!-- Edit Report Status Card -->
<div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm" data-purpose="edit-status-form-card">
<h3 class="text-xs font-bold text-slate-900 tracking-wider">EDIT STATUS LAPORAN</h3>
<p class="text-[11px] text-slate-400 mt-1 leading-relaxed">
              Perbarui status dan catatan penanganan laporan.
            </p>
<form action="/api/v1/tickets/TC-024/status" class="mt-4 space-y-4" data-ticket-id="TC-024" id="ticketStatusForm" method="POST" novalidate="">
<!-- Dropdown: Status Laporan -->
<div>
<label class="block text-xs font-semibold text-slate-700 mb-1.5" for="status-select">
                  Status Laporan
                </label>
<div class="relative">
<select aria-label="Status Laporan" class="w-full text-xs font-medium text-slate-800 bg-white border border-slate-200 rounded-lg py-2.5 pl-3 pr-8 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400 appearance-none cursor-pointer" data-field="ticket_status" id="status-select" name="status" required="">
<option selected="" value="in_progress">Sedang Diproses</option>
<option value="pending_parts">Menunggu Konfirmasi</option>
<option value="completed">Selesai</option>
<option value="cancelled">Dibatalkan</option>
</select>
<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M19 9l-7 7-7-7"></path>
</svg>
</div>
</div>
</div>
<!-- Textarea: Catatan Penanganan -->
<div>
<div class="flex items-center justify-between mb-1.5">
<label class="block text-xs font-semibold text-slate-700" for="notes-textarea">
                    Catatan Penanganan
                  </label>
<span class="text-[10px] text-slate-400 font-mono" id="char-counter">0 / 1000 karakter</span>
</div>
<textarea class="w-full text-xs text-slate-700 bg-white border border-slate-200 rounded-lg p-3 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400 resize-none" data-field="notes" id="notes-textarea" maxlength="1000" name="resolution_notes" placeholder="Tuliskan hasil pemeriksaan atau tindakan perbaikan..." rows="4"></textarea>
</div>
<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
<button class="w-full sm:w-1/2 py-2 px-3 text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition-colors text-center active:scale-[0.98]" id="btn-cancel-status" type="button">
                  Batal
                </button>
<button class="w-full sm:w-1/2 py-2 px-3 text-xs font-bold text-white bg-[#0b192c] hover:bg-slate-800 rounded-lg transition-all shadow-sm text-center inline-flex items-center justify-center gap-1.5 disabled:opacity-60 disabled:cursor-not-allowed active:scale-[0.98]" data-state="idle" id="btn-submit-status" type="submit">
<span class="hidden" id="spinner-icon">
<svg class="animate-spin -ml-1 mr-1.5 h-3.5 w-3.5 text-white" fill="none" viewbox="0 0 24 24">
<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
<path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" fill="currentColor"></path>
</svg>
</span>
<span id="btn-submit-text">Simpan Perubahan</span>
</button>
</div>
</form>
</div>
</div>
<!-- END: RightColumnContent -->
</div>
</main>
</div>
<!-- END: MainContentWrapper -->
<!-- BEGIN: Production-Grade Toast Container -->
<div aria-atomic="true" aria-live="assertive" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm w-full pointer-events-none px-4 sm:px-0" id="toast-container"></div>
<!-- END: Production-Grade Toast Container -->
<script>
  // Mobile drawer controls
  function toggleMobileMenu() {
    const drawer = document.getElementById('mobile-drawer');
    const backdrop = document.getElementById('mobile-drawer-backdrop');
    if (!drawer || !backdrop) return;
    
    const isOpen = !drawer.classList.contains('-translate-x-full');
    if (isOpen) {
      drawer.classList.add('-translate-x-full');
      backdrop.classList.add('hidden');
    } else {
      drawer.classList.remove('-translate-x-full');
      backdrop.classList.remove('hidden');
    }
  }

  // Toast Notification System
  function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto toast-animate-in flex items-start gap-3 p-3.5 rounded-xl shadow-lg border text-xs leading-relaxed transition-all duration-300 ${
      type === 'success' 
        ? 'bg-slate-900 text-white border-slate-700' 
        : type === 'info'
        ? 'bg-[#0b192c] text-white border-slate-700'
        : 'bg-rose-900 text-white border-rose-700'
    }`;

    const iconSvg = type === 'success'
      ? `<svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>`
      : type === 'info'
      ? `<svg class="w-4 h-4 text-sky-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
      : `<svg class="w-4 h-4 text-rose-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>`;

    toast.innerHTML = `
      ${iconSvg}
      <div class="flex-1 font-medium">${message}</div>
      <button type="button" aria-label="Tutup notifikasi" class="text-slate-400 hover:text-white transition-colors shrink-0 ml-1">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    `;

    // Dismiss click
    toast.querySelector('button').addEventListener('click', () => {
      toast.remove();
    });

    container.appendChild(toast);

    // Auto dismiss
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(10px) scale(0.95)';
      setTimeout(() => toast.remove(), 250);
    }, 4500);
  }

  // Copy QR Link
  function copyPublicQrLink() {
    const payload = document.querySelector('[data-purpose="ticket-validity-card"]')?.getAttribute('data-qr-payload') || 'https://p-tams.internal/tickets/public/PTAMS-TC-024';
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(payload).then(() => {
        showToast('Tautan QR Publik berhasil disalin ke clipboard!', 'info');
      }).catch(() => {
        showToast(`Tautan publik: ${payload}`, 'info');
      });
    } else {
      showToast(`Tautan publik: ${payload}`, 'info');
    }
  }

  // Attachment download simulation
  function handleAttachmentDownload(event, element) {
    event.preventDefault();
    const downloadUrl = element.getAttribute('data-download-url');
    const fileName = element.getAttribute('data-file-name') || 'Lampiran Berkas';
    showToast(`Mengunduh file: ${fileName} (${downloadUrl})`, 'info');
  }

  // DOM initialization & Form Handling
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('ticketStatusForm');
    const statusSelect = document.getElementById('status-select');
    const notesTextarea = document.getElementById('notes-textarea');
    const charCounter = document.getElementById('char-counter');
    const btnSubmit = document.getElementById('btn-submit-status');
    const btnCancel = document.getElementById('btn-cancel-status');
    const btnSubmitText = document.getElementById('btn-submit-text');
    const spinnerIcon = document.getElementById('spinner-icon');
    const searchForm = document.getElementById('global-search-form');

    // Baseline dirty tracking values
    const initialStatus = statusSelect ? statusSelect.value : '';
    const initialNotes = notesTextarea ? notesTextarea.value : '';

    function isFormDirty() {
      if (!statusSelect || !notesTextarea) return false;
      return statusSelect.value !== initialStatus || notesTextarea.value.trim() !== initialNotes.trim();
    }

    // Live Character Counter
    if (notesTextarea && charCounter) {
      const updateCharCount = () => {
        const len = notesTextarea.value.length;
        charCounter.textContent = `${len} / 1000 karakter`;
      };
      notesTextarea.addEventListener('input', updateCharCount);
      updateCharCount();
    }

    // Global Search submit handling
    if (searchForm) {
      searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const query = document.getElementById('global-search-input')?.value.trim();
        if (query) {
          showToast(`Mencari: "${query}"... (Mengalihkan ke ${searchForm.getAttribute('action')}?q=${encodeURIComponent(query)})`, 'info');
        } else {
          showToast('Masukkan kata kunci pencarian terlebih dahulu.', 'error');
        }
      });
    }

    // Cancel Button with Unsaved Changes prompt
    if (btnCancel && form) {
      btnCancel.addEventListener('click', () => {
        if (isFormDirty()) {
          const confirmReset = window.confirm('Terdapat perubahan yang belum disimpan. Batalkan dan kembalikan ke nilai awal?');
          if (!confirmReset) return;
        }
        if (statusSelect) statusSelect.value = initialStatus;
        if (notesTextarea) {
          notesTextarea.value = initialNotes;
          if (charCounter) charCounter.textContent = `${initialNotes.length} / 1000 karakter`;
        }
        showToast('Formulir telah dikembalikan ke status semula.', 'info');
      });
    }

    // Form Submit handling with realistic API state
    if (form && btnSubmit) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();

        // Loading state
        btnSubmit.disabled = true;
        btnSubmit.setAttribute('data-state', 'loading');
        if (btnSubmitText) btnSubmitText.textContent = 'Menyimpan...';
        if (spinnerIcon) spinnerIcon.classList.remove('hidden');

        const selectedStatusText = statusSelect.options[statusSelect.selectedIndex]?.text || 'Sedang Diproses';
        const selectedValue = statusSelect.value;
        const notes = notesTextarea.value;
        const ticketId = form.getAttribute('data-ticket-id') || 'TC-024';

        // Simulate network API request delay (750ms)
        setTimeout(() => {
          // Reset button state
          btnSubmit.disabled = false;
          btnSubmit.setAttribute('data-state', 'idle');
          if (btnSubmitText) btnSubmitText.textContent = 'Simpan Perubahan';
          if (spinnerIcon) spinnerIcon.classList.add('hidden');

          // Update header status indicators dynamically
          const headerStatusText = document.getElementById('header-status-text');
          const headerStatusDot = document.getElementById('header-status-dot');
          const statusContainer = document.querySelector('[data-field="display-status"]');

          if (headerStatusText) headerStatusText.textContent = selectedStatusText;
          if (statusContainer) statusContainer.setAttribute('data-status', selectedValue);

          if (headerStatusDot) {
            headerStatusDot.className = 'w-2 h-2 rounded-full inline-block ' + 
              (selectedValue === 'completed' ? 'bg-emerald-500' :
               selectedValue === 'cancelled' ? 'bg-slate-400' :
               selectedValue === 'pending_parts' ? 'bg-sky-500' : 'bg-amber-500');
          }
          if (headerStatusText) {
            headerStatusText.parentElement.className = 'flex items-center gap-1.5 text-xs font-bold mt-0.5 ' +
              (selectedValue === 'completed' ? 'text-emerald-600' :
               selectedValue === 'cancelled' ? 'text-slate-600' :
               selectedValue === 'pending_parts' ? 'text-sky-600' : 'text-amber-500');
          }

          // Trigger realistic success feedback
          showToast(`Status tiket #${ticketId} berhasil diperbarui ke server (HTTP 200 OK)`, 'success');
        }, 750);
      });
    }

    // Keyboard accessibility: ESC to close mobile drawer
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const drawer = document.getElementById('mobile-drawer');
        if (drawer && !drawer.classList.contains('-translate-x-full')) {
          toggleMobileMenu();
        }
      }
    });
  });
</script>
</body></html>