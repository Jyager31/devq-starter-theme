/**
 * DevQ Mobile Menu
 * Custom mobile menu replacing mmenu.js
 * Supports 3 styles: fullscreen, slidein, dropdown
 */
(function() {
  'use strict';

  const MOBILE_BREAKPOINT = 1199;
  let menuOpen = false;
  let menuStyle = 'fullscreen';
  let focusTrap = null;

  function init() {
    const menuEl = document.getElementById('devq-mobile-menu');
    if (!menuEl) return;

    menuStyle = menuEl.dataset.style || 'fullscreen';
    const toggle = document.getElementById('devq-menu-toggle');
    const close = document.getElementById('devq-menu-close');
    const backdrop = document.getElementById('devq-menu-backdrop');

    if (toggle) {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleMenu();
      });
    }

    if (close) {
      close.addEventListener('click', function(e) {
        e.preventDefault();
        closeMenu();
      });
    }

    if (backdrop) {
      backdrop.addEventListener('click', closeMenu);
    }

    // Escape key closes menu
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && menuOpen) {
        closeMenu();
      }
    });

    // Sub-menu toggles
    initSubMenus();

    // Close on resize to desktop
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        if (window.innerWidth > MOBILE_BREAKPOINT && menuOpen) {
          closeMenu();
        }
      }, 100);
    });
  }

  function toggleMenu() {
    if (menuOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  }

  function openMenu() {
    const menuEl = document.getElementById('devq-mobile-menu');
    const toggle = document.getElementById('devq-menu-toggle');
    const backdrop = document.getElementById('devq-menu-backdrop');

    if (!menuEl) return;

    menuOpen = true;
    menuEl.classList.add('is-active');
    if (toggle) toggle.classList.add('is-active');
    if (backdrop) backdrop.classList.add('is-active');
    document.body.classList.add('devq-menu-open');
    document.body.style.overflow = 'hidden';

    // Set ARIA
    menuEl.setAttribute('aria-hidden', 'false');
    if (toggle) toggle.setAttribute('aria-expanded', 'true');

    // Stagger link animations
    staggerLinks(menuEl);

    // Focus trap
    setupFocusTrap(menuEl);
  }

  function closeMenu() {
    const menuEl = document.getElementById('devq-mobile-menu');
    const toggle = document.getElementById('devq-menu-toggle');
    const backdrop = document.getElementById('devq-menu-backdrop');

    if (!menuEl) return;

    menuOpen = false;
    menuEl.classList.remove('is-active');
    if (toggle) toggle.classList.remove('is-active');
    if (backdrop) backdrop.classList.remove('is-active');
    document.body.classList.remove('devq-menu-open');
    document.body.style.overflow = '';

    // Set ARIA
    menuEl.setAttribute('aria-hidden', 'true');
    if (toggle) toggle.setAttribute('aria-expanded', 'false');

    // Reset link animations
    resetLinks(menuEl);

    // Remove focus trap
    if (focusTrap) {
      document.removeEventListener('keydown', focusTrap);
      focusTrap = null;
    }

    // Return focus to toggle
    if (toggle) toggle.focus();
  }

  function staggerLinks(menuEl) {
    const items = menuEl.querySelectorAll('.devq-mobile-nav > li');
    items.forEach(function(item, i) {
      item.style.transitionDelay = (i * 0.05) + 's';
      item.classList.add('is-visible');
    });
  }

  function resetLinks(menuEl) {
    const items = menuEl.querySelectorAll('.devq-mobile-nav > li');
    items.forEach(function(item) {
      item.style.transitionDelay = '0s';
      item.classList.remove('is-visible');
    });
  }

  function initSubMenus() {
    const subToggles = document.querySelectorAll('.devq-submenu-toggle');
    subToggles.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const parent = this.closest('.menu-item-has-children');
        if (!parent) return;

        const submenu = parent.querySelector('.sub-menu');
        if (!submenu) return;

        const isOpen = parent.classList.contains('submenu-open');

        // Close siblings
        const siblings = parent.parentElement.querySelectorAll('.submenu-open');
        siblings.forEach(function(sib) {
          sib.classList.remove('submenu-open');
          const sibMenu = sib.querySelector('.sub-menu');
          if (sibMenu) sibMenu.style.maxHeight = null;
        });

        if (!isOpen) {
          parent.classList.add('submenu-open');
          submenu.style.maxHeight = submenu.scrollHeight + 'px';
        }
      });
    });
  }

  function setupFocusTrap(menuEl) {
    focusTrap = function(e) {
      if (e.key !== 'Tab') return;

      const focusable = menuEl.querySelectorAll(
        'a[href], button, [tabindex]:not([tabindex="-1"])'
      );
      const first = focusable[0];
      const last = focusable[focusable.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    };
    document.addEventListener('keydown', focusTrap);

    // Focus first link
    const firstLink = menuEl.querySelector('a[href]');
    if (firstLink) {
      setTimeout(function() { firstLink.focus(); }, 100);
    }
  }

  // Init on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
