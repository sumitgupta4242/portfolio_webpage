document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const scrollContainer = document.getElementById('scroll-container');

    // --- 1. Dynamic Background Controller ---
    const backgroundObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const bgId = entry.target.dataset.bg;
            if (bgId) {
                const bgElement = document.getElementById(bgId);
                if (entry.isIntersecting) {
                    // Make current section's background visible
                    bgElement.classList.add('visible');
                    // Change accent color
                    const accentColor = entry.target.dataset.accent || '#7B2BFC';
                    root.style.setProperty('--accent-color', accentColor);
                } else {
                    bgElement.classList.remove('visible');
                }
            }
        });
    }, {
        threshold: 0.5 // Trigger when 50% of the section is visible
    });

    document.querySelectorAll('.fullscreen-section').forEach(section => {
        backgroundObserver.observe(section);
    });

    // --- 2. Scroll Progress Bar (based on the scroll container) ---
    const scrollProgressBar = document.getElementById('scroll-progress');
    scrollContainer.addEventListener('scroll', () => {
        const scrollTop = scrollContainer.scrollTop;
        const scrollHeight = scrollContainer.scrollHeight - scrollContainer.clientHeight;
        const scrollPercentage = (scrollTop / scrollHeight) * 100;
        scrollProgressBar.style.width = `${scrollPercentage}%`;
    });

    // --- 3. Generate Animated Elements for Backgrounds ---
    function generateBackgroundElements() {
        const auroraContainer = document.querySelector('[data-theme="aurora"]');
        if (auroraContainer) {
            for (let i = 0; i < 2; i++) {
                const layer = document.createElement('div');
                layer.className = 'aurora-layer';
                auroraContainer.appendChild(layer);
            }
        }

        const warpContainer = document.querySelector('[data-theme="warp"]');
        if (warpContainer) {
            for (let i = 0; i < 100; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.top = `${Math.random() * 100}%`;
                star.style.left = `${Math.random() * 100}%`;
                star.style.animationDelay = `${Math.random() * 3}s`;
                warpContainer.appendChild(star);
            }
        }
    }
    generateBackgroundElements();

    // --- 4. Custom Cursor Logic ---
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');
    window.addEventListener('mousemove', (e) => {
        cursorDot.style.left = `${e.clientX}px`;
        cursorDot.style.top = `${e.clientY}px`;
        cursorOutline.animate({
            left: `${e.clientX}px`,
            top: `${e.clientY}px`
        }, { duration: 500, fill: "forwards" });
    });
});