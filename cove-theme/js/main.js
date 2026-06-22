/**
 * COVE — main interaction layer.
 * Mobile menu, header scroll shadow, notice bar ticker,
 * cart count sync, toast system, scroll reveals.
 */
(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

  /* ------------------------------------------------------------------
   * JS flag (enables CSS reveal transitions)
   * ------------------------------------------------------------------ */
  document.documentElement.classList.add('js');

  /* ------------------------------------------------------------------
   * Header scroll shadow
   * ------------------------------------------------------------------ */
  var header = qs('[data-header]');
  function onScroll() {
    if (header) { header.classList.toggle('is-scrolled', window.scrollY > 8); }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ------------------------------------------------------------------
   * Toast
   * ------------------------------------------------------------------ */
  var toastTimer = null;
  function showToast(message) {
    var el  = qs('[data-toast]');
    var msg = qs('[data-toast-message]');
    if (!el || !msg) { return; }
    msg.textContent = message;
    el.classList.add('is-visible');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { el.classList.remove('is-visible'); }, 3200);
  }
  window.coveToast = showToast;

  /* ------------------------------------------------------------------
   * Mobile menu
   * ------------------------------------------------------------------ */
  var menuToggle = qs('[data-menu-toggle]');
  var menuClose  = qs('[data-menu-close]');
  var mobileMenu = qs('[data-mobile-menu]');

  function openMenu() {
    if (!mobileMenu) { return; }
    mobileMenu.classList.add('is-open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    if (menuToggle) { menuToggle.setAttribute('aria-expanded', 'true'); }
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    if (!mobileMenu) { return; }
    mobileMenu.classList.remove('is-open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    if (menuToggle) { menuToggle.setAttribute('aria-expanded', 'false'); }
    document.body.style.overflow = '';
  }

  if (menuToggle) { menuToggle.addEventListener('click', openMenu); }
  if (menuClose)  { menuClose.addEventListener('click', closeMenu); }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeMenu(); }
  });

  /* ------------------------------------------------------------------
   * Cart count (WooCommerce fragment refresh)
   * ------------------------------------------------------------------ */
  var cartCountEl = qs('[data-cart-count]');

  document.body.addEventListener('wc_fragments_refreshed', function () {
    if (!cartCountEl || typeof wc_cart_fragments_params === 'undefined') { return; }
    try {
      var frags = JSON.parse(sessionStorage.getItem('wc_fragments') || '{}');
      var count = frags['a.cart-contents'] || '';
      var match = String(count).match(/\d+/);
      if (match) {
        cartCountEl.textContent = parseInt(match[0], 10) > 0 ? match[0] : '';
      }
    } catch (e) { /* noop */ }
  });

  document.body.addEventListener('added_to_cart', function (e, fragments, cart_hash, button) {
    if (cartCountEl) {
      var current = parseInt(cartCountEl.textContent, 10) || 0;
      cartCountEl.textContent = current + 1;
    }
    showToast('Added to cart!');
  });

  /* ------------------------------------------------------------------
   * Scroll reveals (IntersectionObserver — GSAP handles the animation,
   * this handles fallback for no-GSAP or low-end devices)
   * ------------------------------------------------------------------ */
  var revealEls = qsa('[data-reveal]');

  if (revealEls.length && 'IntersectionObserver' in window && !REDUCED) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });

    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* ------------------------------------------------------------------
   * PDP sticky buy bar
   * ------------------------------------------------------------------ */
  var stickyBar = qs('.pdp-sticky-bar');
  var atcBar    = qs('.pdp-atc-bar');

  if (stickyBar && atcBar) {
    var atcObs = new IntersectionObserver(function (entries) {
      stickyBar.classList.toggle('is-visible', !entries[0].isIntersecting);
    }, { threshold: 0 });
    atcObs.observe(atcBar);
  }

  /* ------------------------------------------------------------------
   * PDP gallery thumbnail switcher
   * ------------------------------------------------------------------ */
  var pdpMain   = qs('[data-pdp-main]');
  var pdpThumbs = qsa('.pdp-thumb');

  pdpThumbs.forEach(function (thumb) {
    thumb.addEventListener('click', function () {
      pdpThumbs.forEach(function (t) { t.classList.remove('is-active'); });
      thumb.classList.add('is-active');
      if (pdpMain) {
        var img = pdpMain.querySelector('img');
        var fullUrl = thumb.dataset.full;
        if (img && fullUrl) { img.src = fullUrl; }
      }
    });
  });

  /* ------------------------------------------------------------------
   * Qty stepper on PDP
   * ------------------------------------------------------------------ */
  qsa('.qty-stepper').forEach(function (stepper) {
    var input  = stepper.querySelector('input[type="number"]');
    var minus  = stepper.querySelector('[data-minus]');
    var plus   = stepper.querySelector('[data-plus]');
    if (!input) { return; }

    function setQty(val) {
      var min = parseInt(input.min, 10) || 1;
      var max = parseInt(input.max, 10) || 999;
      input.value = Math.max(min, Math.min(max, val));
      input.dispatchEvent(new Event('change', { bubbles: true }));
    }

    if (minus) { minus.addEventListener('click', function () { setQty(parseInt(input.value, 10) - 1); }); }
    if (plus)  { plus.addEventListener('click',  function () { setQty(parseInt(input.value, 10) + 1); }); }
  });

  /* ------------------------------------------------------------------
   * Contact form AJAX
   * ------------------------------------------------------------------ */
  var contactForm = qs('[data-contact-form]');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var fd  = new FormData(contactForm);
      var btn = contactForm.querySelector('[type="submit"]');
      if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

      var data = new URLSearchParams();
      data.append('action', 'cove_contact');
      data.append('nonce', (window.coveData && window.coveData.nonce) || '');
      data.append('name',    fd.get('name')    || '');
      data.append('email',   fd.get('email')   || '');
      data.append('message', fd.get('message') || '');

      fetch((window.coveData && window.coveData.ajaxUrl) || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: data,
        credentials: 'same-origin',
      })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          showToast(res.data ? res.data.message : 'Message sent!');
          if (res.success) { contactForm.reset(); }
        })
        .catch(function () { showToast('Something went wrong. Please try again.'); })
        .finally(function () {
          if (btn) { btn.disabled = false; btn.textContent = 'Send message'; }
        });
    });
  }

})();
