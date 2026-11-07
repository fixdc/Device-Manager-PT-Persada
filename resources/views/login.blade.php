@extends('layouts.index')

@section('content')
<div class="relative min-h-screen bg-[#FDFDFD] flex flex-col font-sans text-gray-900 overflow-hidden">
    
    <!-- Background Shape (Visual Effect) -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
        <div class="w-[200px] h-[200px] sm:w-[500px] sm:h-[500px] bg-[#14274E] rounded-[2rem] sm:rounded-[3rem] rotate-60 opacity-90 scale-90 sm:scale-100 transition-transform"></div>
    </div>
    <!-- Main Card Container -->
    <div class="relative z-10 flex-1 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] p-8 sm:p-10 w-full max-w-[440px]">
            
            <h1 class="text-[22px] font-bold text-center text-gray-900 mb-8">Masuk Ke Akunmu</h1>
            <!-- Form -->
            <form method="POST" action="" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 mb-2 ml-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" placeholder="refero.design.team@gmail.com" 
                        class="w-full px-5 py-3.5 rounded-full border border-gray-100 bg-white focus:border-[#6F75FF] focus:ring-1 focus:ring-[#6F75FF] outline-none transition-all text-sm text-gray-800 shadow-sm placeholder:text-gray-400">
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 mb-2 ml-1">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" placeholder="••••••••••••••••"
                        class="w-full px-5 py-3.5 rounded-full border border-gray-100 bg-white focus:border-[#6F75FF] focus:ring-1 focus:ring-[#6F75FF] outline-none transition-all text-sm text-gray-800 shadow-sm placeholder:text-gray-400">
                </div>

                <!-- Sign In Submit -->
                <div class="pt-3">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#14274E] hover:bg-[#161835] text-white font-semibold py-3.5 px-4 rounded-full transition-all duration-200 shadow-[0_8px_20px_rgba(111,117,255,0.3)]">
                        Masuk
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <!-- Forgot Password Link -->
                <div class="mt-4">
                    <a href="#" class="text-xs font-medium text-[#14274E] hover:text-[#5A60E5] transition-colors ml-1">
                        Lupa Kata Sandi?
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection