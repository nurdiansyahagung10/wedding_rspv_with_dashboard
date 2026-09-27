document.addEventListener("DOMContentLoaded", () => {
    let guestCount = 1;
    const target = new Date("2026-12-12T08:30:00+07:00").getTime();

    let isAudioPlaying = false;
    let ytPlayer = null;
    let useYTFallback = false;
    const audioElement = document.getElementById("weddingAudio");
    const musicBtn = document.getElementById("musicBtn");
    const yesBtn = document.getElementById("yesBtn");
    const noBtn = document.getElementById("noBtn");

    // Fungsi Play Musik
    function playMusic() {
        const playPromise = audioElement.play();

        if (playPromise !== undefined) {
            playPromise.then(() => {
                isAudioPlaying = true;
                useYTFallback = false;
                updateMusicButtonState(true);
            }).catch(() => {
                if (ytPlayer && typeof ytPlayer.playVideo === "function") {
                    ytPlayer.playVideo();
                    isAudioPlaying = true;
                    useYTFallback = true;
                    updateMusicButtonState(true);
                }
            });
        } else if (ytPlayer && typeof ytPlayer.playVideo === "function") {
            ytPlayer.playVideo();
            isAudioPlaying = true;
            useYTFallback = true;
            updateMusicButtonState(true);
        }
    }

    // Fungsi Pause Musik
    function pauseMusic() {
        if (useYTFallback && ytPlayer && typeof ytPlayer.pauseVideo === "function") {
            ytPlayer.pauseVideo();
        } else {
            audioElement.pause();
        }
        isAudioPlaying = false;
        updateMusicButtonState(false);
    }

    function updateMusicButtonState(playing) {
        if (playing) {
            musicBtn.textContent = "Ⅱ";
            musicBtn.classList.add("music-spinning", "bg-gold", "text-white");
            musicBtn.classList.remove("bg-[#fffaf2]", "text-gold");
        } else {
            musicBtn.textContent = "♫";
            musicBtn.classList.remove("music-spinning", "bg-gold", "text-white");
            musicBtn.classList.add("bg-[#fffaf2]", "text-gold");
        }
    }


    // 2. Countdown Timer
    function tick() {
        const d = Math.max(0, target - Date.now());
        document.getElementById("days").textContent = Math.floor(d / 86400000);
        document.getElementById("hours").textContent = String(Math.floor(d % 86400000 / 3600000)).padStart(2, "0");
        document.getElementById("mins").textContent = String(Math.floor(d % 3600000 / 60000)).padStart(2, "0");
        document.getElementById("secs").textContent = String(Math.floor(d % 60000 / 1000)).padStart(2, "0");
    }
    tick();
    setInterval(tick, 1000);

    // ================= 3. SEAMLESS INFINITE CAROUSEL ENGINE =================
    const track = document.getElementById("infiniteTrack");
    const prevBtn = document.getElementById("prevSlideBtn");
    const nextBtn = document.getElementById("nextSlideBtn");
    const dotsContainer = document.getElementById("carouselDots");
    const carouselWrapper = document.getElementById("carouselWrapper");
    const is_attendingInput = document.getElementById("is_attendingInput");

    let originalItems = Array.from(track.children);
    const originalCount = originalItems.length;

    // Clone nodes di awal & akhir untuk ilusi loop tanpa putus
    originalItems.forEach(item => {
        const cloneEnd = item.cloneNode(true);
        cloneEnd.classList.add("clone");
        track.appendChild(cloneEnd);
    });
    originalItems.slice().reverse().forEach(item => {
        const cloneStart = item.cloneNode(true);
        cloneStart.classList.add("clone");
        track.insertBefore(cloneStart, track.firstChild);
    });

    let allItems = Array.from(track.children);
    let currentIndex = originalCount;
    let isTransitioning = false;
    let autoPlayTimer = null;

    // Generate titik navigasi
    for (let i = 0; i < originalCount; i++) {
        const dot = document.createElement("button");
        dot.className = `w-2 h-2 rounded-full transition-all duration-300 ${i === 0 ? 'bg-gold w-6' : 'bg-gold/30'}`;
        dot.setAttribute("aria-label", "Pindah ke foto " + (i + 1));
        dot.addEventListener("click", () => {
            moveToSlide(originalCount + i);
        });
        dotsContainer.appendChild(dot);
    }

    function updateDots() {
        const dots = dotsContainer.children;
        const normalizedIndex = (currentIndex - originalCount + originalCount) % originalCount;
        for (let i = 0; i < dots.length; i++) {
            if (i === normalizedIndex) {
                dots[i].className = "w-6 h-2 rounded-full bg-gold transition-all duration-300";
            } else {
                dots[i].className = "w-2 h-2 rounded-full bg-gold/30 transition-all duration-300";
            }
        }
    }

    function getSlideWidth() {
        return allItems[0].getBoundingClientRect().width;
    }

    function updateTrackPosition(withAnimation = true) {
        const width = getSlideWidth();
        track.style.transition = withAnimation ? "transform 0.5s ease-in-out" : "none";
        track.style.transform = `translateX(-${currentIndex * width}px)`;
        updateDots();
    }

    function moveToSlide(index) {
        if (isTransitioning) return;
        isTransitioning = true;
        currentIndex = index;
        updateTrackPosition(true);
    }

    nextBtn.addEventListener("click", () => {
        moveToSlide(currentIndex + 1);
        resetAutoPlay();
    });

    prevBtn.addEventListener("click", () => {
        moveToSlide(currentIndex - 1);
        resetAutoPlay();
    });

    track.addEventListener("transitionend", () => {
        isTransitioning = false;
        if (currentIndex >= originalCount * 2) {
            currentIndex = currentIndex - originalCount;
            updateTrackPosition(false);
        }
        if (currentIndex < originalCount) {
            currentIndex = currentIndex + originalCount;
            updateTrackPosition(false);
        }
    });

    function startAutoPlay() {
        autoPlayTimer = setInterval(() => {
            moveToSlide(currentIndex + 1);
        }, 3500);
    }
    function stopAutoPlay() {
        if (autoPlayTimer) clearInterval(autoPlayTimer);
    }
    function resetAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }

    carouselWrapper.addEventListener("mouseenter", stopAutoPlay);
    carouselWrapper.addEventListener("mouseleave", startAutoPlay);

    let touchStartX = 0;
    let touchCurrentX = 0;
    let isDragging = false;

    track.addEventListener("touchstart", (e) => {
        if (e.touches.length !== 1) return;

        stopAutoPlay();

        touchStartX = e.touches[0].clientX;
        touchCurrentX = touchStartX;
        isDragging = true;

        track.style.transition = "none";
    }, { passive: true });

    track.addEventListener("touchmove", (e) => {
        if (!isDragging || e.touches.length !== 1) return;

        touchCurrentX = e.touches[0].clientX;

        const diff = touchCurrentX - touchStartX;
        const width = getSlideWidth();

        track.style.transform =
            `translateX(calc(-${currentIndex * width}px + ${diff}px))`;
    }, { passive: true });

    track.addEventListener("touchend", () => {
        if (!isDragging) return;

        isDragging = false;

        const diff = touchStartX - touchCurrentX;
        const threshold = 40;

        track.style.transition = "transform 0.35s ease-out";

        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                moveToSlide(currentIndex + 1);
            } else {
                moveToSlide(currentIndex - 1);
            }
        } else {
            updateTrackPosition(true);
        }

        startAutoPlay();
    });

    window.addEventListener("resize", () => {
        updateTrackPosition(false);
    });

    updateTrackPosition(false);
    startAutoPlay();




    document.addEventListener("DOMContentLoaded", () => {
        const radios = document.getElementsByName("guestCategory");
        if (categoryParam == 1) {
            radios[1].checked = true;
        } else {
            radios[0].checked = true;
        }
        updateCategorySelection();
    });

    // 6. Copy Rekening
    function copyAccount(number, id) {
        navigator.clipboard?.writeText(number);
        document.getElementById(id).textContent = "Nomor rekening berhasil disalin.";
        setTimeout(() => {
            const el = document.getElementById(id);
            if (el) el.textContent = "";
        }, 3000);
    }




    document.getElementById("unlockInvitation").addEventListener("click", function () {
        const cover = document.getElementById("coverGate");
        cover.classList.add("-translate-y-full");

        document.getElementById("pageBody").classList.remove("overflow-hidden");
        document.getElementById("mainNav").classList.remove("hidden");

        // Putar musik tepat saat tombol ditekan
        playMusic();

        setTimeout(() => {
            cover.style.display = "none";
        }, 1000);
    }
    );
    document.getElementById("musicBtn").addEventListener("click", function () {
        if (isAudioPlaying) {
            pauseMusic();
        } else {
            playMusic();
        }
    });

    if(document.getElementById('yesBtn')){
    document.getElementById('yesBtn').addEventListener("click", function (e) {
        document.getElementById('yesBtn').classList.add("btn-active-primary");
        document.getElementById('noBtn').classList.remove("btn-active-primary");
        is_attendingInput.value = "1";
    });

    }

    if(document.getElementById('noBtn')){
    document.getElementById('noBtn').addEventListener("click", function (e) {
        document.getElementById('yesBtn').classList.remove("btn-active-primary");
        document.getElementById('noBtn').classList.add("btn-active-primary");
        is_attendingInput.value = "0";
    });

    }

    if(document.getElementById("decreaseGuestBtn")){
    document.getElementById("decreaseGuestBtn").addEventListener('click', function () {
        guestCount = Math.max(1, Math.min(10, guestCount - 1));
        document.getElementById("guestCount").textContent = guestCount;
        document.getElementById("guestInput").value = guestCount;
    });

    }
    if(document.getElementById("increaseGuestBtn")){
     document.getElementById("increaseGuestBtn").addEventListener('click', function () {
        guestCount = Math.max(1, Math.min(10, guestCount + 1));
        document.getElementById("guestCount").textContent = guestCount;
        document.getElementById("guestInput").value = guestCount;
    });

    }



    document.getElementById('copyRekAccount1').addEventListener('click', function () {
        copyAccount('7771753322', 'copyMsg1')
    });
    document.getElementById('copyRekAccount2').addEventListener('click', function () {
        copyAccount('4341180320', 'copyMsg2')
    });


});
