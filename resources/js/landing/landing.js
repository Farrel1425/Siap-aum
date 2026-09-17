$('.btn-toggle-password').on('click', function () {
    var $this = $(this);
    var $input = $this.closest('.input-group, .sa-login-field').find('input');
    var type = $input.attr('type') === 'password' ? 'text' : 'password';
    $input.attr('type', type);
    $this.toggleClass('isax-eye-slash isax-eye');
});

document.addEventListener('DOMContentLoaded', function () {
    var navbar = document.querySelector('.sa-navbar-wrap');
    var mobileNavbar = document.querySelector('.navbar.fixed-bottom');
    var navLinks = Array.from(document.querySelectorAll('.sa-navbar__links a[href*="#"]'));
    var revealTargets = document.querySelectorAll(
        '.sa-about > .sa-eyebrow, .sa-about > h2, .sa-about__visual, .sa-soft-card, ' +
        '.sa-recap .sa-section-heading, .sa-stat-card, .sa-survey, .sa-guide .sa-section-heading, ' +
        '.sa-step-card, .sa-guide__brand, .sa-check .sa-section-heading, .sa-check__form, ' +
        '.sa-why .sa-section-heading, .sa-why-card, .sa-download, .sa-footer__content > *, .sa-footer__bottom'
    );
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var lastScrollY = window.scrollY;
    var ticking = false;

    if (navbar) {
        var updateNavbar = function () {
            var currentScrollY = Math.max(window.scrollY, 0);
            var movingDown = currentScrollY > lastScrollY;

            navbar.classList.toggle('is-scrolled', currentScrollY > 90);
            navbar.classList.toggle('is-hidden', movingDown && currentScrollY > 180);
            if (mobileNavbar) mobileNavbar.classList.toggle('is-hidden', movingDown && currentScrollY > 180);
            lastScrollY = currentScrollY;
            ticking = false;
        };

        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        }, { passive: true });
    }

    if (!reduceMotion && 'IntersectionObserver' in window) {
        revealTargets.forEach(function (element, index) {
            element.classList.add('sa-reveal');
            element.style.setProperty('--sa-reveal-delay', (index % 4) * 70 + 'ms');
        });

        var revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

        revealTargets.forEach(function (element) { revealObserver.observe(element); });
    }

    var sections = Array.from(document.querySelectorAll('.siap-aum-landing section[id], .sa-footer[id]'));
    if ('IntersectionObserver' in window && navLinks.length) {
        var sectionObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                navLinks.forEach(function (link) {
                    link.classList.toggle('is-active', link.hash === '#' + entry.target.id);
                });
            });
        }, { rootMargin: '-35% 0px -55% 0px' });
        sections.forEach(function (section) { sectionObserver.observe(section); });
    }

    var carousel = document.querySelector('.sa-download');
    if (carousel) {
        var track = carousel.querySelector('.sa-download__track');
        var slides = Array.from(carousel.querySelectorAll('.sa-download__slide'));
        var dots = Array.from(carousel.querySelectorAll('.sa-download__dots button'));
        var previousButton = carousel.querySelector('[data-carousel-prev]');
        var nextButton = carousel.querySelector('[data-carousel-next]');
        var activeSlide = 0;
        var autoplayTimer = null;
        var pointerStartX = null;

        var showSlide = function (index) {
            activeSlide = (index + slides.length) % slides.length;
            track.style.transform = 'translate3d(-' + (activeSlide * 100) + '%, 0, 0)';

            slides.forEach(function (slide, slideIndex) {
                slide.setAttribute('aria-hidden', slideIndex === activeSlide ? 'false' : 'true');
            });
            dots.forEach(function (dot, dotIndex) {
                var isActive = dotIndex === activeSlide;
                dot.classList.toggle('is-active', isActive);
                dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
        };

        var stopAutoplay = function () {
            if (autoplayTimer) window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        };
        var startAutoplay = function () {
            stopAutoplay();
            if (!reduceMotion && !document.hidden) {
                autoplayTimer = window.setInterval(function () { showSlide(activeSlide + 1); }, 5600);
            }
        };

        dots.forEach(function (dot, index) {
            dot.addEventListener('click', function () { showSlide(index); startAutoplay(); });
        });
        previousButton.addEventListener('click', function () { showSlide(activeSlide - 1); startAutoplay(); });
        nextButton.addEventListener('click', function () { showSlide(activeSlide + 1); startAutoplay(); });
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);
        carousel.addEventListener('focusin', stopAutoplay);
        carousel.addEventListener('focusout', function (event) {
            if (!carousel.contains(event.relatedTarget)) startAutoplay();
        });
        carousel.addEventListener('pointerdown', function (event) { pointerStartX = event.clientX; });
        carousel.addEventListener('pointerup', function (event) {
            if (pointerStartX === null) return;
            var distance = event.clientX - pointerStartX;
            if (Math.abs(distance) > 55) showSlide(activeSlide + (distance < 0 ? 1 : -1));
            pointerStartX = null;
            startAutoplay();
        });
        carousel.addEventListener('pointercancel', function () { pointerStartX = null; });
        document.addEventListener('visibilitychange', function () { document.hidden ? stopAutoplay() : startAutoplay(); });
        showSlide(0);
        startAutoplay();
    }
});
