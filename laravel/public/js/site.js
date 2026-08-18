// Mahaveer Hospital — Frontend JS
(function () {
    // Mobile menu toggle
    const toggle = document.querySelector('[data-mobile-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('open');
            document.body.classList.toggle('menu-open', menu.classList.contains('open'));
        });
        // Close on link click
        menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
            menu.classList.remove('open');
            document.body.classList.remove('menu-open');
        }));
    }

    // Desktop "More" dropdown click support (mobile-first tap)
    document.querySelectorAll('.nav-more > button').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            btn.parentElement.classList.toggle('open');
        });
    });
    document.addEventListener('click', (e) => {
        document.querySelectorAll('.nav-more.open').forEach(el => {
            if (!el.contains(e.target)) el.classList.remove('open');
        });
    });

    // Flatpickr — beautiful calendar for date inputs
    if (typeof flatpickr !== 'undefined') {
        document.querySelectorAll('input[type="date"]').forEach(el => {
            flatpickr(el, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'D, d M Y',
                minDate: 'today',
                disableMobile: true,
                monthSelectorType: 'static',
                animate: true,
                allowInput: false,
                onReady: function(_dateObj, _dateStr, instance) {
                    if (instance.altInput) {
                        instance.altInput.setAttribute('placeholder', 'Select preferred date');
                        instance.altInput.setAttribute('data-testid', el.getAttribute('data-testid') + '-visible');
                        // Copy required styling
                        instance.altInput.classList.add('flatpickr-alt');
                    }
                },
            });
        });
    }

    // Reveal on scroll
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('in-view');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.14 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    // Simple lightbox for gallery
    document.querySelectorAll('[data-gallery-item]').forEach(el => {
        el.addEventListener('click', () => {
            const src = el.getAttribute('data-src');
            if (!src) return;
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed;inset:0;background:rgba(15,23,32,0.92);z-index:9999;display:grid;place-items:center;padding:2rem;cursor:zoom-out;';
            overlay.innerHTML = `<img src="${src}" style="max-width:96%;max-height:96%;border-radius:16px;box-shadow:0 30px 80px rgba(0,0,0,.5);" alt=""/>`;
            overlay.addEventListener('click', () => overlay.remove());
            document.body.appendChild(overlay);
        });
    });

    // CSRF for fetch
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrf) window._csrf = csrf;
})();
