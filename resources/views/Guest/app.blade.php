@extends('Guest.Layout.main')

@section('main')
    <section id="coverGate"
        class="fixed inset-0 z-50 flex items-center justify-center bg-[radial-gradient(circle_at_50%_20%,#fffdf8_0%,#f8f3ea_55%,#eee4d5_100%)] px-5 text-center transition-transform duration-1000 ease-in-out">
        <div
            class="absolute w-[360px] h-[360px] border border-goldLight/40 rounded-full -left-[150px] top-[10%] pointer-events-none">
        </div>
        <div
            class="absolute w-[360px] h-[360px] border border-goldLight/40 rounded-full -right-[150px] bottom-[10%] pointer-events-none">
        </div>

        <div class="max-w-md w-full relative z-10 py-10">
            <div class="text-[11px] sm:text-[12px] tracking-[0.35em] uppercase text-gold font-medium mb-3">
                The Wedding Of
            </div>

            <h1 class="font-serif text-goldDark text-4xl sm:text-6xl leading-tight my-2 font-normal">
                Christy &amp; Gideon
            </h1>

            <div class="text-xs tracking-[0.25em] uppercase text-ink mt-3 font-medium">
                12 Desember 2026
            </div>

            <!-- Kartu Tamu Penerima -->
            <div
                class="mt-8 mb-8 p-5 bg-paper/90 border border-goldBorder rounded-2xl shadow-[0_15px_35px_rgba(110,77,32,0.08)]">
                <span class="text-xs text-inkMuted block mb-1">Kepada Yth. Bapak/Ibu/Saudara/i:</span>
                <p id="coverGuestName" class="font-serif text-2xl sm:text-3xl text-goldDark font-semibold">{{ $data->name }}</p>
                <div id="coverBadgeWrapper" class="mt-2.5">
                    <span id="coverGuestCategoryBadge"
                        class="inline-block px-3 py-1 bg-gold/15 text-goldDark text-[10px] tracking-widest uppercase rounded-full font-semibold">
                        Nasional Umum
                    </span>
                </div>
            </div>

            <button type="button" id="unlockInvitation"
                class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wider uppercase shadow-md hover:bg-goldDark hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                </svg>
                Buka Undangan
            </button>
        </div>
    </section>

    @include('Guest.Layout.nav')

    <header id="home"
        class="min-h-screen grid place-items-center relative overflow-hidden bg-[radial-gradient(circle_at_50%_20%,#fffdf8_0%,#f8f3ea_55%,#eee4d5_100%)]">
        <div
            class="absolute w-[330px] h-[330px] border border-goldLight/40 rounded-full -left-[170px] top-[10%] pointer-events-none">
        </div>
        <div
            class="absolute w-[330px] h-[330px] border border-goldLight/40 rounded-full -right-[170px] bottom-[5%] pointer-events-none">
        </div>

        <div class="relative z-10 max-w-3xl text-center px-5 pt-24 pb-16">
            <div class="text-[12px] tracking-[0.35em] uppercase text-gold font-medium">The Wedding Of</div>
            <h1 class="font-serif text-goldDark text-5xl sm:text-7xl md:text-8xl leading-tight my-4 font-normal">
                Christy Audy Valentine
                <span class="block text-[0.55em] text-goldLight my-2 font-serif">&amp;</span>
                Gideon Mula Gabe Sitorus
            </h1>
            <div class="text-[13px] tracking-[0.25em] uppercase text-ink mt-6 font-medium">12 Desember 2026</div>
            <p id="guestText" class="mt-4 text-inkMuted text-sm">Kepada Yth. {{ $data->name }}</p>
        </div>
    </header>

    <!-- Countdown Section -->
    <section id="countdown" class="py-20 px-5">
        <div class="text-center mb-10">
            <div class="text-[11px] tracking-[0.28em] uppercase text-gold font-medium">Save the Date</div>
            <h2 class="font-serif text-4xl sm:text-5xl my-2 font-normal">Menuju Hari Bahagia</h2>
            <div class="text-gold tracking-[0.5em] text-sm">✦ ✦ ✦</div>
        </div>

        <div class="grid grid-cols-4 gap-2 sm:gap-3 max-w-3xl mx-auto">
            <div class="bg-paper border border-lineColor rounded-2xl p-4 sm:p-5 text-center shadow-sm">
                <strong id="days" class="block font-serif text-3xl sm:text-5xl font-medium text-goldDark">—</strong>
                <span class="text-[10px] uppercase tracking-widest text-inkMuted">Hari</span>
            </div>
            <div class="bg-paper border border-lineColor rounded-2xl p-4 sm:p-5 text-center shadow-sm">
                <strong id="hours" class="block font-serif text-3xl sm:text-5xl font-medium text-goldDark">—</strong>
                <span class="text-[10px] uppercase tracking-widest text-inkMuted">Jam</span>
            </div>
            <div class="bg-paper border border-lineColor rounded-2xl p-4 sm:p-5 text-center shadow-sm">
                <strong id="mins" class="block font-serif text-3xl sm:text-5xl font-medium text-goldDark">—</strong>
                <span class="text-[10px] uppercase tracking-widest text-inkMuted">Menit</span>
            </div>
            <div class="bg-paper border border-lineColor rounded-2xl p-4 sm:p-5 text-center shadow-sm">
                <strong id="secs" class="block font-serif text-3xl sm:text-5xl font-medium text-goldDark">—</strong>
                <span class="text-[10px] uppercase tracking-widest text-inkMuted">Detik</span>
            </div>
        </div>

        <!-- Tombol Google Calendar -->
        <div class="text-center mt-8">
            @php
                // Format Google Calendar URL: YYYYMMDDTHHMMSSZ (UTC)
                $title = urlencode('The Wedding of Christy & Gideon');
                $dates = '20261025T030000Z/20261025T070000Z'; // Contoh: 25 Okt 2026, 10:00 - 14:00 WIB (UTC: 03:00 - 07:00)
                $details = urlencode('Pernikahan Christy & Gideon. Kehadiran dan doa restu Anda merupakan kehormatan bagi kami.');
                $location = urlencode('Nama Gedung / Tempat Acara, Kota');
                $calendarUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$title}&dates={$dates}&details={$details}&location={$location}";
            @endphp

            <a href="{{ $calendarUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex  justify-center px-5 py-2.5 gap-2 items-center bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wide hover:opacity-90 transition">
                <!-- Ikon Kalender -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="3" stroke-linecap="round"/>
                    <line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round"/>
                    <line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round"/>
                    <line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round"/>
                </svg>
                <span>Simpan ke Google Calendar</span>
            </a>
        </div>
    </section>

    <!-- Rangkaian Acara Section -->
    <section id="acara" class="pb-20">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center mb-10">
                <div class="text-[11px] tracking-[0.28em] uppercase text-gold font-medium">Rangkaian Acara</div>
                <h2 class="font-serif text-4xl sm:text-5xl my-2 font-normal">Two Hearts, One Journey</h2>
                <div class="text-gold">✦</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card 1: Pemberkatan -->
                <div
                    class="bg-paper border border-lineColor rounded-3xl p-7 sm:p-8 shadow-[0_15px_40px_rgba(110,77,32,0.06)] flex flex-col justify-between">
                    <div>
                        <div class="text-2xl text-gold mb-2">✦</div>
                        <h3 class="font-serif text-3xl mb-2 font-normal">Holy Matrimony</h3>
                        <div class="text-inkMuted text-sm leading-relaxed">
                            <b class="text-ink">Sabtu, 12 Desember 2026</b><br>
                            08.30 WIB<br><br>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Acara Adat -->
                <div
                    class="bg-paper border border-lineColor rounded-3xl p-7 sm:p-8 shadow-[0_15px_40px_rgba(110,77,32,0.06)] flex flex-col justify-between">
                    <div>
                        <div class="text-2xl text-gold mb-2">✦</div>
                        <h3 class="font-serif text-3xl mb-2 font-normal">Acara Adat Nikah</h3>
                        <div class="text-inkMuted text-sm leading-relaxed">
                            <b class="text-ink">Sabtu, 12 Desember 2026</b><br>
                            11.00 WIB – selesai<br><br>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

     <!-- ================= LOKASI SECTION ================= -->
    <section id="lokasi" class="pb-20">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center mb-10">
                <div class="text-[11px] tracking-[0.28em] uppercase text-gold font-medium">Lokasi</div>
                <h2 class="font-serif text-4xl sm:text-5xl my-2 font-normal">See You There</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-7 items-stretch">
                <div class="h-80 rounded-3xl bg-[#e9dfcf] border border-lineColor grid place-items-center text-center p-6">
                    <div class="max-w-md">
                        <div class="text-2xl text-gold mb-2">⌖</div>
                        <h3 class="font-serif text-2xl font-normal mb-1">GKI Maulana Yusuf</h3>
                        <p class="text-xs text-inkMuted leading-relaxed mb-4">Holy Matrimony</p>
                        <a class="inline-flex items-center justify-center px-5 py-2.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wide hover:opacity-90 transition"
                            target="_blank" href="https://share.google/tMvZXZYjp9We7z9h7">
                            Buka di Google Maps
                        </a>
                    </div>
                </div>

                <div class="h-80 rounded-3xl bg-[#e9dfcf] border border-lineColor grid place-items-center text-center p-6">
                    <div class="max-w-md">
                        <div class="text-2xl text-gold mb-2">⌖</div>
                        <h3 class="font-serif text-2xl font-normal mb-1">Gedung Serba Guna Maduma Naramamora</h3>
                        <p class="text-xs text-inkMuted leading-relaxed mb-1">Acara Adat Nikah</p>
                        <a class="inline-flex items-center justify-center px-5 py-2.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wide hover:opacity-90 transition"
                            target="_blank" href="https://share.google/j0V7PsyMwFS6tsyyS">
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ================= GALERI FOTO (SEAMLESS INFINITE CAROUSEL) ================= -->
    <section id="gallery" class="pb-20 overflow-hidden">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center mb-10">
                <div class="text-[11px] tracking-[0.28em] uppercase text-gold font-medium">Sweet Moments</div>
                <h2 class="font-serif text-4xl sm:text-5xl my-2 font-normal">Galeri Foto</h2>
                <div class="text-gold">✦</div>
                <p class="text-xs text-inkMuted mt-1">Sentuh &amp; geser untuk melihat momen kebahagiaan kami</p>
            </div>

            <div class="relative max-w-4xl mx-auto group" id="carouselWrapper">
                <div class="overflow-hidden w-full rounded-2xl">
                    <div id="infiniteTrack" class="flex select-none cursor-grab active:cursor-grabbing">
                        <div class="carousel-item shrink-0 px-2 box-border w-[85%] sm:w-[50%] md:w-[33.333%]">
                            <div class="h-[390px] rounded-2xl overflow-hidden border border-goldBorder bg-paper shadow-md">
                                <img src="storage/images/img1.jpeg" alt="Moment 1"
                                    onerror="this.src='https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=700&q=80'"
                                    class="w-full h-full object-cover pointer-events-none">
                            </div>
                        </div>
                        <div class="carousel-item shrink-0 px-2 box-border w-[85%] sm:w-[50%] md:w-[33.333%]">
                            <div class="h-[390px] rounded-2xl overflow-hidden border border-goldBorder bg-paper shadow-md">
                                <img src="storage/images/img2.jpeg" alt="Moment 2"
                                    onerror="this.src='https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=700&q=80'"
                                    class="w-full h-full object-cover pointer-events-none">
                            </div>
                        </div>
                        <div class="carousel-item shrink-0 px-2 box-border w-[85%] sm:w-[50%] md:w-[33.333%]">
                            <div class="h-[390px] rounded-2xl overflow-hidden border border-goldBorder bg-paper shadow-md">
                                <img src="storage/images/img3.jpeg" alt="Moment 3"
                                    onerror="this.src='https://images.unsplash.com/photo-1606800052052-a08af7148866?auto=format&fit=crop&w=700&q=80'"
                                    class="w-full h-full object-cover pointer-events-none">
                            </div>
                        </div>
                        <div class="carousel-item shrink-0 px-2 box-border w-[85%] sm:w-[50%] md:w-[33.333%]">
                            <div class="h-[390px] rounded-2xl overflow-hidden border border-goldBorder bg-paper shadow-md">
                                <img src="storage/images/img4.jpeg" alt="Moment 4"
                                    onerror="this.src='https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=700&q=80'"
                                    class="w-full h-full object-cover pointer-events-none">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="prevSlideBtn" aria-label="Foto Sebelumnya"
                    class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full border border-gold bg-paper text-gold shadow-md flex items-center justify-center hover:bg-gold hover:text-white transition active:scale-95">
                    ‹
                </button>
                <button type="button" id="nextSlideBtn" aria-label="Foto Berikutnya"
                    class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full border border-gold bg-paper text-gold shadow-md flex items-center justify-center hover:bg-gold hover:text-white transition active:scale-95">
                    ›
                </button>

                <div id="carouselDots" class="flex justify-center items-center gap-2 mt-6"></div>
            </div>
        </div>
    </section>

    <!-- RSVP Section -->
    <section id="rsvp" class="pb-20">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center mb-10">
                <div class="text-[11px] tracking-[0.28em] uppercase text-gold font-medium">RSVP</div>
                <h2 class="font-serif text-4xl sm:text-5xl my-2 font-normal">Konfirmasi Kehadiran</h2>
                <div class="text-gold">✦</div>
            </div>

            <form method="post" action="rsvp/guest/{{$data->id}}/update"
                class="bg-paper border border-lineColor rounded-3xl p-7 sm:p-9 max-w-xl mx-auto shadow-[0_15px_40px_rgba(110,77,32,0.06)]">
                @csrf
                @method('PUT')
              @if ($data->has_answer)
    <div class="text-center mb-6">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gold/10 text-goldDark mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </span>
        <h3 class="font-serif text-xl text-ink font-semibold">Konfirmasi Anda Telah Diterima</h3>
        <p class="text-xs text-inkMuted mt-1">Terima kasih atas konfirmasi kehadiran yang telah Anda berikan.</p>
    </div>

    <!-- Ringkasan Data Konfirmasi -->
    <div class="bg-stone-50 border border-lineColor rounded-2xl p-4 sm:p-5 mb-6 space-y-3.5 text-xs">
        <div class="flex justify-between items-center pb-2.5 border-b border-lineColor/60">
            <span class="text-inkMuted uppercase tracking-wider font-semibold">Nama Tamu</span>
            <span class="font-medium text-ink">{{ $data->name }}</span>
        </div>

        <div class="flex justify-between items-center pb-2.5 border-b border-lineColor/60">
            <span class="text-inkMuted uppercase tracking-wider font-semibold">Status Kehadiran</span>
            @if ($data->is_attending === 'yes' || $data->is_attending === true || $data->is_attending)
                <span class="px-2.5 py-0.5 rounded-full font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Akan Hadir
                </span>
            @else
                <span class="px-2.5 py-0.5 rounded-full font-semibold bg-stone-100 text-stone-600 border border-stone-200">
                    Tidak Dapat Hadir
                </span>
            @endif
        </div>

        @if ($data->is_attending === 'yes' || $data->is_attending === true || $data->is_attending)
            <div class="flex justify-between items-center pb-2.5 border-b border-lineColor/60">
                <span class="text-inkMuted uppercase tracking-wider font-semibold">Jumlah Hadir</span>
                <span class="font-medium text-ink">{{ $data->amount_of_guest ?? 1 }} Orang</span>
            </div>
        @endif

        <div class="flex justify-between items-start pb-2.5 border-b border-lineColor/60">
            <span class="text-inkMuted uppercase tracking-wider font-semibold">Kelompok &amp; Lokasi</span>
            <div class="text-right">
                <span class="font-medium text-ink block">{{ $data->guest_category ?? 'Nasional Umum' }}</span>
                <span class="text-[11px] text-inkMuted">
                    {{ $data->is_private_cat ? 'Area Tenda (Lantai Dasar)' : 'Lantai 2 Gedung' }}
                </span>
            </div>
        </div>

        @if (!empty($data->wishes ?? $data->notes))
            <div class="pt-1">
                <span class="text-inkMuted uppercase tracking-wider font-semibold block mb-1.5">Ucapan &amp; Doa</span>
                <p class="text-ink italic pb-10 bg-white flex p-3 rounded-xl border border-lineColor/60 whitespace-pre-line">
                    <span>"{{ $data->wishes ?? $data->notes }}"</span>
                </p>
            </div>
        @endif
    </div>

    <!-- Tombol Opsi: Ubah Konfirmasi -->
    <div class="w-full flex justify-center">

    <button type="submit" name="has_answer_false" value="1"
        class="inline-flex items-center justify-center px-5 py-2.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wide hover:opacity-90 transition">
        Ubah Konfirmasi Kehadiran
    </button>

    </div>

