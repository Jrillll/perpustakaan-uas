@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4" x-data="{ activeTab: 'perpus', slideIndex: 0, totalSlides: 3 }">
    
    <!-- Title Page -->
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-5xl font-black tracking-tight text-gray-800 mb-4 heading-font bg-gradient-to-r from-gray-800 to-indigo-700 bg-clip-text">
            Tentang Website
        </h1>
        <p class="text-indigo-600 text-sm md:text-base font-semibold">
            Kenali profil perpustakaan dan tim pengembang di balik website ini.
        </p>
    </div>

    <!-- TABS CONTROLLER -->
    <div class="flex justify-center border-b border-gray-200 mb-10">
        <div class="flex space-x-8">
            <button 
                @click="activeTab = 'perpus'"
                :class="activeTab === 'perpus' ? 'border-b-2 border-indigo-600 text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="pb-4 text-base tracking-medium transition-all duration-200 focus:outline-none"
            >
                Profil Perpustakaan
            </button>
            <button 
                @click="activeTab = 'tim'"
                :class="activeTab === 'tim' ? 'border-b-2 border-indigo-600 text-indigo-600 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="pb-4 text-base tracking-medium transition-all duration-200 focus:outline-none"
            >
                Profil Pengembang
            </button>
        </div>
    </div>

    <!-- TAB 1: PERPUSTAKAAN -->
    <div x-show="activeTab === 'perpus'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="bg-white p-8 md:p-12 rounded-3xl border border-gray-200 shadow-sm">
        <div class="flex flex-col gap-6">
            <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 items-center justify-center border border-indigo-100">
                🏢
            </div>
            <h3 class="font-bold text-2xl md:text-3xl text-gray-800 heading-font">Perpustakaan Kota Surabaya</h3>
            
            <div class="space-y-4 text-gray-600 text-base leading-relaxed">
                <p>
                    Perpustakaan Kota Surabaya merupakan fasilitas publik yang dikelola oleh pemerintah kota untuk menyediakan berbagai macam koleksi buku berkualitas serta layanan literasi interaktif bagi masyarakat luas.
                </p>
                <p>
                    Perpustakaan ini bertujuan untuk terus meningkatkan minat baca di kalangan pelajar dan masyarakat umum, mendukung proses pembelajaran sepanjang hayat, serta menjadi pusat literasi digital yang unggul di era modern.
                </p>
            </div>

            <div class="mt-4 p-4 rounded-2xl bg-gray-50 border border-gray-200 flex items-start gap-3">
                <span class="text-xl">📍</span>
                <p class="text-sm text-gray-500 leading-normal">
                    Jl. Rungkut Asri Tengah No.5-7, Rungkut Kidul, Kec. Rungkut, Kota Surabaya, Jawa Timur 60293
                </p>
            </div>
        </div>
    </div>

    <!-- TAB 2: DEVELOPERS SLIDER -->
    <div x-show="activeTab === 'tim'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="relative overflow-hidden w-full bg-white p-8 md:p-12 rounded-3xl border border-gray-200 shadow-sm">
        
        <!-- Slider Window -->
        <div class="relative w-full">
            <div 
                class="flex transition-transform duration-500 ease-out" 
                :style="`transform: translateX(-${slideIndex * 100}%)`"
            >
                
                <!-- DEV 1 -->
                <div class="min-w-full flex-shrink-0 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 space-y-4 text-left">
                        <div class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wide">
                            Back-End Developer
                        </div>
                        <h4 class="font-bold text-2xl md:text-3xl text-gray-800 heading-font">Muhammad Nazriel Nararya Arianto</h4>
                        <div class="space-y-1.5 text-sm text-gray-500">
                            <p>🏫 Universitas: <strong class="text-gray-700">UPN Veteran Jawa Timur</strong></p>
                            <p>💻 Fakultas: <strong class="text-gray-700">Ilmu Komputer</strong></p>
                            <p>📚 Program Studi: <strong class="text-gray-700">Sistem Informasi</strong></p>
                        </div>
                    </div>
                    <!-- Photo placeholder falls back gracefully using premium UI initials if missing -->
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-indigo-500/20 flex-shrink-0 bg-gray-100 shadow-md relative">
                        <img 
                            src="/najril.jpg" 
                            alt="Nazriel" 
                            class="w-full h-full object-cover" 
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="hidden absolute inset-0 bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-3xl text-white">
                            NN
                        </div>
                    </div>
                </div>

                <!-- DEV 2 -->
                <div class="min-w-full flex-shrink-0 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 space-y-4 text-left">
                        <div class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wide">
                            Front-End Developer
                        </div>
                        <h4 class="font-bold text-2xl md:text-3xl text-gray-800 heading-font">Radithya Saka Candranata</h4>
                        <div class="space-y-1.5 text-sm text-gray-500">
                            <p>🏫 Universitas: <strong class="text-gray-700">UPN Veteran Jawa Timur</strong></p>
                            <p>💻 Fakultas: <strong class="text-gray-700">Ilmu Komputer</strong></p>
                            <p>📚 Program Studi: <strong class="text-gray-700">Sistem Informasi</strong></p>
                        </div>
                    </div>
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-indigo-500/20 flex-shrink-0 bg-gray-100 shadow-md relative">
                        <img 
                            src="/foto e pardi.jpeg" 
                            alt="Radithya" 
                            class="w-full h-full object-cover" 
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="hidden absolute inset-0 bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-3xl text-white">
                            RC
                        </div>
                    </div>
                </div>

                <!-- DEV 3 -->
                <div class="min-w-full flex-shrink-0 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 space-y-4 text-left">
                        <div class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wide">
                            UI Designer
                        </div>
                        <h4 class="font-bold text-2xl md:text-3xl text-gray-800 heading-font">Maulana Ahmad Andika</h4>
                        <div class="space-y-1.5 text-sm text-gray-500">
                            <p>🏫 Universitas: <strong class="text-gray-700">UPN Veteran Jawa Timur</strong></p>
                            <p>💻 Fakultas: <strong class="text-gray-700">Ilmu Komputer</strong></p>
                            <p>📚 Program Studi: <strong class="text-gray-700">Sistem Informasi</strong></p>
                        </div>
                    </div>
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-indigo-500/20 flex-shrink-0 bg-gray-100 shadow-md relative">
                        <img 
                            src="/foto e andika.jpeg" 
                            alt="Andika" 
                            class="w-full h-full object-cover" 
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="hidden absolute inset-0 bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-3xl text-white">
                            MA
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- BUTTONS FOR SLIDER -->
        <div class="flex justify-between items-center mt-10 pt-6 border-t border-gray-200">
            <!-- Indicators -->
            <div class="flex space-x-2">
                <template x-for="i in Array.from({length: totalSlides})">
                    <span 
                        @click="slideIndex = i" 
                        class="w-2.5 h-2.5 rounded-full cursor-pointer transition-all duration-300"
                        :class="slideIndex === i ? 'bg-indigo-600 w-6' : 'bg-gray-300 hover:bg-gray-400'"
                    ></span>
                </template>
            </div>
            
            <div class="flex space-x-3">
                <button 
                    @click="slideIndex = (slideIndex - 1 + totalSlides) % totalSlides" 
                    class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 flex items-center justify-center hover:bg-indigo-600 hover:border-indigo-600 hover:text-white transition-all duration-200"
                >
                    ❮
                </button>
                <button 
                    @click="slideIndex = (slideIndex + 1) % totalSlides" 
                    class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 flex items-center justify-center hover:bg-indigo-600 hover:border-indigo-600 hover:text-white transition-all duration-200"
                >
                    ❯
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
