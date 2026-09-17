const hidePageLoader = () => {
    document.querySelectorAll('.loader-container').forEach((loader) => {
        if (loader.classList.contains('is-leaving')) return;

        loader.classList.add('is-leaving');
        window.setTimeout(() => loader.remove(), 250);
    });
};

// The page is usable once its DOM is ready. Optional images, fonts, and
// third-party scripts must not keep the interface covered by the loader.
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', hidePageLoader, { once: true });
} else {
    hidePageLoader();
}

// Safety net if another script interrupts page initialisation.
window.setTimeout(hidePageLoader, 1500);