@else

                    <label class="block text-xs font-semibold uppercase tracking-wider text-inkMuted mb-1">
                        Kelompok Undangan &amp; Lokasi Resepsi
                    </label>
                    <p class="text-[11px] text-inkMuted mb-3">Pilih kelompok undangan Anda untuk menentukan area tempat
                        duduk:</p>

                    <div class="grid grid-cols-1 gap-2.5 mb-5">
                        @if ($data->is_private_cat)
                            <label id="catLabelUmum"
                                class="cursor-pointer flex flex-col p-3.5 rounded-xl border border-gold bg-gold/5 transition select-none">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="guestCategory" value="Nasional Umum" checked
                                        class="accent-gold w-4 h-4 cursor-pointer">
                                    <span class="text-xs font-semibold text-ink">Nasional Umum (Keluarga Besar KSP /
                                        Umum)</span>
                                </div>
                                <span class="text-[11px] text-inkMuted ml-6 mt-1">
                                    Area Tenda (Lantai Dasar)
                                </span>
                            </label>
                        @else
                            <label id="catLabelPengantin"
                                class="cursor-pointer flex flex-col p-3.5 rounded-xl border border-gold bg-gold/5 transition select-none">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="guestCategory" value="Nasional Umum" checked
                                        class="accent-gold w-4 h-4 cursor-pointer"> <span
                                        class="text-xs font-semibold text-ink">Nasional Tamu Pengantin (Teman &amp;
                                        Kolega)</span>
                                </div>
                                <span class="text-[11px] text-inkMuted ml-6 mt-1">
                                    Lantai 2 Gedung
                                </span>
                            </label>
                        @endif


                    </div>

                    <label for="rsvpName"
                        class="block text-xs font-semibold uppercase tracking-wider text-inkMuted mb-1">Nama</label>
                    <input id="rsvpName" type="text" disabled placeholder="Nama Anda" autocomplete="name"
                        class="w-full px-3.5 py-3 border border-lineColor rounded-xl mb-3.5 text-sm bg-stone-100 focus:outline-none focus:ring-1 focus:ring-gold focus:border-gold"
                        value="{{$data->name}}">

                    <label class="block text-xs font-semibold uppercase tracking-wider text-inkMuted mb-1">Kehadiran</label>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <input type="hidden" name="is_attending" id="is_attendingInput" value="{{ $data->is_attending ? 1 : 0 }}">
                        <button type="button" id="yesBtn"
                            class="px-4 py-3 border {{ $data->is_attending ? 'btn-active-primary' : '' }} border-gold rounded-full cursor-pointer text-goldDark font-semibold text-xs tracking-wide hover:bg-gold/10 transition text-center">
                            Saya Akan Hadir
                        </button>
                        <button type="button" id="noBtn"
                            class="px-4 py-3 border border-gold {{ !$data->is_attending ? 'btn-active-primary' : '' }} rounded-full cursor-pointer text-goldDark font-semibold text-xs tracking-wide hover:bg-gold/10 transition text-center">
                            Tidak Dapat Hadir
                        </button>
                    </div>

                    <label class="block text-xs font-semibold uppercase tracking-wider text-inkMuted text-center">Jumlah
                        Tamu</label>
                    <div class="flex items-center justify-center gap-5 my-3">
                        <button type="button" id="decreaseGuestBtn"
                            class="w-10 h-10 flex items-center justify-center border border-gold rounded-full text-goldDark text-lg hover:bg-gold hover:text-white transition">
                            −</button>

                    <input type="hidden" name="amount_of_guest" id="guestInput" value="{{ $data->amount_of_guest }}">

                        <strong id="guestCount" class="font-serif text-4xl text-goldDark w-8 text-center font-normal">{{ $data->amount_of_guest ?? 1 }}</strong>
                        <button type="button" id="increaseGuestBtn"
                            class="w-10 h-10 flex items-center justify-center border border-gold rounded-full text-goldDark text-lg hover:bg-gold hover:text-white transition">
                            +</button>
                    </div>

                    <label for="rsvpWish" class="block text-xs font-semibold uppercase tracking-wider text-inkMuted mb-1">
                        Ucapan &amp; Doa <span class="text-xs normal-case text-inkMuted/70">(opsional)</span>
                    </label>
                    <textarea id="rsvpWish" name="wishes" rows="4" placeholder="Tuliskan ucapan untuk Christy & Gideon..."
                        class="w-full px-3.5 py-3 border border-lineColor rounded-xl mb-4 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-gold focus:border-gold">{{ $data->wishes }}</textarea>

                    <button type="submit" id="sendrsvp"
                        class="w-full py-3.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wider uppercase hover:opacity-90 shadow-sm transition">
                        Kirim Konfirmasi
                    </button>
                    <p id="rsvpError" class="text-xs text-[#9b4d35] mt-3 text-center"></p>

                @endif

            </form>
        </div>
    </section>

    <!-- Wedding Gift (Amplop Digital) -->
    <section id="gift" class="pb-20">
        <div class="max-w-6xl mx-auto px-5">
            <div class="text-center mb-10">
                <div class="text-[11px] tracking-[0.28em] uppercase text-gold font-medium">Wedding Gift</div>
                <h2 class="font-serif text-4xl sm:text-5xl my-2 font-normal">Amplop Digital</h2>
                <div class="text-gold">✦</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                <!-- Rekening Pengantin Pria -->
                <div
                    class="bg-paper border border-lineColor rounded-3xl p-8 text-center shadow-[0_15px_40px_rgba(110,77,32,0.06)]">
                    <div class="text-gold font-bold tracking-wider text-sm">BANK CENTRAL ASIA</div>
                    <div class="font-serif font-semibold text-3xl tracking-wide my-2">7771 753 322</div>
                    <p class="text-inkMuted text-sm mb-4">a.n. Gideon Mula Gabe Sitorus</p>
                    <button id="copyRekAccount1"
                        class="px-5 py-2.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wide hover:opacity-90 transition">
                        Salin Nomor Rekening
                    </button>
                    <p id="copyMsg1" class="text-xs text-inkMuted mt-3 min-h-[1rem]"></p>
                </div>

                <!-- Rekening Pengantin Wanita -->
                <div
                    class="bg-paper border border-lineColor rounded-3xl p-8 text-center shadow-[0_15px_40px_rgba(110,77,32,0.06)]">
                    <div class="text-gold font-bold tracking-wider text-sm">BANK CENTRAL ASIA</div>
                    <div class="font-serif font-semibold text-3xl tracking-wide my-2">4341 180 320</div>
                    <p class="text-inkMuted text-sm mb-4">a.n. Christy Audy Valentine</p>
                    <button id="copyRekAccount2"
                        class="px-5 py-2.5 bg-gold text-white border border-gold rounded-full font-semibold text-xs tracking-wide hover:opacity-90 transition">
                        Salin Nomor Rekening
                    </button>
                    <p id="copyMsg2" class="text-xs text-inkMuted mt-3 min-h-[1rem]"></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="pb-26 px-5 text-center ">
        <div class="font-serif text-4xl sm:text-5xl text-goldDark mb-2 font-normal">Christy &amp; Gideon</div>
        <p class="text-xs text-inkMuted leading-relaxed">Dua hati · Satu tujuan · Sepanjang jalan</p>
        <div class="text-gold my-2">✦</div>
        <p class="text-xs text-inkMuted leading-relaxed">Terima kasih atas doa, kasih, dan kehadiran Anda.</p>
    </footer>

    <!-- Floating Audio Control Button (Dinaikkan sedikit ke bottom-24 agar tidak bentrok dengan floating nav) -->
    <div class="fixed right-5 bottom-24 z-30">
        <button id="musicBtn" aria-label="Putar musik"
            class="w-12 h-12 rounded-full border border-gold bg-[#fffaf2] text-gold shadow-lg flex items-center justify-center hover:scale-105 active:scale-95 transition">
            ♫
        </button>
    </div>

    <!-- ================= DUAL AUDIO ENGINE ================= -->
    <audio id="weddingAudio" loop preload="auto">
        <source src="storage/sounds/song.mp3" type="audio/mpeg">
    </audio>

    <div id="ytPlayerContainer" class="fixed -left-[9999px] -bottom-[9999px] opacity-0 pointer-events-none">
        <div id="ytPlayer"></div>
    </div>
@endsection
