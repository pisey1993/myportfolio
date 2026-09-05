import Alpine from 'alpinejs';

window.Alpine = Alpine;

/* ── Central animation helpers ──────────────────────────────────
   Small, dependency-free utilities shared by the public site and
   the admin panel. See resources/css/app.css for the matching
   tokens/keyframes/classes these rely on. */
window.Toast = function (message, type) {
    var region = document.getElementById('toast-region');
    if (!region || !message) return;

    var el = document.createElement('div');
    el.className = 'toast' + (type === 'error' ? ' is-error' : type === 'success' ? ' is-success' : '');
    var msg = document.createElement('span');
    msg.className = 'toast-msg';
    msg.textContent = message;
    var close = document.createElement('span');
    close.className = 'toast-close';
    close.textContent = '×';
    el.appendChild(msg);
    el.appendChild(close);

    var remove = function () {
        el.classList.add('is-leaving');
        setTimeout(function () { el.remove(); }, 220);
    };
    close.addEventListener('click', remove);
    region.appendChild(el);
    setTimeout(remove, 4200);
};

/* Auto-disable + spinner on any form's submit button, preventing
   double-submits app-wide. Opt out with data-no-autoload on <form>. */
document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-no-autoload')) return;
    var btn = form.querySelector('button[type="submit"]');
    if (btn && !btn.disabled) {
        btn.classList.add('is-loading');
        btn.disabled = true;
    }
});

/* Count-up numbers: <span data-countup="1250"> animates once when it
   first scrolls into view. Respects prefers-reduced-motion. */
(function () {
    var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function animateCount(el) {
        var target = parseFloat(el.getAttribute('data-countup'));
        if (isNaN(target)) return;
        var prefix = el.getAttribute('data-countup-prefix') || '';
        var suffix = el.getAttribute('data-countup-suffix') || '';

        if (reduced) {
            el.textContent = prefix + target.toLocaleString() + suffix;
            return;
        }

        var duration = 900, start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = prefix + Math.round(target * eased).toLocaleString() + suffix;
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var els = document.querySelectorAll('[data-countup]');
        if (!els.length) return;
        if (!('IntersectionObserver' in window)) {
            els.forEach(animateCount);
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        els.forEach(function (el) { io.observe(el); });
    });
})();

/* Scroll reveal: elements carrying .anim-stagger or [data-reveal] fade in
   as they scroll into view and fade back out as they scroll away in
   either direction (not a one-time reveal) — mirrors the CSS transition
   in app.css, which supplies the delay before each fade actually starts.
   A short fallback timer force-reveals anything still hidden after 3s so
   content never gets stuck invisible if the observer misfires. */
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var els = document.querySelectorAll('.anim-stagger, [data-reveal]');
        if (!els.length) return;

        if (!('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                entry.target.classList.toggle('is-visible', entry.isIntersecting);
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        els.forEach(function (el) { io.observe(el); });

        // Safety net: never leave content permanently invisible if the
        // observer never fires for some reason (still toggles normally on
        // scroll afterwards, since the observer keeps watching).
        setTimeout(function () {
            els.forEach(function (el) { el.classList.add('is-visible'); });
        }, 8000);
    });
})();

Alpine.start();
