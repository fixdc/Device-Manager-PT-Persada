<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Kelola User - P-TAMS</title>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Inter -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              navy: '#0f1f38',
              hoverNavy: '#172b4d',
              border: '#e2e8f0',
              muted: '#64748b',
              danger: '#b91c1c',
            }
          }
        }
      }
    }
  </script>
<style data-purpose="custom-typography">
    body {
      font-family: 'Inter', sans-serif;
      color: #0f172a;
      background-color: #ffffff;
      -webkit-font-smoothing: antialiased;
    }
  </style>
</head>
<body class="min-h-screen bg-white text-slate-800 flex flex-col justify-between">
<!-- BEGIN: Toast Notification Container -->
<div class="fixed top-5 right-5 z-[100] flex flex-col gap-2 pointer-events-none" id="toastContainer"></div>
<!-- END: Toast Notification Container -->
<!-- BEGIN: Mobile Sidebar Backdrop Overlay -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity lg:hidden" id="sidebarBackdrop"></div>
<!-- END: Mobile Sidebar Backdrop Overlay -->
<!-- BEGIN: ApplicationLayout -->
<div class="flex min-h-screen w-full relative">
<!-- BEGIN: Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-[280px] shrink-0 border-r border-slate-200 bg-white flex flex-col justify-between p-6 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-auto" id="sidebarDrawer">
<!-- Top Section: Brand & Nav Links -->
<div>
<!-- Brand Logo & Mobile Close Button -->
<div class="flex items-center justify-between px-2 py-4 mb-6 lg:mb-8">
<div class="flex items-center gap-2">
<!-- Logo Icon -->
<svg class="w-8 h-8 text-[#0f1f38]" fill="currentColor" viewbox="0 0 32 32">
<path d="M14 6C9.58 6 6 9.58 6 14C6 18.42 9.58 22 14 22V6Z"></path>
<path d="M18 10C21.31 10 24 12.69 24 16C24 19.31 21.31 22 18 22V10Z"></path>
</svg>
<span class="text-2xl font-bold tracking-tight text-[#0f1f38]">P-TAMS</span>
</div>
<button aria-label="Tutup Menu" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100 lg:hidden" id="btnCloseSidebar" type="button">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12"></path>
</svg>
</button>
</div>
<!-- Navigation Menu -->
<nav class="space-y-1.5 font-medium text-sm text-slate-600">
<!-- Nav Item: Dashboard -->
<a class="flex items-center gap-3.5 px-4 py-2.5 rounded-lg hover:bg-slate-50 transition-colors text-slate-700" href="#">
<svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="7" rx="1.5" width="7" x="3" y="3"></rect>
<rect height="7" rx="1.5" width="7" x="14" y="3"></rect>
<rect height="7" rx="1.5" width="7" x="3" y="14"></rect>
<rect height="7" rx="1.5" width="7" x="14" y="14"></rect>
</svg>
<span>Dashboard</span>
</a>
<!-- Nav Item: Kelola Device -->
<a class="flex items-center gap-3.5 px-4 py-2.5 rounded-lg hover:bg-slate-50 transition-colors text-slate-700" href="#">
<svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="13" rx="2" width="20" x="2" y="4"></rect>
<path d="M8 21h8m-4-4v4"></path>
</svg>
<span>Kelola Device</span>
</a>
<!-- Nav Item: Kelola User (Active) -->
<a class="flex items-center gap-3.5 px-4 py-2.5 rounded-lg bg-[#0f1f38] text-white shadow-sm font-medium" href="#">
<svg class="w-5 h-5 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
<span>Kelola User</span>
</a>
<!-- Nav Item: Kelola Ticket -->
<a class="flex items-center gap-3.5 px-4 py-2.5 rounded-lg hover:bg-slate-50 transition-colors text-slate-700" href="#">
<svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="12" rx="2" width="20" x="2" y="6"></rect>
<path d="M6 12h.01M18 12h.01M9 12h6"></path>
</svg>
<span>Kelola Ticket</span>
</a>
<!-- Nav Item: Riwayat Kerusakan -->
<a class="flex items-center gap-3.5 px-4 py-2.5 rounded-lg hover:bg-slate-50 transition-colors text-slate-700" href="#">
<svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
<path d="M3 3v5h5"></path>
<path d="M12 7v5l3 3"></path>
</svg>
<span>Riwayat Kerusakan</span>
</a>
<!-- Nav Item: Logout -->
<a class="flex items-center gap-3.5 px-4 py-2.5 rounded-lg hover:bg-red-50 text-red-600 transition-colors pt-3" href="#">
<svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
<polyline points="16 17 21 12 16 7"></polyline>
<line x1="21" x2="9" y1="12" y2="12"></line>
</svg>
<span>Logout</span>
</a>
</nav>
</div>
<!-- Bottom Card: QR Scan Promo Box -->
<div class="bg-[#0b1626] rounded-xl p-5 text-white flex flex-col mt-6 shadow-sm">
<div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mb-3.5 text-[#0b1626]">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<rect height="7" rx="1" width="7" x="3" y="3"></rect>
<rect height="7" rx="1" width="7" x="14" y="3"></rect>
<rect height="7" rx="1" width="7" x="3" y="14"></rect>
<path d="M14 14h3v3h-3z"></path>
<path d="M20 14v3h-3"></path>
<path d="M14 20h6"></path>
</svg>
</div>
<h4 class="font-bold text-base tracking-tight leading-snug mb-2">Scan<br/>QR Perangkat</h4>
<p class="text-[12px] text-slate-300 leading-relaxed mb-4">
          Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.
        </p>
<button class="w-full bg-[#394960] hover:bg-[#485b75] text-white text-xs font-semibold py-2.5 px-4 rounded-lg transition-colors">
          Mulai Scan QR
        </button>
</div>
</aside>
<!-- END: Sidebar -->
<!-- BEGIN: MainContentWrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white">
<!-- BEGIN: TopHeader -->
<header class="h-16 sm:h-20 border-b border-slate-100 flex items-center justify-between px-4 sm:px-6 lg:px-10 shrink-0 gap-3">
<!-- Left side on mobile: Hamburger and Logo brand -->
<div class="flex items-center gap-3">
<button aria-label="Buka Menu" class="p-2 -ml-1 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 lg:hidden focus:outline-none" id="btnOpenSidebar" type="button">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<line x1="3" x2="21" y1="12" y2="12"></line>
<line x1="3" x2="21" y1="6" y2="6"></line>
<line x1="3" x2="21" y1="18" y2="18"></line>
</svg>
</button>
<div class="flex items-center gap-1.5 lg:hidden">
<svg class="w-6 h-6 text-[#0f1f38]" fill="currentColor" viewbox="0 0 32 32">
<path d="M14 6C9.58 6 6 9.58 6 14C6 18.42 9.58 22 14 22V6Z"></path>
<path d="M18 10C21.31 10 24 12.69 24 16C24 19.31 21.31 22 18 22V10Z"></path>
</svg>
<span class="text-xl font-bold tracking-tight text-[#0f1f38]">P-TAMS</span>
</div>
<!-- Global Search Bar for Desktop/Tablet -->
<div class="hidden sm:block sm:w-72 md:w-96 lg:w-[460px]">
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" x2="16.65" y1="21" y2="16.65"></line>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="headerGlobalSearch" placeholder="Lakukan pencarian..." type="text"/>
</div>
</div>
</div>
<!-- Right Side: Notification & User Avatar -->
<div class="flex items-center gap-2 sm:gap-6">
<!-- Mobile search icon toggle -->
<button aria-label="Cari" class="p-2 text-slate-600 hover:text-slate-800 transition-colors sm:hidden" onclick="const s = document.getElementById('mobileHeaderSearch'); s.classList.toggle('hidden');">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" x2="16.65" y1="21" y2="16.65"></line>
</svg>
</button>
<!-- Notification Icon with Indicator -->
<button aria-label="Notifikasi" class="relative p-2 text-slate-600 hover:text-slate-800 transition-colors">
<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
</svg>
<span class="absolute top-1.5 right-1.5 sm:top-2 sm:right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
</button>
<!-- User Info Pill -->
<div class="flex items-center gap-2.5 sm:gap-3">
<img alt="Fikri" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border border-slate-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD41vu7pGJceLygUfvc65JaRparJJKrTISksYMcjhVB6TI5pKjH-v9tiDRKNEkxQCNVdeZ9XPz4YoBKMZyszuUEWiVECzsKge15KvIe3N8cEhC-bu_a20raMwqr8irnLHteVVqMcRhxGVbCMQmr5HQJcQyzzzJQbsEDzM_uslh8mzfRQlCjvPQGLsSYYLaQtpk2qC7Hqa-vpZlOaCGL-rgYM_OXcgHwd9VXykklKrs"/>
<div class="flex flex-col text-left">
<span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">Fikri</span>
<span class="text-[10px] sm:text-xs text-slate-400">Admin</span>
</div>
</div>
</div>
</header>
<!-- Mobile Search expandable row -->
<div class="hidden px-4 py-2.5 bg-slate-50 border-b border-slate-200 sm:hidden" id="mobileHeaderSearch">
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" x2="16.65" y1="21" y2="16.65"></line>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" id="mobileSearchInput" placeholder="Lakukan pencarian..." type="text"/>
</div>
</div>
<!-- END: TopHeader -->
<!-- BEGIN: PageContent -->
<main class="flex-1 p-4 sm:p-6 lg:p-10 overflow-y-auto">
<!-- Title & Subtitle -->
<div class="mb-5 sm:mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
<div>
<h1 class="text-2xl sm:text-[32px] font-bold text-slate-950 tracking-tight leading-tight">Kelola User</h1>
<p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
            Otorisasi hak akses, peran struktural, dan alokasi divisi personel EnterpriseAsset Core P-TAMS
          </p>
</div>
<div class="text-xs font-semibold text-slate-500 self-start sm:self-auto bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200/80">
          Total Pengguna: <span class="text-slate-900 font-bold" id="totalUserCount">7</span>
</div>
</div>
<!-- Filter & Action Controls -->
<div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 mb-6">
<!-- Search in Table -->
<div class="relative flex-1 sm:max-w-xs md:max-w-md lg:max-w-2xl">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" x2="16.65" y1="21" y2="16.65"></line>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-300" id="tableSearchInput" placeholder="Lakukan pencarian..." type="text"/>
</div>
<!-- Dropdown & Add Button Group -->
<div class="flex items-center gap-2.5 sm:gap-3.5">
<!-- Type / Role Filter Custom Dropdown -->
<div class="relative flex-1 sm:flex-initial" id="typeDropdownContainer">
<button aria-expanded="false" aria-haspopup="listbox" class="inline-flex items-center justify-between w-full sm:w-36 px-3.5 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-1 focus:ring-slate-300 transition-colors shadow-sm" id="btnTypeDropdown" type="button">
<div class="inline-flex items-center gap-2 truncate">
<span class="w-2 h-2 rounded-full bg-slate-400" id="filterDotIndicator"></span>
<span class="truncate" id="typeDropdownLabel">Type</span>
</div>
<svg class="w-4 h-4 text-slate-500 ml-2 shrink-0 transition-transform duration-200" fill="none" id="dropdownChevron" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M19 9l-7 7-7-7"></path>
</svg>
</button>
<!-- Dropdown Options Menu -->
<div class="absolute right-0 top-full mt-1.5 w-48 bg-white border border-slate-200 rounded-xl shadow-lg py-1.5 hidden z-30 divide-y divide-slate-100" id="typeDropdownMenu" role="listbox">
<div class="p-1 space-y-0.5">
<!-- Option 1: Semua Tipe -->
<button class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 rounded-lg transition-colors text-left" data-value="ALL" role="option" type="button">
<div class="flex items-center gap-2.5">
<span class="w-2 h-2 rounded-full bg-slate-400"></span>
<span>Semua Tipe</span>
</div>
<svg class="w-3.5 h-3.5 text-slate-800 check-mark" fill="none" stroke="currentColor" stroke-width="2.5" viewbox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
</button>
<!-- Option 2: User -->
<button class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 rounded-lg transition-colors text-left" data-value="User" role="option" type="button">
<div class="flex items-center gap-2.5">
<span class="w-2 h-2 rounded-full bg-emerald-500"></span>
<span>User</span>
</div>
<span class="px-1.5 py-0.5 text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded">Pelapor</span>
</button>
<!-- Option 3: Teknisi -->
<button class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 rounded-lg transition-colors text-left" data-value="Teknisi" role="option" type="button">
<div class="flex items-center gap-2.5">
<span class="w-2 h-2 rounded-full bg-amber-500"></span>
<span>Teknisi</span>
</div>
<span class="px-1.5 py-0.5 text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded">Servis</span>
</button>
<!-- Option 4: Admin -->
<button class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 rounded-lg transition-colors text-left" data-value="Admin" role="option" type="button">
<div class="flex items-center gap-2.5">
<span class="w-2 h-2 rounded-full bg-blue-600"></span>
<span>Admin</span>
</div>
<span class="px-1.5 py-0.5 text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-200 rounded">Sistem</span>
</button>
</div>
</div>
</div>
<!-- Add User Button -->
<button class="inline-flex items-center justify-center gap-2 bg-[#0f1f38] hover:bg-[#1a2f52] text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg text-sm font-semibold transition-colors shrink-0 shadow-sm" id="btnTambahUser" type="button">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewbox="0 0 24 24">
<line x1="12" x2="12" y1="5" y2="19"></line>
<line x1="5" x2="19" y1="12" y2="12"></line>
</svg>
<span>Tambah User</span>
</button>
</div>
</div>
<!-- ============================================================== -->
<!-- DESKTOP & TABLET VIEW: Table Layout (Hidden on Mobile < md) -->
<!-- ============================================================== -->
<div class="hidden md:block border border-slate-200 rounded-xl overflow-x-auto bg-white shadow-sm" id="desktopTableContainer">
<table class="w-full text-left border-collapse min-w-[700px]">
<thead>
<tr class="border-b border-slate-200 bg-slate-50/70 text-slate-800 text-sm font-bold">
<th class="py-4 px-6 lg:px-8 w-16 lg:w-20 text-center" scope="col">No</th>
<th class="py-4 px-5 lg:px-6" scope="col">Nama Pengguna</th>
<th class="py-4 px-5 lg:px-6" scope="col">Email Pengguna</th>
<th class="py-4 px-5 lg:px-6" scope="col">Role</th>
<th class="py-4 px-5 lg:px-6 text-center w-52 lg:w-56" scope="col">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-sm text-slate-800 font-normal" id="userTableBody">
<!-- Dynamic Table Rows Rendered via JS -->
</tbody>
</table>
</div>
<!-- ============================================================== -->
<!-- MOBILE VIEW: Cards Layout (Visible only on screens < md) -->
<!-- ============================================================== -->
<div class="grid grid-cols-1 gap-3 md:hidden" id="mobileCardsContainer">
<!-- Dynamic Mobile Cards Rendered via JS -->
</div>
<!-- Empty State Container (Displayed when filter/search yields 0 records) -->
<div class="hidden py-14 px-4 text-center bg-white border border-slate-200 rounded-xl mt-2" id="emptyStateContainer">
<div class="w-14 h-14 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3.5">
<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" x2="16.65" y1="21" y2="16.65"></line>
<line x1="8" x2="14" y1="11" y2="11"></line>
</svg>
</div>
<h3 class="text-base font-bold text-slate-900 mb-1">Tidak ada data pengguna ditemukan</h3>
<p class="text-xs text-slate-500 max-w-sm mx-auto mb-4 leading-relaxed">
    Kueri pencarian atau filter tipe yang dipilih tidak cocok dengan akun manapun dalam sistem.
  </p>
<button class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors" id="btnResetFilter" type="button">
<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.038 8.038 0 01-15.357-2m15.357 2H15"></path>
</svg>
    Reset Filter Pencarian
  </button>
</div>
</main>
<!-- END: PageContent -->
</div>
<!-- END: MainContentWrapper -->
</div>
<!-- END: ApplicationLayout -->
<!-- ============================================================== -->
<!-- MODAL 1: Tambah Pengguna Baru (Source: IMAGE_3) -->
<!-- ============================================================== -->
<div class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-6 overflow-y-auto" id="modalTambahUser">
<!-- Backdrop -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity modal-close-trigger"></div>
<!-- Modal Dialog -->
<div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-auto my-auto z-10 overflow-hidden border border-slate-100 flex flex-col max-h-[92vh]">
<!-- Modal Header -->
<div class="p-5 sm:p-6 md:p-8 pb-4 sm:pb-5 flex items-start justify-between border-b border-slate-100 shrink-0">
<div>
<h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Tambah Pengguna Baru</h3>
<p class="text-xs sm:text-sm text-slate-500 mt-1">Lengkapi formulir di bawah ini untuk menambahkan akun pengguna baru ke sistem P-TAMS.</p>
</div>
<button aria-label="Tutup" class="modal-close-trigger text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors ml-2" type="button">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12"></path>
</svg>
</button>
</div>
<!-- Modal Body -->
<form class="p-5 sm:p-6 md:p-8 space-y-4 sm:space-y-5 overflow-y-auto flex-1" id="form-tambah-user">
<!-- Row: Nama Pengguna -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-center">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800" for="tambahNamaPengguna">
          Nama Pengguna <span class="text-red-500">*</span>
</label>
<div class="md:col-span-9 relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
<circle cx="12" cy="7" r="4"></circle>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="tambahNamaPengguna" name="nama_pengguna" placeholder="Contoh: Andi Pratama" required="" type="text"/>
</div>
</div>
<!-- Row: Email Pengguna -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-center">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800" for="tambahEmailPengguna">
          Email Pengguna <span class="text-red-500">*</span>
</label>
<div class="md:col-span-9 relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="16" rx="2" width="20" x="2" y="4"></rect>
<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="tambahEmailPengguna" name="email" placeholder="contoh: andi227@gmail.com" required="" type="email"/>
</div>
</div>
<!-- Row: Role / Peran -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-start pt-1">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800 md:pt-2">
          Role / Peran <span class="text-red-500">*</span>
</label>
<div class="md:col-span-9 grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3" id="tambahRoleGroup">
<!-- Card: User -->
<label class="role-selector-card relative flex items-center gap-3 p-3 sm:p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/30 cursor-pointer transition-all">
<input checked="" class="sr-only" name="role" type="radio" value="User"/>
<div class="w-4 h-4 rounded-full border border-emerald-500 flex items-center justify-center bg-white shrink-0 radio-circle">
<span class="w-2 h-2 rounded-full bg-emerald-600 radio-dot"></span>
</div>
<div>
<div class="font-bold text-sm text-slate-900 leading-tight">User</div>
<div class="text-[11px] text-slate-500 mt-0.5 leading-tight">Staff Pelapor &amp; Karyawan Umum</div>
</div>
</label>
<!-- Card: Teknisi -->
<label class="role-selector-card relative flex items-center gap-3 p-3 sm:p-3.5 rounded-xl border border-slate-200 bg-white cursor-pointer transition-all hover:border-slate-300">
<input class="sr-only" name="role" type="radio" value="Teknisi"/>
<div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white shrink-0 radio-circle">
<span class="w-2 h-2 rounded-full bg-amber-500 hidden radio-dot"></span>
</div>
<div>
<div class="font-bold text-sm text-slate-900 leading-tight">Teknisi</div>
<div class="text-[11px] text-slate-500 mt-0.5 leading-tight">Perbaikan &amp; Servis Aset</div>
</div>
</label>
<!-- Card: Admin -->
<label class="role-selector-card relative flex items-center gap-3 p-3 sm:p-3.5 rounded-xl border border-slate-200 bg-white cursor-pointer transition-all hover:border-slate-300">
<input class="sr-only" name="role" type="radio" value="Admin"/>
<div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white shrink-0 radio-circle">
<span class="w-2 h-2 rounded-full bg-blue-600 hidden radio-dot"></span>
</div>
<div>
<div class="font-bold text-sm text-slate-900 leading-tight">Admin</div>
<div class="text-[11px] text-slate-500 mt-0.5 leading-tight">Akses Penuh Kelola Sistem</div>
</div>
</label>
</div>
</div>
<!-- Row: Nomor Telepon / WhatsApp -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-center">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800" for="tambahPhonePengguna">
          Nomor Telepon / WhatsApp
        </label>
<div class="md:col-span-9 relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="tambahPhonePengguna" name="nomor_telepon" placeholder="0812-xxxx-xxxx" type="text"/>
</div>
</div>
<!-- Row: Departemen / Divisi -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-center">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800" for="tambahDeptPengguna">
          Departemen / Divisi <span class="text-red-500">*</span>
</label>
<div class="md:col-span-9 relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="20" rx="2" ry="2" width="16" x="4" y="2"></rect>
<path d="M9 22v-4h6v4"></path>
<path d="M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"></path>
</svg>
</span>
<select class="w-full pl-10 pr-10 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 appearance-none focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="tambahDeptPengguna" name="departemen" required="">
<option disabled="" selected="" value="">Pilih divisi / penanggung jawab</option>
<option value="POKJA - PPDP">POKJA - PPDP</option>
<option value="Teknik &amp; Infrastruktur">Teknik &amp; Infrastruktur</option>
<option value="Keuangan &amp; Logistik">Keuangan &amp; Logistik</option>
<option value="Operasional Kantor">Operasional Kantor</option>
</select>
<span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M19 9l-7 7-7-7"></path>
</svg>
</span>
</div>
</div>
<!-- Row: Kata Sandi Default -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-center">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800" for="inputTambahPassword">
          Kata Sandi Default <span class="text-red-500">*</span>
</label>
<div class="md:col-span-9 relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="11" rx="2" ry="2" width="18" x="3" y="11"></rect>
<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
</svg>
</span>
<input class="w-full pl-10 pr-10 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="inputTambahPassword" name="password" placeholder="Masukkan kata sandi awal (min. 8 karakter)" required="" type="password"/>
<button aria-label="Lihat kata sandi" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600" onclick="togglePasswordVisibility('inputTambahPassword')" type="button">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
<circle cx="12" cy="12" r="3"></circle>
</svg>
</button>
</div>
</div>
<!-- Row: Upload Foto -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-1.5 md:gap-3 items-start">
<label class="md:col-span-3 text-xs sm:text-sm font-semibold text-slate-800 md:pt-2">
          Upload Foto <span class="text-xs font-normal text-slate-400">(Opsional)</span>
</label>
<div class="md:col-span-9">
<input class="hidden" id="tambahAvatarInput" name="avatar" type="file"/>
<div class="border-2 border-dashed border-slate-200 hover:border-slate-300 rounded-xl p-4 sm:p-6 flex flex-col items-center justify-center text-center cursor-pointer transition-colors bg-slate-50/30" onclick="document.getElementById('tambahAvatarInput').click()">
<div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mb-2">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
<polyline points="17 8 12 3 7 8"></polyline>
<line x1="12" x2="12" y1="3" y2="15"></line>
</svg>
</div>
<p class="text-xs text-slate-700 font-medium">
<span class="underline font-semibold text-slate-900">Seret dan lepas file di sini</span>, atau klik untuk memilih
            </p>
<p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG (maks. 2 MB)</p>
</div>
</div>
</div>
<!-- Footer Buttons -->
<div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3">
<button class="modal-close-trigger w-full sm:w-auto px-6 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors text-center" type="button">
          Batal
        </button>
<button class="inline-flex items-center justify-center gap-2 bg-[#0f1f38] hover:bg-[#1a2f52] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto" type="submit">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewbox="0 0 24 24">
<line x1="12" x2="12" y1="5" y2="19"></line>
<line x1="5" x2="19" y1="12" y2="12"></line>
</svg>
<span>Tambah User</span>
</button>
</div>
</form>
</div>
</div>
<!-- ============================================================== -->
<!-- MODAL 2: Edit Pengguna (Source: IMAGE_1) -->
<!-- ============================================================== -->
<div class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-6 overflow-y-auto" id="modalEditUser">
<!-- Backdrop -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity modal-close-trigger"></div>
<!-- Modal Dialog -->
<div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-5xl mx-auto my-auto z-10 overflow-hidden border border-slate-100 flex flex-col max-h-[92vh]">
<!-- Modal Header -->
<div class="p-5 sm:p-6 md:p-8 pb-4 sm:pb-5 flex items-start justify-between border-b border-slate-100 shrink-0">
<div>
<h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Edit Pengguna</h3>
<p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui formulir di bawah ini untuk memperbarui akun pengguna di sistem P-TAMS.</p>
</div>
<button aria-label="Tutup" class="modal-close-trigger text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors ml-2" type="button">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12"></path>
</svg>
</button>
</div>
<!-- Modal Body: 2 Columns on desktop, single column on mobile/tablet -->
<form class="p-5 sm:p-6 md:p-8 space-y-6 overflow-y-auto flex-1" id="form-edit-user">
<input id="editUserIdHidden" name="user_id" type="hidden"/>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-10">
<!-- Left Column: INFORMASI DASAR PENGGUNA -->
<div class="space-y-4">
<div>
<h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Informasi Dasar Pengguna</h4>
<p class="text-xs text-slate-400 mt-0.5">Identitas utama akun dan kontak dinas pengguna</p>
</div>
<!-- Nama Pengguna -->
<div class="space-y-1.5">
<label class="text-xs font-semibold text-slate-700" for="editNamaPengguna">Nama Pengguna <span class="text-red-500">*</span></label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
<circle cx="12" cy="7" r="4"></circle>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 sm:py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="editNamaPengguna" name="nama_pengguna" required="" type="text" value=""/>
</div>
</div>
<!-- Email Pengguna -->
<div class="space-y-1.5">
<label class="text-xs font-semibold text-slate-700" for="editEmailPengguna">Email Pengguna <span class="text-red-500">*</span></label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="16" rx="2" width="20" x="2" y="4"></rect>
<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 sm:py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="editEmailPengguna" name="email" required="" type="email" value=""/>
</div>
</div>
<!-- Nomor Telepon / WhatsApp -->
<div class="space-y-1.5">
<label class="text-xs font-semibold text-slate-700" for="editPhonePengguna">Nomor Telepon / WhatsApp</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
</svg>
</span>
<input class="w-full pl-10 pr-4 py-2 sm:py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="editPhonePengguna" name="nomor_telepon" type="text" value=""/>
</div>
</div>
<!-- Departemen / Divisi -->
<div class="space-y-1.5">
<label class="text-xs font-semibold text-slate-700" for="editDeptPengguna">Departemen / Divisi <span class="text-red-500">*</span></label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="20" rx="2" ry="2" width="16" x="4" y="2"></rect>
<path d="M9 22v-4h6v4"></path>
<path d="M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"></path>
</svg>
</span>
<select class="w-full pl-10 pr-10 py-2 sm:py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-700 appearance-none focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="editDeptPengguna" name="departemen" required="">
<option value="POKJA - PPDP">POKJA - PPDP</option>
<option value="Teknik &amp; Infrastruktur">Teknik &amp; Infrastruktur</option>
<option value="Keuangan &amp; Logistik">Keuangan &amp; Logistik</option>
<option value="Operasional Kantor">Operasional Kantor</option>
</select>
<span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M19 9l-7 7-7-7"></path>
</svg>
</span>
</div>
</div>
<!-- Ubah Kata Sandi (Opsional) -->
<div class="space-y-1.5">
<label class="text-xs font-semibold text-slate-700" for="inputEditPassword">Ubah Kata Sandi <span class="text-xs font-normal text-slate-400">(Opsional)</span></label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<rect height="11" rx="2" ry="2" width="18" x="3" y="11"></rect>
<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
</svg>
</span>
<input class="w-full pl-10 pr-10 py-2 sm:py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-400 focus:border-slate-400" id="inputEditPassword" name="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi" type="password"/>
<button aria-label="Lihat kata sandi" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600" onclick="togglePasswordVisibility('inputEditPassword')" type="button">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
<circle cx="12" cy="12" r="3"></circle>
</svg>
</button>
</div>
</div>
</div>
<!-- Right Column: HAK AKSES & FOTO PROFIL -->
<div class="space-y-4">
<div>
<h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Hak Akses &amp; Foto Profil</h4>
<p class="text-xs text-slate-400 mt-0.5">Atur kewenangan sistem dan foto avatar pengguna</p>
</div>
<!-- Role / Peran Cards -->
<div class="space-y-1.5">
<label class="text-xs font-semibold text-slate-700">Role / Peran <span class="text-red-500">*</span></label>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5" id="editRoleGroup">
<!-- User Option -->
<label class="edit-role-card relative flex flex-row sm:flex-col justify-between items-center sm:items-stretch p-3 rounded-xl border border-slate-200 bg-white cursor-pointer transition-all" data-role="User">
<input class="sr-only" name="role" type="radio" value="User"/>
<div class="flex items-center justify-between w-full">
<span class="font-bold text-sm text-slate-900">User</span>
<div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white ml-2 radio-circle">
<span class="w-2 h-2 rounded-full bg-emerald-600 hidden radio-dot"></span>
</div>
</div>
<span class="text-[11px] text-slate-500 mt-1 leading-tight hidden sm:block">Staff Pelapor &amp; Karyawan</span>
</label>
<!-- Teknisi Option -->
<label class="edit-role-card relative flex flex-row sm:flex-col justify-between items-center sm:items-stretch p-3 rounded-xl border border-slate-200 bg-white cursor-pointer transition-all" data-role="Teknisi">
<input class="sr-only" name="role" type="radio" value="Teknisi"/>
<div class="flex items-center justify-between w-full">
<span class="font-bold text-sm text-slate-900">Teknisi</span>
<div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white ml-2 radio-circle">
<span class="w-2 h-2 rounded-full bg-amber-500 hidden radio-dot"></span>
</div>
</div>
<span class="text-[11px] text-slate-500 mt-1 leading-tight hidden sm:block">Perbaikan &amp; Servis Aset</span>
</label>
<!-- Admin Option -->
<label class="edit-role-card relative flex flex-row sm:flex-col justify-between items-center sm:items-stretch p-3 rounded-xl border border-slate-200 bg-white cursor-pointer transition-all" data-role="Admin">
<input class="sr-only" name="role" type="radio" value="Admin"/>
<div class="flex items-center justify-between w-full">
<span class="font-bold text-sm text-slate-900">Admin</span>
<div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white ml-2 radio-circle">
<span class="w-2 h-2 rounded-full bg-blue-600 hidden radio-dot"></span>
</div>
</div>
<span class="text-[11px] text-slate-500 mt-1 leading-tight hidden sm:block">Akses Penuh Kelola Sistem</span>
</label>
</div>
</div>
<!-- Existing Avatar Card & Dropzone -->
<div class="space-y-2 pt-1">
<label class="text-xs font-semibold text-slate-700">Upload Foto Profil <span class="text-xs font-normal text-slate-400">(Opsional)</span></label>
<input class="hidden" id="editAvatarInput" name="avatar" type="file"/>
<!-- Existing Avatar Box -->
<div class="flex items-center justify-between p-3 bg-slate-50/70 border border-slate-200 rounded-xl">
<div class="flex items-center gap-3">
<img alt="Preview Avatar" class="w-9 h-9 rounded-full object-cover border border-slate-200 shrink-0" id="editAvatarPreviewImg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD41vu7pGJceLygUfvc65JaRparJJKrTISksYMcjhVB6TI5pKjH-v9tiDRKNEkxQCNVdeZ9XPz4YoBKMZyszuUEWiVECzsKge15KvIe3N8cEhC-bu_a20raMwqr8irnLHteVVqMcRhxGVbCMQmr5HQJcQyzzzJQbsEDzM_uslh8mzfRQlCjvPQGLsSYYLaQtpk2qC7Hqa-vpZlOaCGL-rgYM_OXcgHwd9VXykklKrs"/>
<div class="text-left overflow-hidden">
<div class="text-xs font-semibold text-slate-900 truncate" id="editAvatarFilename">profile_avatar.png</div>
<div class="text-[11px] text-slate-400">Foto profil saat ini (Tersimpan)</div>
</div>
</div>
<span class="px-2.5 py-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/70 rounded-md shrink-0">
                Tersimpan
              </span>
</div>
<!-- Upload Dropzone -->
<div class="border-2 border-dashed border-slate-200 hover:border-slate-300 rounded-xl p-4 sm:p-5 flex flex-col items-center justify-center text-center cursor-pointer transition-colors bg-white" onclick="document.getElementById('editAvatarInput').click()">
<div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 mb-1.5">
<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewbox="0 0 24 24">
<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
<polyline points="17 8 12 3 7 8"></polyline>
<line x1="12" x2="12" y1="3" y2="15"></line>
</svg>
</div>
<p class="text-xs text-slate-700 font-medium">
<span class="underline font-semibold text-slate-900">Seret dan lepas file di sini</span>, atau klik untuk memilih
              </p>
<p class="text-[11px] text-slate-400 mt-0.5">Format: JPG, PNG (maks. 2 MB)</p>
</div>
</div>
</div>
</div>
<!-- Modal Footer -->
<div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3">
<button class="modal-close-trigger w-full sm:w-auto px-6 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors text-center" type="button">
          Batal
        </button>
<button class="inline-flex items-center justify-center gap-2 bg-[#0f1f38] hover:bg-[#1a2f52] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto" type="submit">
<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewbox="0 0 24 24">
<polyline points="20 6 9 17 4 12"></polyline>
</svg>
<span>Simpan Perubahan</span>
</button>
</div>
</form>
</div>
</div>
<!-- ============================================================== -->
<!-- MODAL 3: Konfirmasi Hapus Data (Source: IMAGE_2) -->
<!-- ============================================================== -->
<div class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 overflow-y-auto" id="modalDeleteUser">
<!-- Backdrop -->
<div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity modal-close-trigger"></div>
<!-- Modal Dialog Box -->
<div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-[480px] mx-auto my-auto z-10 overflow-hidden border border-slate-100 p-5 sm:p-7 flex flex-col animate-in fade-in zoom-in-95 duration-150">
<!-- Form wrapper for delete action -->
<form id="form-delete-user">
<input id="deleteUserIdHidden" name="user_id" type="hidden"/>
<!-- Header with Icon & Close Button -->
<div class="flex items-start justify-between mb-4">
<div class="flex items-center gap-3.5">
<div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shrink-0 border border-red-100">
<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<polyline points="3 6 5 6 21 6"></polyline>
<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
<line x1="10" x2="10" y1="11" y2="17"></line>
<line x1="14" x2="14" y1="11" y2="17"></line>
</svg>
</div>
<div>
<h3 class="text-lg sm:text-xl font-bold text-slate-900 leading-tight">Konfirmasi Hapus Data</h3>
<div class="text-[10px] sm:text-[11px] font-bold tracking-wider text-slate-400 uppercase mt-0.5">AKSI KRITIS • PERLU KONFIRMASI</div>
</div>
</div>
<button aria-label="Tutup" class="modal-close-trigger text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors" type="button">
<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M6 18L18 6M6 6l12 12"></path>
</svg>
</button>
</div>
<!-- Body Description -->
<div class="space-y-3 sm:space-y-4 text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
<p>
        Apakah Anda yakin ingin menghapus data <strong class="text-slate-900 font-semibold" id="deleteTargetName">pengguna ini</strong>? Tindakan ini bersifat <strong class="text-slate-900 font-semibold">permanen</strong> dan data yang telah dihapus tidak dapat dipulihkan kembali dari sistem P-TAMS.
      </p>
<!-- Warning Box -->
<div class="p-3 sm:p-3.5 bg-amber-50/80 border border-amber-200 rounded-xl flex items-start gap-2.5 text-xs text-amber-900 leading-normal">
<svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
<line x1="12" x2="12" y1="9" y2="13"></line>
<line x1="12" x2="12.01" y1="17" y2="17"></line>
</svg>
<span>
<strong class="font-semibold text-amber-950">Perhatian:</strong> Semua riwayat aktivitas, relasi data, dan dependensi terkait data ini akan dinonaktifkan atau dihapus secara permanen dari basis data.
        </span>
</div>
</div>
<!-- Modal Action Buttons -->
<div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 sm:gap-3 pt-2">
<button class="modal-close-trigger w-full sm:w-auto px-5 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors text-center" type="button">
        Batal
      </button>
<button class="inline-flex items-center justify-center gap-2 bg-[#dc2626] hover:bg-[#b91c1c] text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto" type="submit">
<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24">
<polyline points="3 6 5 6 21 6"></polyline>
<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
</svg>
<span>Ya, Hapus Data</span>
</button>
</div>
</form>
</div>
</div>
<!-- ============================================================== -->
<!-- JAVASCRIPT: Backend-Ready State, Filtering & CRUD Operations -->
<!-- ============================================================== -->
<script>
  /**
   * P-TAMS User Management State
   */
  const defaultUsers = [
    { id: 1, name: "Andi Pratama", email: "andi227@gmail.com", role: "User", phone: "0812-9842-1102", department: "POKJA - PPDP", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuD41vu7pGJceLygUfvc65JaRparJJKrTISksYMcjhVB6TI5pKjH-v9tiDRKNEkxQCNVdeZ9XPz4YoBKMZyszuUEWiVECzsKge15KvIe3N8cEhC-bu_a20raMwqr8irnLHteVVqMcRhxGVbCMQmr5HQJcQyzzzJQbsEDzM_uslh8mzfRQlCjvPQGLsSYYLaQtpk2qC7Hqa-vpZlOaCGL-rgYM_OXcgHwd9VXykklKrs", createdAt: "2024-01-15" },
    { id: 2, name: "Siti Aisyah", email: "siti123@gmail.com", role: "Teknisi", phone: "0813-7721-9988", department: "Teknik & Infrastruktur", avatar: null, createdAt: "2024-02-10" },
    { id: 3, name: "Budi Santoso", email: "budi456@gmail.com", role: "User", phone: "0852-3341-9012", department: "Keuangan & Logistik", avatar: null, createdAt: "2024-02-18" },
    { id: 4, name: "Rina Wulandari", email: "rina89@gmail.com", role: "Teknisi", phone: "0821-5542-1200", department: "Teknik & Infrastruktur", avatar: null, createdAt: "2024-03-01" },
    { id: 5, name: "Dewi Lestari", email: "dewi321@gmail.com", role: "User", phone: "0819-4456-1188", department: "POKJA - PPDP", avatar: null, createdAt: "2024-03-12" },
    { id: 6, name: "Rina Anggraini", email: "rina77@gmail.com", role: "Teknisi", phone: "0857-9912-3344", department: "Teknik & Infrastruktur", avatar: null, createdAt: "2024-03-25" },
    { id: 7, name: "Dewi Puspita", email: "dewi99@gmail.com", role: "User", phone: "0812-7890-4411", department: "POKJA - PPDP", avatar: null, createdAt: "2024-04-02" }
  ];

  let users = [...defaultUsers];
  let currentSearchQuery = "";
  let currentRoleFilter = "ALL"; // 'ALL', 'User', 'Teknisi', 'Admin'

  /**
   * Helper to get initials
   */
  function getInitials(name) {
    if (!name) return "US";
    const parts = name.trim().split(" ");
    if (parts.length >= 2) {
      return (parts[0][0] + parts[1][0]).toUpperCase();
    }
    return parts[0].slice(0, 2).toUpperCase();
  }

  /**
   * Role badge styling helper
   */
  function getRoleBadge(role) {
    if (role === 'Admin') {
      return '<span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Admin</span>';
    }
    if (role === 'Teknisi') {
      return '<span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Teknisi</span>';
    }
    return '<span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">User</span>';
  }

  /**
   * Toast notification feedback
   */
  function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border text-sm font-medium transition-all duration-300 transform translate-y-2 opacity-0 ' + 
      (type === 'success' ? 'bg-[#0f1f38] text-white border-slate-700' : 'bg-red-600 text-white border-red-700');

    const iconSvg = type === 'success' 
      ? '<svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>'
      : '<svg class="w-4 h-4 text-red-200 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

    toast.innerHTML = `${iconSvg}<span>${message}</span>`;
    container.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
      toast.classList.remove('translate-y-2', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');
    });

    // Auto dismiss after 3.5s
    setTimeout(() => {
      toast.classList.remove('opacity-100', 'translate-y-0');
      toast.classList.add('opacity-0', '-translate-y-2');
      setTimeout(() => toast.remove(), 300);
    }, 3500);
  }

  /**
   * Modal Show / Hide
   */
  function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  }

  function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    const anyOpen = document.querySelectorAll('#modalTambahUser.flex, #modalEditUser.flex, #modalDeleteUser.flex').length > 0;
    const isSidebarOpen = !document.getElementById('sidebarDrawer').classList.contains('-translate-x-full');
    if (!anyOpen && (!isSidebarOpen || window.innerWidth >= 1024)) {
      document.body.classList.remove('overflow-hidden');
    }
  }

  function closeAllModals() {
    ['modalTambahUser', 'modalEditUser', 'modalDeleteUser'].forEach(id => closeModal(id));
  }

  function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  }

  /**
   * Off-canvas Sidebar handlers
   */
  function openSidebar() {
    const drawer = document.getElementById('sidebarDrawer');
    const backdrop = document.getElementById('sidebarBackdrop');
    if (drawer && backdrop) {
      drawer.classList.remove('-translate-x-full');
      backdrop.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    }
  }

  function closeSidebar() {
    const drawer = document.getElementById('sidebarDrawer');
    const backdrop = document.getElementById('sidebarBackdrop');
    if (drawer && backdrop) {
      drawer.classList.add('-translate-x-full');
      backdrop.classList.add('hidden');
      const anyModalOpen = document.querySelectorAll('#modalTambahUser.flex, #modalEditUser.flex, #modalDeleteUser.flex').length > 0;
      if (!anyModalOpen) {
        document.body.classList.remove('overflow-hidden');
      }
    }
  }

  /**
   * Filtered Data derivation
   */
  function getFilteredUsers() {
    const query = currentSearchQuery.trim().toLowerCase();
    return users.filter(user => {
      const matchRole = (currentRoleFilter === "ALL" || currentRoleFilter === "") ? true : (user.role === currentRoleFilter);
      const matchSearch = query === "" || 
        user.name.toLowerCase().includes(query) || 
        user.email.toLowerCase().includes(query) ||
        (user.department && user.department.toLowerCase().includes(query));
      return matchRole && matchSearch;
    });
  }

  /**
   * Render Table and Mobile Cards
   */
  function renderUsers() {
    const tbody = document.getElementById('userTableBody');
    const mobileContainer = document.getElementById('mobileCardsContainer');
    const emptyState = document.getElementById('emptyStateContainer');
    const totalCountEl = document.getElementById('totalUserCount');

    const filtered = getFilteredUsers();

    if (totalCountEl) {
      totalCountEl.textContent = users.length;
    }

    if (filtered.length === 0) {
      if (tbody) tbody.innerHTML = "";
      if (mobileContainer) mobileContainer.innerHTML = "";
      if (emptyState) emptyState.classList.remove('hidden');
      return;
    }

    if (emptyState) emptyState.classList.add('hidden');

    // Desktop Table Rendering
    if (tbody) {
      tbody.innerHTML = filtered.map((user, index) => `
        <tr class="hover:bg-slate-50/50 transition-colors" 
            data-user-id="${user.id}"
            data-user-name="${escapeHtml(user.name)}"
            data-user-email="${escapeHtml(user.email)}"
            data-user-role="${user.role}"
            data-user-phone="${escapeHtml(user.phone || '')}"
            data-user-department="${escapeHtml(user.department || '')}">
          <td class="py-4 px-6 lg:px-8 text-center text-slate-700">${index + 1}</td>
          <td class="py-4 px-5 lg:px-6 text-slate-800 font-medium">
            <div class="flex items-center gap-3">
              <span class="truncate">${escapeHtml(user.name)}</span>
            </div>
          </td>
          <td class="py-4 px-5 lg:px-6 text-slate-800">${escapeHtml(user.email)}</td>
          <td class="py-4 px-5 lg:px-6 text-slate-800">
            ${user.role}
          </td>
          <td class="py-4 px-5 lg:px-6">
            <div class="flex items-center justify-center gap-2.5">
              <button type="button" class="btn-edit-user inline-flex items-center gap-1.5 px-3.5 lg:px-4 py-1.5 border border-slate-300 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors"
                      data-action="edit"
                      data-id="${user.id}"
                      data-name="${escapeHtml(user.name)}"
                      data-email="${escapeHtml(user.email)}"
                      data-role="${user.role}"
                      data-phone="${escapeHtml(user.phone || '')}"
                      data-dept="${escapeHtml(user.department || '')}">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M12 20h9"></path>
                  <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                </svg>
                Edit
              </button>
              <button type="button" class="btn-delete-user inline-flex items-center gap-1.5 px-3.5 lg:px-4 py-1.5 bg-[#b91c1c] hover:bg-[#991b1b] rounded-lg text-xs font-semibold text-white transition-colors"
                      data-action="delete"
                      data-id="${user.id}"
                      data-name="${escapeHtml(user.name)}">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <polyline points="3 6 5 6 21 6"></polyline>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Delete
              </button>
            </div>
          </td>
        </tr>
      `).join('');
    }

    // Mobile Cards Rendering
    if (mobileContainer) {
      mobileContainer.innerHTML = filtered.map(user => `
        <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm space-y-3"
             data-user-id="${user.id}"
             data-user-role="${user.role}">
          <div class="flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full ${user.role === 'Teknisi' ? 'bg-amber-50 text-amber-700' : (user.role === 'Admin' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-700')} flex items-center justify-center font-bold text-sm">
                ${getInitials(user.name)}
              </div>
              <div>
                <h3 class="font-bold text-slate-900 text-sm leading-tight">${escapeHtml(user.name)}</h3>
                <p class="text-xs text-slate-500 mt-0.5">${escapeHtml(user.email)}</p>
              </div>
            </div>
            ${getRoleBadge(user.role)}
          </div>
          <div class="pt-2 border-t border-slate-100 flex items-center gap-2">
            <button type="button" class="btn-edit-user flex-1 inline-flex items-center justify-center gap-1.5 py-2 border border-slate-300 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors"
                    data-action="edit"
                    data-id="${user.id}"
                    data-name="${escapeHtml(user.name)}"
                    data-email="${escapeHtml(user.email)}"
                    data-role="${user.role}"
                    data-phone="${escapeHtml(user.phone || '')}"
                    data-dept="${escapeHtml(user.department || '')}">
              <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
              </svg>
              Edit
            </button>
            <button type="button" class="btn-delete-user flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-[#b91c1c] hover:bg-[#991b1b] rounded-lg text-xs font-semibold text-white transition-colors"
                    data-action="delete"
                    data-id="${user.id}"
                    data-name="${escapeHtml(user.name)}">
              <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              </svg>
              Delete
            </button>
          </div>
        </div>
      `).join('');
    }

    bindActionButtons();
  }

  function escapeHtml(str) {
    if (!str) return "";
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  /**
   * Bind Edit & Delete clicks
   */
  function bindActionButtons() {
    // Edit buttons
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
      btn.onclick = (e) => {
        const targetBtn = e.currentTarget;
        const id = parseInt(targetBtn.getAttribute('data-id'), 10);
        const user = users.find(u => u.id === id);
        if (!user) return;

        document.getElementById('editUserIdHidden').value = user.id;
        document.getElementById('editNamaPengguna').value = user.name;
        document.getElementById('editEmailPengguna').value = user.email;
        document.getElementById('editPhonePengguna').value = user.phone || "";
        document.getElementById('editDeptPengguna').value = user.department || "POKJA - PPDP";
        document.getElementById('inputEditPassword').value = "";

        // Set radio card selection
        setEditRoleSelection(user.role);

        openModal('modalEditUser');
      };
    });

    // Delete buttons
    document.querySelectorAll('.btn-delete-user').forEach(btn => {
      btn.onclick = (e) => {
        const targetBtn = e.currentTarget;
        const id = parseInt(targetBtn.getAttribute('data-id'), 10);
        const name = targetBtn.getAttribute('data-name') || "Pengguna";

        document.getElementById('deleteUserIdHidden').value = id;
        const targetLabel = document.getElementById('deleteTargetName');
        if (targetLabel) {
          targetLabel.textContent = `"${name}"`;
        }
        openModal('modalDeleteUser');
      };
    });
  }

  /**
   * Helper to set Edit modal role radio cards
   */
  function setEditRoleSelection(roleName) {
    const editCards = document.querySelectorAll('#editRoleGroup .edit-role-card');
    editCards.forEach(card => {
      const cardRole = card.getAttribute('data-role');
      const radio = card.querySelector('input[type="radio"]');
      const dot = card.querySelector('.radio-dot');
      const circle = card.querySelector('.radio-circle');

      if (cardRole === roleName) {
        radio.checked = true;
        card.classList.remove('border-slate-200', 'bg-white');
        card.classList.add('border-2', 'border-emerald-500', 'bg-emerald-50/20');
        circle.classList.remove('border-slate-300');
        circle.classList.add('border-emerald-500');
        if (dot) dot.classList.remove('hidden');
      } else {
        radio.checked = false;
        card.classList.remove('border-2', 'border-emerald-500', 'bg-emerald-50/20');
        card.classList.add('border', 'border-slate-200', 'bg-white');
        circle.classList.add('border-slate-300');
        circle.classList.remove('border-emerald-500');
        if (dot) dot.classList.add('hidden');
      }
    });
  }

  /**
   * Helper to set Add modal role radio cards
   */
  function setupTambahRoleCards() {
    const group = document.getElementById('tambahRoleGroup');
    if (!group) return;
    const cards = group.querySelectorAll('.role-selector-card');

    cards.forEach(card => {
      card.addEventListener('click', () => {
        cards.forEach(c => {
          c.classList.remove('border-2', 'border-emerald-500', 'bg-emerald-50/30');
          c.classList.add('border', 'border-slate-200', 'bg-white');
          const circle = c.querySelector('.radio-circle');
          const dot = c.querySelector('.radio-dot');
          if (circle) circle.className = 'w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white shrink-0 radio-circle';
          if (dot) dot.classList.add('hidden');
        });

        card.classList.remove('border', 'border-slate-200', 'bg-white');
        card.classList.add('border-2', 'border-emerald-500', 'bg-emerald-50/30');
        const radio = card.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
        const circle = card.querySelector('.radio-circle');
        const dot = card.querySelector('.radio-dot');
        if (circle) circle.className = 'w-4 h-4 rounded-full border border-emerald-500 flex items-center justify-center bg-white shrink-0 radio-circle';
        if (dot) dot.classList.remove('hidden');
      });
    });
  }

  function setupEditRoleCards() {
    const group = document.getElementById('editRoleGroup');
    if (!group) return;
    const cards = group.querySelectorAll('.edit-role-card');

    cards.forEach(card => {
      card.addEventListener('click', () => {
        const role = card.getAttribute('data-role');
        setEditRoleSelection(role);
      });
    });
  }

  /**
   * Setup Type Dropdown Filter Logic
   */
  function setupTypeDropdown() {
    const btn = document.getElementById('btnTypeDropdown');
    const menu = document.getElementById('typeDropdownMenu');
    const label = document.getElementById('typeDropdownLabel');
    const dot = document.getElementById('filterDotIndicator');
    const chevron = document.getElementById('dropdownChevron');

    if (!btn || !menu) return;

    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isHidden = menu.classList.contains('hidden');
      if (isHidden) {
        menu.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        if (chevron) chevron.classList.add('rotate-180');
      } else {
        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        if (chevron) chevron.classList.remove('rotate-180');
      }
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        if (chevron) chevron.classList.remove('rotate-180');
      }
    });

    // Options click
    menu.querySelectorAll('button[data-value]').forEach(opt => {
      opt.addEventListener('click', (e) => {
        const value = opt.getAttribute('data-value');
        currentRoleFilter = value;

        // Update UI
        if (value === 'ALL') {
          label.textContent = "Semua Tipe";
          dot.className = "w-2 h-2 rounded-full bg-slate-400";
        } else if (value === 'User') {
          label.textContent = "User";
          dot.className = "w-2 h-2 rounded-full bg-emerald-500";
        } else if (value === 'Teknisi') {
          label.textContent = "Teknisi";
          dot.className = "w-2 h-2 rounded-full bg-amber-500";
        } else if (value === 'Admin') {
          label.textContent = "Admin";
          dot.className = "w-2 h-2 rounded-full bg-blue-600";
        }

        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        if (chevron) chevron.classList.remove('rotate-180');

        renderUsers();
      });
    });
  }

  /**
   * Setup CRUD Forms
   */
  function setupForms() {
    // 1. TAMBAH USER FORM
    const formTambah = document.getElementById('form-tambah-user');
    if (formTambah) {
      formTambah.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(formTambah);
        const name = formData.get('nama_pengguna');
        const email = formData.get('email');
        const role = formData.get('role') || 'User';
        const phone = formData.get('nomor_telepon') || '';
        const dept = formData.get('departemen');
        const password = formData.get('password');

        if (!name || !email || !dept || !password) {
          showToast('Harap isi semua field wajib bertanda bintang', 'error');
          return;
        }

        const newUser = {
          id: Date.now(),
          name: name.trim(),
          email: email.trim(),
          role: role,
          phone: phone.trim(),
          department: dept,
          avatar: null,
          createdAt: new Date().toISOString().split('T')[0]
        };

        users.unshift(newUser); // add to beginning
        renderUsers();
        formTambah.reset();
        closeModal('modalTambahUser');
        showToast(`Pengguna "${newUser.name}" berhasil ditambahkan.`);
      });
    }

    // 2. EDIT USER FORM
    const formEdit = document.getElementById('form-edit-user');
    if (formEdit) {
      formEdit.addEventListener('submit', (e) => {
        e.preventDefault();
        const userId = parseInt(document.getElementById('editUserIdHidden').value, 10);
        const formData = new FormData(formEdit);
        const name = formData.get('nama_pengguna');
        const email = formData.get('email');
        const role = formData.get('role') || 'User';
        const phone = formData.get('nomor_telepon') || '';
        const dept = formData.get('departemen');

        const userIndex = users.findIndex(u => u.id === userId);
        if (userIndex !== -1) {
          users[userIndex].name = name.trim();
          users[userIndex].email = email.trim();
          users[userIndex].role = role;
          users[userIndex].phone = phone.trim();
          users[userIndex].department = dept;

          renderUsers();
          closeModal('modalEditUser');
          showToast(`Perubahan data "${users[userIndex].name}" berhasil disimpan.`);
        }
      });
    }

    // 3. DELETE USER FORM
    const formDelete = document.getElementById('form-delete-user');
    if (formDelete) {
      formDelete.addEventListener('submit', (e) => {
        e.preventDefault();
        const userId = parseInt(document.getElementById('deleteUserIdHidden').value, 10);
        const targetUser = users.find(u => u.id === userId);
        const targetName = targetUser ? targetUser.name : "Pengguna";

        users = users.filter(u => u.id !== userId);
        renderUsers();
        closeModal('modalDeleteUser');
        showToast(`Pengguna "${targetName}" berhasil dihapus.`);
      });
    }

    // 4. Live Search Input binding
    const searchInputs = [
      document.getElementById('tableSearchInput'),
      document.getElementById('headerGlobalSearch'),
      document.getElementById('mobileSearchInput')
    ];

    searchInputs.forEach(input => {
      if (input) {
        input.addEventListener('input', (e) => {
          currentSearchQuery = e.target.value;
          // Synchronize search boxes
          searchInputs.forEach(other => {
            if (other && other !== input) other.value = currentSearchQuery;
          });
          renderUsers();
        });
      }
    });

    // Reset filter button
    const btnResetFilter = document.getElementById('btnResetFilter');
    if (btnResetFilter) {
      btnResetFilter.addEventListener('click', () => {
        currentSearchQuery = "";
        currentRoleFilter = "ALL";
        searchInputs.forEach(i => { if (i) i.value = ""; });
        const label = document.getElementById('typeDropdownLabel');
        const dot = document.getElementById('filterDotIndicator');
        if (label) label.textContent = "Semua Tipe";
        if (dot) dot.className = "w-2 h-2 rounded-full bg-slate-400";
        renderUsers();
      });
    }
  }

  // Initialization
  document.addEventListener('DOMContentLoaded', () => {
    // Mobile sidebar
    const btnOpenSidebar = document.getElementById('btnOpenSidebar');
    const btnCloseSidebar = document.getElementById('btnCloseSidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    if (btnOpenSidebar) btnOpenSidebar.addEventListener('click', openSidebar);
    if (btnCloseSidebar) btnCloseSidebar.addEventListener('click', closeSidebar);
    if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);

    // Tambah user trigger button
    const btnTambah = document.getElementById('btnTambahUser');
    if (btnTambah) {
      btnTambah.addEventListener('click', () => {
        const form = document.getElementById('form-tambah-user');
        if (form) form.reset();
        // default role user
        const firstRadio = document.querySelector('#tambahRoleGroup input[value="User"]');
        if (firstRadio) firstRadio.click();
        openModal('modalTambahUser');
      });
    }

    // Modal Close Triggers
    document.querySelectorAll('.modal-close-trigger').forEach(el => {
      el.addEventListener('click', () => {
        const parentModal = el.closest('#modalTambahUser, #modalEditUser, #modalDeleteUser');
        if (parentModal) {
          closeModal(parentModal.id);
        }
      });
    });

    // Escape Key Listener
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeAllModals();
        closeSidebar();
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1024) {
        closeSidebar();
      }
    });

    // Setup interactive features
    setupTypeDropdown();
    setupTambahRoleCards();
    setupEditRoleCards();
    setupForms();

    // Initial table render
    renderUsers();
  });
</script>
</body></html>