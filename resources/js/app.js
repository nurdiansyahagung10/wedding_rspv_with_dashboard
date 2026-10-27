document.addEventListener("DOMContentLoaded", () => {
    let guestCount = parseInt(document.getElementById("guestInput")?.value || "1", 10);
    const target = new Date("2026-12-12T08:30:00+07:00").getTime();

    let isAudioPlaying = false;
    let ytPlayer = null;
    let useYTFallback = false;
    const audioElement = document.getElementById("weddingAudio");
    const musicBtn = document.getElementById("musicBtn");

    // Fungsi Play Musik
    function playMusic() {
        const playPromise = audioElement.play();

        if (playPromise !== undefined) {
            playPromise.then(() => {
                isAudioPlaying = true;
                updateMusicButtonState(true);
            })
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

    const yesBtn = document.getElementById('yesBtn');
    const noBtn = document.getElementById('noBtn');
    const guestCountSection = document.getElementById('guestCountSection');

    if (yesBtn) {
        yesBtn.addEventListener("click", function (e) {
            yesBtn.classList.add("btn-active-primary");
            if (noBtn) noBtn.classList.remove("btn-active-primary");
            if (is_attendingInput) is_attendingInput.value = "1";
            if (guestCountSection) guestCountSection.classList.remove("opacity-50", "pointer-events-none");
        });
    }

    if (noBtn) {
        noBtn.addEventListener("click", function (e) {
            if (yesBtn) yesBtn.classList.remove("btn-active-primary");
            noBtn.classList.add("btn-active-primary");
            if (is_attendingInput) is_attendingInput.value = "0";
            if (guestCountSection) guestCountSection.classList.add("opacity-50", "pointer-events-none");
        });
    }

    if (document.getElementById("decreaseGuestBtn")) {
        document.getElementById("decreaseGuestBtn").addEventListener('click', function () {
            guestCount = Math.max(1, Math.min(10, guestCount - 1));
            document.getElementById("guestCount").textContent = guestCount;
            document.getElementById("guestInput").value = guestCount;
        });
    }
    if (document.getElementById("increaseGuestBtn")) {
        document.getElementById("increaseGuestBtn").addEventListener('click', function () {
            guestCount = Math.max(1, Math.min(10, guestCount + 1));
            document.getElementById("guestCount").textContent = guestCount;
            document.getElementById("guestInput").value = guestCount;
        });
    }

    // RSVP Form AJAX Submission
    const rsvpForm = document.getElementById("rsvpForm");
    const rsvpLoader = document.getElementById("rsvpLoader");
    const rsvpSummary = document.getElementById("rsvpSummary");
    const rsvpFormContent = document.getElementById("rsvpFormContent");
    const rsvpError = document.getElementById("rsvpError");
    const sendrsvpBtn = document.getElementById("sendrsvp");
    const btnEditRsvp = document.getElementById("btnEditRsvp");

    if (rsvpForm) {
        rsvpForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            if (rsvpLoader) rsvpLoader.classList.remove("hidden");
            if (sendrsvpBtn) sendrsvpBtn.disabled = true;
            if (rsvpError) {
                rsvpError.classList.add("hidden");
                rsvpError.textContent = "";
            }

            try {
                const formData = new FormData(rsvpForm);
                formData.set('_method', 'PUT');

                const response = await fetch(rsvpForm.action, {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || "Gagal menyimpan konfirmasi.");
                }

                // Update summary UI values
                const isAttending = result.data.is_attending;
                const badgeEl = document.getElementById("summaryAttendingBadge");
                if (badgeEl) {
                    if (isAttending) {
                        badgeEl.innerHTML = `<span class="px-2.5 py-0.5 rounded-full font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Akan Hadir</span>`;
                    } else {
                        badgeEl.innerHTML = `<span class="px-2.5 py-0.5 rounded-full font-semibold bg-stone-100 text-stone-600 border border-stone-200">Tidak Dapat Hadir</span>`;
                    }
                }

                const guestCountRow = document.getElementById("summaryGuestCountRow");
                const summaryGuestCount = document.getElementById("summaryGuestCount");
                if (guestCountRow && summaryGuestCount) {
                    if (isAttending) {
                        summaryGuestCount.textContent = (result.data.amount_of_guest || 1) + " Orang";
                        guestCountRow.classList.remove("hidden");
                    } else {
                        guestCountRow.classList.add("hidden");
                    }
                }

                const wishesRow = document.getElementById("summaryWishesRow");
                const wishesText = document.getElementById("summaryWishesText");
                if (wishesRow && wishesText) {
                    const wishesVal = (result.data.wishes || "").trim();
                    if (wishesVal) {
                        wishesText.textContent = `"${wishesVal}"`;
                        wishesRow.classList.remove("hidden");
                    } else {
                        wishesRow.classList.add("hidden");
                    }
                }

                // Switch to summary view
                if (rsvpFormContent) rsvpFormContent.classList.add("hidden");
                if (rsvpSummary) rsvpSummary.classList.remove("hidden");

            } catch (err) {
                if (rsvpError) {
                    rsvpError.textContent = err.message || "Terjadi kesalahan saat menyimpan konfirmasi. Silakan coba lagi.";
                    rsvpError.classList.remove("hidden");
                }
            } finally {
                if (rsvpLoader) rsvpLoader.classList.add("hidden");
                if (sendrsvpBtn) sendrsvpBtn.disabled = false;
            }
        });
    }

    if (btnEditRsvp && rsvpForm) {
        btnEditRsvp.addEventListener("click", async function () {
            if (rsvpLoader) rsvpLoader.classList.remove("hidden");
            btnEditRsvp.disabled = true;

            try {
                const csrfToken = rsvpForm.querySelector('input[name="_token"]')?.value || "";
                const formData = new FormData();
                formData.set('_token', csrfToken);
                formData.set('_method', 'PUT');
                formData.set('has_answer_false', '1');

                const response = await fetch(rsvpForm.action, {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || "Gagal membuka form konfirmasi.");
                }

                // Switch back to form view
                if (rsvpSummary) rsvpSummary.classList.add("hidden");
                if (rsvpFormContent) rsvpFormContent.classList.remove("hidden");

            } catch (err) {
                alert(err.message || "Terjadi kesalahan. Silakan coba lagi.");
            } finally {
                if (rsvpLoader) rsvpLoader.classList.add("hidden");
                btnEditRsvp.disabled = false;
            }
        });
    }



    const wishesMore = document.getElementById("wishesMore");
    if (wishesMore) {
        wishesMore.addEventListener("click", async () => {
            const err = document.getElementById("wishesError");
            wishesMore.disabled = true;
            err.classList.add("hidden");
            try {
                const res = await fetch(wishesMore.dataset.url, { headers: { Accept: "application/json" } });
                if (!res.ok) throw new Error();
                const { html, next } = await res.json();
                document.getElementById("wishesList").insertAdjacentHTML("beforeend", html);
                if (next) {
                    wishesMore.dataset.url = next;
                    wishesMore.disabled = false;
                } else {
                    wishesMore.parentElement.remove();
                }
            } catch {
                err.classList.remove("hidden");
                wishesMore.disabled = false;
            }
        });
    }

    document.getElementById('copyRekAccount1').addEventListener('click', function () {
        copyAccount('7771753322', 'copyMsg1')
    });
    document.getElementById('copyRekAccount2').addEventListener('click', function () {
        copyAccount('4341180320', 'copyMsg2')
    });


});
