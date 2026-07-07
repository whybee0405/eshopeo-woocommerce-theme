(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Pre-mark all [data-reveal] so the IntersectionObserver in main.js skips them
  // when GSAP is handling the animation.
  document.querySelectorAll('[data-reveal]').forEach(function (el) {
    el.classList.add('is-visible');
  });

  if (REDUCED) { return; }

  function initGSAP() {
    if (typeof window.gsap === 'undefined' || typeof window.ScrollTrigger === 'undefined') {
      return requestAnimationFrame(initGSAP);
    }

    gsap.registerPlugin(ScrollTrigger);

    // General section reveals
    document.querySelectorAll('[data-reveal]').forEach(function (el) {
      gsap.from(el, {
        y: 30,
        opacity: 0,
        duration: 0.6,
        ease: 'power3.out',
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: el, start: 'top 87%', once: true },
      });
    });

    // Large headings — clip-path reveal
    document.querySelectorAll('.t-hero, .t-1').forEach(function (el) {
      gsap.from(el, {
        clipPath: 'inset(0 100% 0 0)',
        duration: 0.75,
        ease: 'power4.out',
        clearProps: 'clipPath',
        scrollTrigger: { trigger: el, start: 'top 90%', once: true },
      });
    });

    // Product cards — staggered
    document.querySelectorAll('.products-grid, .products-grid--3').forEach(function (grid) {
      var cards = grid.querySelectorAll('.product-card, li.product');
      if (!cards.length) { return; }
      gsap.from(cards, {
        y: 22,
        opacity: 0,
        duration: 0.45,
        ease: 'power3.out',
        stagger: 0.06,
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: grid, start: 'top 88%', once: true },
      });
    });

    // Grade strip columns — alternating slide
    var gradeCols = document.querySelectorAll('.grade-strip__col');
    if (gradeCols.length) {
      gsap.from(gradeCols, {
        x: function (i) { return i % 2 === 0 ? -40 : 40; },
        opacity: 0,
        duration: 0.6,
        ease: 'power3.out',
        stagger: 0.12,
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: '.grade-strip', start: 'top 80%', once: true },
      });
    }

    // Trust bar items
    var trustItems = document.querySelectorAll('.trust-item');
    if (trustItems.length) {
      gsap.from(trustItems, {
        y: 20,
        opacity: 0,
        duration: 0.5,
        ease: 'power3.out',
        stagger: 0.1,
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: '.trust-bar', start: 'top 85%', once: true },
      });
    }

    // Category tiles
    var catTiles = document.querySelectorAll('.category-tile');
    if (catTiles.length) {
      gsap.from(catTiles, {
        scale: 0.94,
        opacity: 0,
        duration: 0.4,
        ease: 'power3.out',
        stagger: 0.07,
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: '.category-strip', start: 'top 87%', once: true },
      });
    }

    // Review cards — sequential
    var reviews = document.querySelectorAll('.review-card');
    if (reviews.length) {
      gsap.from(reviews, {
        y: 24,
        opacity: 0,
        duration: 0.5,
        ease: 'power3.out',
        stagger: 0.15,
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: '.reviews-layout', start: 'top 85%', once: true },
      });
    }

    // Post cards
    var postCards = document.querySelectorAll('.post-card');
    if (postCards.length) {
      gsap.from(postCards, {
        y: 20,
        opacity: 0,
        duration: 0.45,
        ease: 'power3.out',
        stagger: 0.1,
        clearProps: 'transform,opacity',
        scrollTrigger: { trigger: '.post-grid', start: 'top 87%', once: true },
      });
    }
  }

  requestAnimationFrame(initGSAP);
})();
