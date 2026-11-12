<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Data Dummy Departments (Dari frontend: POKJA, Keuangan, Operasional, dll)
        DB::table('departments')->insert([
            ['nama' => 'IT Support & Operations', 'lantai' => 'Lantai 1', 'slug' => Str::slug('IT Support & Operations'), 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Lantai 6', 'slug' => Str::slug('POKJA - Perencanaan Pengembangan dan Pengaduan'), 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Keuangan & Logistik', 'lantai' => 'Lantai 3', 'slug' => Str::slug('Keuangan & Logistik'), 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Operasional Kantor', 'lantai' => 'Lantai 2', 'slug' => Str::slug('Operasional Kantor'), 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Data Center & Network', 'lantai' => 'Ruang Server A', 'slug' => Str::slug('Data Center & Network'), 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Data Dummy Device Categories
        DB::table('device_categories')->insert([
            ['nama' => 'Laptop / Komputer', 'slug' => 'laptop-komputer', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Monitor', 'slug' => 'monitor', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Printer & Scanner', 'slug' => 'printer-scanner', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Jaringan / Internet', 'slug' => 'jaringan-internet', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Listrik / Peralatan Pendukung', 'slug' => 'listrik-peralatan-pendukung', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 3. Data Dummy Users (Dari frontend: Fikri, Budi Santoso, Dewi Lestari, dll)
        DB::table('users')->insert([
            [
                'nama' => 'Fikri Aidhil Setiansyah',
                'email' => 'aidhil522@gmail.com',
                'role' => 'admin',
                'no_telp' => '08112090400',
                'kata_sandi' => Hash::make('password123'),
                'id_departemen' => 1, 
                'created_at' => clone $now->subMonths(2), 'updated_at' => clone $now->subMonths(2)
            ],
            [
                'nama' => 'Siti Aisyah',
                'email' => 'siti.teknisi@persada.com',
                'role' => 'admin', // Sebagai Teknisi
                'no_telp' => '085233419012',
                'kata_sandi' => Hash::make('password123'),
                'id_departemen' => 1, 
                'created_at' => clone $now->subMonths(1), 'updated_at' => clone $now->subMonths(1)
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@persada.com',
                'role' => 'user',
                'no_telp' => '081234567890',
                'kata_sandi' => Hash::make('password123'),
                'id_departemen' => 2, 
                'created_at' => clone $now->subDays(15), 'updated_at' => clone $now->subDays(15)
            ],
            [
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@persada.com',
                'role' => 'user',
                'no_telp' => '081944561188',
                'kata_sandi' => Hash::make('password123'),
                'id_departemen' => 3, 
                'created_at' => clone $now->subDays(10), 'updated_at' => clone $now->subDays(10)
            ],
            [
                'nama' => 'Rina Wulandari',
                'email' => 'rina.wulandari@persada.com',
                'role' => 'user',
                'no_telp' => '082155421200',
                'kata_sandi' => Hash::make('password123'),
                'id_departemen' => 4, 
                'created_at' => clone $now->subDays(5), 'updated_at' => clone $now->subDays(5)
            ],
        ]);

        // 4. Data Dummy Devices (Dari file frontend)
        DB::table('devices')->insert([
            [
                'kode_device' => 'LAP-ROG-001',
                'nama_device' => 'Laptop ASUS ROG',
                'id_kategori' => 1, 
                'nomor_seri' => 'SN-ROG843829',
                'status' => 'aktif',
                'deskripsi' => 'Laptop operasional berat untuk rendering',
                'id_user' => 1, // Fikri
                'id_departemen' => 1,
                'created_at' => clone $now->subDays(30), 'updated_at' => clone $now->subDays(30)
            ],
            [
                'kode_device' => 'MNT-LG-004',
                'nama_device' => 'Monitor LG 14 Inch',
                'id_kategori' => 2, 
                'nomor_seri' => 'SN-8438291809281092',
                'status' => 'perbaikan',
                'deskripsi' => 'Resolusi 1920x1080 144Hz IPS Panel',
                'id_user' => 3, // Budi
                'id_departemen' => 2,
                'created_at' => clone $now->subDays(25), 'updated_at' => clone $now->subDays(25)
            ],
            [
                'kode_device' => 'SCN-CNN-001',
                'nama_device' => 'Scanner Canon DR-C240',
                'id_kategori' => 3, 
                'nomor_seri' => 'SN-5521903847261',
                'status' => 'aktif',
                'deskripsi' => 'Scanner dokumen divisi keuangan',
                'id_user' => 4, // Dewi
                'id_departemen' => 3,
                'created_at' => clone $now->subDays(20), 'updated_at' => clone $now->subDays(20)
            ],
            [
                'kode_device' => 'PRN-EPS-002',
                'nama_device' => 'Printer Epson L3310',
                'id_kategori' => 3, 
                'nomor_seri' => 'SN-3309182746550',
                'status' => 'rusak',
                'deskripsi' => 'Printer operasional lantai 2',
                'id_user' => 5, // Rina
                'id_departemen' => 4,
                'created_at' => clone $now->subDays(15), 'updated_at' => clone $now->subDays(15)
            ],
            [
                'kode_device' => 'RTR-MKT-001',
                'nama_device' => 'Router Mikrotik RB4011',
                'id_kategori' => 4, 
                'nomor_seri' => 'SN-MIK998877',
                'status' => 'aktif',
                'deskripsi' => 'Router utama data center',
                'id_user' => 1, // Fikri
                'id_departemen' => 5,
                'created_at' => clone $now->subDays(10), 'updated_at' => clone $now->subDays(10)
            ],
        ]);

        // 5. Data Dummy Tickets
        DB::table('tickets')->insert([
            [
                'kode_ticket' => 'TCK-001',
                'id_device' => 2, // Monitor LG
                'id_user' => 3, // Budi Santoso (Pelapor)
                'id_teknisi' => 2, // Siti Aisyah
                'judul' => 'Layar berkedip',
                'deskripsi' => 'Layar monitor berkedip terus saat dipakai, terutama ketika kecerahan dinaikkan.',
                'prioritas' => 'tinggi',
                'status' => 'completed',
                'catatan' => 'Kabel fleksibel diganti.',
                'tanggal' => clone $now->subDays(7),
                'created_at' => clone $now->subDays(7), 'updated_at' => clone $now->subDays(6)
            ],
            [
                'kode_ticket' => 'TCK-002',
                'id_device' => 4, // Printer Epson
                'id_user' => 5, // Rina Wulandari (Pelapor)
                'id_teknisi' => 1, // Fikri Aidhil
                'judul' => 'Tidak bisa ngeprint',
                'deskripsi' => 'Printer menyala tetapi dokumen tidak keluar, muncul lampu indikator tinta berkedip.',
                'prioritas' => 'sedang',
                'status' => 'process',
                'catatan' => 'Sedang dilakukan pembersihan head printer.',
                'tanggal' => clone $now->subDays(5),
                'created_at' => clone $now->subDays(5), 'updated_at' => clone $now->subDays(4)
            ],
            [
                'kode_ticket' => 'TCK-003',
                'id_device' => 3, // Scanner Canon
                'id_user' => 4, // Dewi Lestari
                'id_teknisi' => 2, // Siti Aisyah
                'judul' => 'Hasil scan bergaris',
                'deskripsi' => 'Hasil pindaian selalu muncul garis vertikal di tengah halaman.',
                'prioritas' => 'rendah',
                'status' => 'completed',
                'catatan' => 'Kaca scanner dibersihkan.',
                'tanggal' => clone $now->subDays(4),
                'created_at' => clone $now->subDays(4), 'updated_at' => clone $now->subDays(3)
            ],
            [
                'kode_ticket' => 'TCK-004',
                'id_device' => 5, // Router Mikrotik
                'id_user' => 1, // Fikri (Pelapor)
                'id_teknisi' => null, // Belum ditangani
                'judul' => 'Internet sering putus',
                'deskripsi' => 'Koneksi internet putus-putus setiap beberapa menit di seluruh lantai.',
                'prioritas' => 'tinggi',
                'status' => 'open',
                'catatan' => null,
                'tanggal' => clone $now->subDays(2),
                'created_at' => clone $now->subDays(2), 'updated_at' => clone $now->subDays(2)
            ],
            [
                'kode_ticket' => 'TCK-005',
                'id_device' => 1, // Laptop ROG
                'id_user' => 1, // Fikri (Pelapor)
                'id_teknisi' => 2, // Siti Aisyah
                'judul' => 'Baterai cepat habis',
                'deskripsi' => 'Daya perangkat cepat habis walaupun hanya dipakai sebentar.',
                'prioritas' => 'sedang',
                'status' => 'confirmed',
                'catatan' => 'Menunggu sparepart baterai baru.',
                'tanggal' => clone $now->subDays(1),
                'created_at' => clone $now->subDays(1), 'updated_at' => clone $now->subDays(1)
            ],
        ]);

        // 6. Data Dummy Repair Histories (Hanya untuk tiket yang dikerjakan/selesai)
        DB::table('repair_histories')->insert([
            [
                'id_ticket' => 1, // TCK-001 (Selesai)
                'tindakan' => 'Kabel fleksibel layar diganti dan driver grafis diperbarui. Layar sudah normal setelah diuji 1 jam.',
                'tanggal_selesai' => clone $now->subDays(6),
                'created_at' => clone $now->subDays(6), 'updated_at' => clone $now->subDays(6)
            ],
            [
                'id_ticket' => 2, // TCK-002 (Proses)
                'tindakan' => 'Sedang dilakukan pembersihan head printer dan pengecekan aliran tinta dari tabung.',
                'tanggal_selesai' => null,
                'created_at' => clone $now->subDays(4), 'updated_at' => clone $now->subDays(4)
            ],
            [
                'id_ticket' => 3, // TCK-003 (Selesai)
                'tindakan' => 'Kaca scanner dan roller dibersihkan, kalibrasi ulang dilakukan.',
                'tanggal_selesai' => clone $now->subDays(3),
                'created_at' => clone $now->subDays(3), 'updated_at' => clone $now->subDays(3)
            ],
            [
                'id_ticket' => 5, // TCK-005 (Confirmed/Proses)
                'tindakan' => 'Pengaturan daya dioptimalkan sementara menunggu baterai pengganti tiba.',
                'tanggal_selesai' => null,
                'created_at' => clone $now->subHours(5), 'updated_at' => clone $now->subHours(5)
            ],
            [
                'id_ticket' => 4, // TCK-004 (Sengaja dibuat history log pertama)
                'tindakan' => 'Pengecekan awal pada log router menunjukkan adanya error pada interface ether1.',
                'tanggal_selesai' => null,
                'created_at' => clone $now->subHours(2), 'updated_at' => clone $now->subHours(2)
            ],
        ]);
    }
}