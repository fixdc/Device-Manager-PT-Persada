@extends('layouts.app')

@section('title', 'P-TAMS - Kelola Ticket')

@section('content')
<div class="relative flex min-h-screen flex-col lg:flex-row">
    @include('components.sidebar')

    <main class="flex min-w-0 flex-1 flex-col bg-[#F8FAFC]">
        @include('components.navbar')

        <div class="space-y-6 px-4 pb-12 pt-1 sm:px-6 lg:px-8">
            <div data-purpose="page-heading">
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Ticket</h1>
                <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                    Pantau dan kelola seluruh aktivitas perangkat serta penanganan kerusakan
                </p>
            </div>

            <section class="grid grid-cols-1 gap-3.5 sm:grid-cols-2 sm:gap-4 md:grid-cols-3 xl:grid-cols-5"
                     data-purpose="ticket-metrics-overview">
                <x-stat-card label="Total Tiket" value="1.200"
                    description="Akumulasi keseluruhan tiket masuk">
                    <x-slot:icon>
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/></svg>
                    </x-slot:icon>
                </x-stat-card>
                <x-stat-card label="Tiket Baru" value="1.200"
                    description="Tiket yang belum ditangani" badge="NEW"/>
                <x-stat-card label="Dalam Pengerjaan" value="1.200"
                    description="Tiket yang sedang berlangsung"
                    icon-bg="bg-rose-50" icon-color="text-rose-500">
                    <x-slot:icon><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></x-slot:icon>
                </x-stat-card>
                <x-stat-card label="Menunggu" value="1.200"
                    description="Tertunda ketersediaan sparepart"
                    icon-bg="bg-amber-50" icon-color="text-amber-500">
                    <x-slot:icon><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 6v6l4 2" stroke-linecap="round" stroke-width="2"/></svg></x-slot:icon>
                </x-stat-card>
                <x-stat-card label="Selesai" value="1.200"
                    description="Tiket yang sudah diproses dan selesai"
                    icon-bg="bg-emerald-50" icon-color="text-emerald-500">
                    <x-slot:icon><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></x-slot:icon>
                </x-stat-card>
            </section>

            @include('components.ticket.filters')

            @php
                // Data sementara untuk tampilan. Nantinya pindahkan ke Controller/Model.
                $tickets = [
                    ['id'=>'tc-001','ticketCode'=>'#TC-001','subject'=>'PC tiba-tiba mati sendiri p...','deviceId'=>'PC-PPDP-001','type'=>'Incident','urgency'=>'Mendesak','priorityLevel'=>'Urgent','status'=>'DALAM_PENGERJAAN','createdAt'=>'2025-02-18T08:30:00Z','reporterName'=>'Andi Saputra','department'=>'IT Operations'],
                    ['id'=>'tc-002','ticketCode'=>'#TC-002','subject'=>'Printer rusak','deviceId'=>'LAP-PPM-010','type'=>'Problem','urgency'=>'Sedang','priorityLevel'=>'Medium','status'=>'MENUNGGU','createdAt'=>'2025-02-18T09:15:00Z','reporterName'=>'Dewi Lestari','department'=>'Finance'],
                    ['id'=>'tc-003','ticketCode'=>'#TC-003','subject'=>'AC nya ora dingin mas','deviceId'=>'RTR-PDDPB-001','type'=>'Question','urgency'=>'Rendah','priorityLevel'=>'Low','status'=>'BARU','createdAt'=>'2025-02-17T14:20:00Z','reporterName'=>'Rian Hidayat','department'=>'General Affairs'],
                    ['id'=>'tc-004','ticketCode'=>'#TC-004','subject'=>'Gaji saya belum cair','deviceId'=>'PRN-PPKR-001','type'=>'Suggestion','urgency'=>'Mendesak','priorityLevel'=>'Urgent','status'=>'BARU','createdAt'=>'2025-02-17T16:00:00Z','reporterName'=>'Budi Setiawan','department'=>'HR'],
                    ['id'=>'tc-005','ticketCode'=>'#TC-005','subject'=>'Is this thing working?','deviceId'=>'SCN-PPSE-001','type'=>'Incident','urgency'=>'Sedang','priorityLevel'=>'Medium','status'=>'DALAM_PENGERJAAN','createdAt'=>'2025-02-16T11:45:00Z','reporterName'=>'Maya Sari','department'=>'Marketing'],
                    ['id'=>'tc-006','ticketCode'=>'#TC-006','subject'=>'Nigerundayo!!!','deviceId'=>'CAM-PPPB-001','type'=>'Problem','urgency'=>'Mendesak','priorityLevel'=>'Urgent','status'=>'DALAM_PENGERJAAN','createdAt'=>'2025-02-15T10:10:00Z','reporterName'=>'Fikri','department'=>'Security'],
                ];
            @endphp

            @include('components.ticket.table', ['tickets' => $tickets])
        </div>
    </main>
</div>
@endsection
