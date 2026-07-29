/**
 * Statistics Counters Scrolling Animation
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

document.addEventListener('DOMContentLoaded', function () {

    const counterElements = document.querySelectorAll('.pbi-stat-item__number');

    if (counterElements.length > 0) {
        
        const countUp = function (el) {
            const target = parseInt(el.getAttribute('data-target'), 10) || 0;
            const duration = 2000; // 2 seconds animation
            const start = 0;
            const startTime = performance.now();

            const updateCount = function (currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Easing formula (easeOutQuad)
                const easedProgress = progress * (2 - progress);
                
                const currentValue = Math.floor(start + (target - start) * easedProgress);

                // Format number with thousands separator
                el.innerText = formatNumber(currentValue);

                if (progress < 1) {
                    requestAnimationFrame(updateCount);
                } else {
                    el.innerText = formatNumber(target) + '+';
                }
            };

            requestAnimationFrame(updateCount);
        };

        const formatNumber = function (num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };

        // Intersection Observer to start animation when visible on screen
        const observerOptions = {
            root: null,
            threshold: 0.1 // Trigger when 10% of element is visible
        };

        const observer = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    countUp(el);
                    observer.unobserve(el); // Only run once
                }
            });
        }, observerOptions);

        counterElements.forEach(function (el) {
            observer.observe(el);
        });

    }

});
