/**
 * Main Theme JavaScript Actions
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

document.addEventListener('DOMContentLoaded', function () {

    // --- 1. STICKY GLASSMORPHIC HEADER ---
    const header = document.getElementById('pbi-masthead');
    
    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
        
        // Initial state check
        if (window.scrollY > 50) {
            header.classList.add('sticky');
        }
    }

    // --- 2. MOBILE MENU HAMBURGER NAVIGATION ---
    const menuToggle = document.getElementById('pbi-menu-toggle');
    const siteNav = document.getElementById('pbi-site-nav');

    if (menuToggle && siteNav) {
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            menuToggle.classList.toggle('active');
            siteNav.classList.toggle('active');
        });

        // Close menu when clicking navigation link on mobile
        const navLinks = siteNav.querySelectorAll('a');
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                menuToggle.classList.remove('active');
                siteNav.classList.remove('active');
            });
        });
    }

    // --- 3. DYNAMIC PRAYER TIMES WIDGET (API INTEGRATION WITH AUTO LOCATION) ---
    const prayerLocationEl = document.getElementById('pbi-prayer-location');
    const prayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];

    if (prayerLocationEl) {
        // Step 1: Detect user location automatically via free IP Geolocation API
        fetch('https://ipapi.co/json/')
            .then(res => res.json())
            .then(loc => {
                const city = loc.city || 'Bandung';
                const country = loc.country_name || 'Indonesia';
                loadPrayerTimes(city, country);
            })
            .catch(() => {
                // Fallback to Bandung if location lookup fails
                loadPrayerTimes('Bandung', 'Indonesia');
            });
    }

    function loadPrayerTimes(city, country) {
        fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=11`)
            .then(response => response.json())
            .then(data => {
                if (data && data.code === 200) {
                    const timings = data.data.timings;
                    const dateInfo = data.data.date.readable;
                    
                    prayerLocationEl.innerText = `Kota ${city} - ${dateInfo}`;

                    // Update timings inside cards
                    prayers.forEach(prayer => {
                        const card = document.getElementById(`pbi-prayer-${prayer}`);
                        if (card) {
                            const timeEl = card.querySelector('.pbi-prayer-card__time');
                            if (timeEl) {
                                timeEl.innerText = timings[prayer];
                            }
                        }
                    });

                    // Highlight active/next prayer
                    highlightActivePrayer(timings);
                }
            })
            .catch(err => {
                console.error('Gagal mengambil jadwal sholat:', err);
                prayerLocationEl.innerText = `Kota ${city} (Offline / Gagal memuat)`;
            });
    }

    function highlightActivePrayer(timings) {
        const now = new Date();
        const currentHours = now.getHours();
        const currentMins = now.getMinutes();
        const currentTimeInMins = currentHours * 60 + currentMins;

        let activePrayer = 'Isha'; // Fallback
        
        // Convert timing string to minutes
        const timeToMins = (timeStr) => {
            const parts = timeStr.split(':');
            return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
        };

        const fajrMins = timeToMins(timings['Fajr']);
        const dhuhrMins = timeToMins(timings['Dhuhr']);
        const asrMins = timeToMins(timings['Asr']);
        const maghribMins = timeToMins(timings['Maghrib']);
        const ishaMins = timeToMins(timings['Isha']);

        // Determine current/next prayer
        if (currentTimeInMins >= fajrMins && currentTimeInMins < dhuhrMins) {
            activePrayer = 'Fajr';
        } else if (currentTimeInMins >= dhuhrMins && currentTimeInMins < asrMins) {
            activePrayer = 'Dhuhr';
        } else if (currentTimeInMins >= asrMins && currentTimeInMins < maghribMins) {
            activePrayer = 'Asr';
        } else if (currentTimeInMins >= maghribMins && currentTimeInMins < ishaMins) {
            activePrayer = 'Maghrib';
        } else {
            activePrayer = 'Isha';
        }

        const activeCard = document.getElementById(`pbi-prayer-${activePrayer}`);
        if (activeCard) {
            activeCard.classList.add('active');
        }
    }


    // --- 4. REAL-TIME EVENT COUNTDOWN ---
    const countdownContainer = document.querySelector('.pbi-countdown');
    
    if (countdownContainer) {
        const eventDateStr = countdownContainer.getAttribute('data-countdown-date');
        
        if (eventDateStr) {
            // Target date is event date at 09:00:00 AM
            const targetDate = new Date(`${eventDateStr}T09:00:00`).getTime();

            const daysEl = document.getElementById('pbi-cd-days');
            const hoursEl = document.getElementById('pbi-cd-hours');
            const minsEl = document.getElementById('pbi-cd-mins');
            const secsEl = document.getElementById('pbi-cd-secs');

            const updateCountdown = () => {
                const now = new Date().getTime();
                const difference = targetDate - now;

                if (difference <= 0) {
                    // Event has started
                    if (daysEl) daysEl.innerText = '00';
                    if (hoursEl) hoursEl.innerText = '00';
                    if (minsEl) minsEl.innerText = '00';
                    if (secsEl) secsEl.innerText = '00';
                    clearInterval(countdownInterval);
                    return;
                }

                // Calculations
                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                // Pad zeros
                if (daysEl) daysEl.innerText = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.innerText = String(hours).padStart(2, '0');
                if (minsEl) minsEl.innerText = String(minutes).padStart(2, '0');
                if (secsEl) secsEl.innerText = String(seconds).padStart(2, '0');
            };

            updateCountdown(); // Run immediately
            const countdownInterval = setInterval(updateCountdown, 1000);
        }
    }

});
