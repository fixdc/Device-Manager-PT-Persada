@extends('layouts.index')

@section('content')
<div class="bg-[#F8F9FA] min-h-screen flex flex-col items-center justify-center p-4 antialiased text-gray-900">

    <div class="w-full max-w-md flex flex-col gap-6">
        
        <!-- Tombol Back -->
        <div>
            <a href="#" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Card Login -->
        <div class="bg-white rounded-4xl shadow-[0_2px_40px_rgb(0,0,0,0.04)] p-10 w-full">
            <div class="text-center mb-8">
                <h1 class="text-[26px] font-semibold tracking-tight text-gray-900">Selamat Datang</h1>
                <p class="text-sm text-gray-500 mt-2">Silakan masuk menggunakan kredensial Anda.</p>
            </div>

            <form method="POST" action="" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none transition-all text-sm">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none transition-all text-sm">
                </div>

                <div class="flex items-center justify-between pt-2 pb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-600 focus:ring-2">
                        <span class="text-sm font-medium text-gray-600">Ingat saya</span>
                    </label>
                    
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-[#1D4ED8] hover:bg-blue-800 text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-200 active:scale-[0.98]">
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer Text -->
        <div class="text-center">
            <p class="text-sm font-medium text-gray-500">
                Dinas Sosial Kota Tanggerang Selatan 2026
            </p>
        </div>
    </div>
</div> 
@endsection
