(function () {
  'use strict';

  function initSlider(root) {
    var slides = Array.prototype.slice.call(root.querySelectorAll('[data-chs-slide]'));
    var dots = Array.prototype.slice.call(root.querySelectorAll('[data-chs-dot]'));
    var prev = root.querySelector('[data-chs-prev]');
    var next = root.querySelector('[data-chs-next]');
    var progress = root.querySelector('[data-chs-progress]');
    var autoplay = root.getAttribute('data-autoplay') === 'true';
    var delay = parseInt(root.getAttribute('data-delay') || '5000', 10);
    var breakpoints = {
      wide: parseInt(root.getAttribute('data-breakpoint-wide') || '1240', 10),
      desktop: parseInt(root.getAttribute('data-breakpoint-desktop') || '960', 10),
      notebook: parseInt(root.getAttribute('data-breakpoint-notebook') || '778', 10),
      tablet: parseInt(root.getAttribute('data-breakpoint-tablet') || '640', 10)
    };
    var index = 0;
    var timer = null;
    var progressTimer = null;
    var progressStart = 0;
    var touchStartX = 0;
    var touchDeltaX = 0;

    function resolveDevice() {
      var width = window.innerWidth || document.documentElement.clientWidth || 0;
      if (width >= breakpoints.wide) return 'wide';
      if (width >= breakpoints.desktop) return 'desktop';
      if (width >= breakpoints.notebook) return 'notebook';
      if (width >= breakpoints.tablet) return 'tablet';
      return 'mobile';
    }

    function applyResponsiveState() {
      root.setAttribute('data-chs-device', resolveDevice());
    }

    applyResponsiveState();

    if (slides.length <= 1) {
      window.addEventListener('resize', applyResponsiveState, { passive: true });
      window.addEventListener('orientationchange', applyResponsiveState);
      return;
    }

    function render(nextIndex) {
      index = (nextIndex + slides.length) % slides.length;
      slides.forEach(function (slide, slideIndex) {
        slide.classList.toggle('is-active', slideIndex === index);
      });
      dots.forEach(function (dot, dotIndex) {
        dot.classList.toggle('is-active', dotIndex === index);
      });
    }

    function stop() {
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
      if (progressTimer) {
        window.cancelAnimationFrame(progressTimer);
        progressTimer = null;
      }
    }

    function resetProgress() {
      if (progress) {
        progress.style.setProperty('--chs-progress-scale', '0');
      }
    }

    function animateProgress() {
      if (!progress || !autoplay) {
        return;
      }

      if (!progressStart) {
        progressStart = window.performance.now();
      }

      var elapsed = window.performance.now() - progressStart;
      var ratio = Math.max(0, Math.min(1, elapsed / Math.max(2000, delay)));
      progress.style.setProperty('--chs-progress-scale', String(ratio));

      if (ratio < 1 && timer) {
        progressTimer = window.requestAnimationFrame(animateProgress);
      }
    }

    function start() {
      if (!autoplay || document.hidden) return;
      stop();
      progressStart = window.performance.now();
      resetProgress();
      timer = window.setInterval(function () {
        render(index + 1);
        progressStart = window.performance.now();
        resetProgress();
      }, Math.max(2000, delay));
      progressTimer = window.requestAnimationFrame(animateProgress);
    }

    if (prev) prev.addEventListener('click', function () { render(index - 1); start(); });
    if (next) next.addEventListener('click', function () { render(index + 1); start(); });
    dots.forEach(function (dot, dotIndex) {
      dot.addEventListener('click', function () { render(dotIndex); start(); });
    });

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    root.addEventListener('focusin', stop);
    root.addEventListener('focusout', start);

    root.addEventListener('touchstart', function (event) {
      if (!event.touches || !event.touches.length) return;
      touchStartX = event.touches[0].clientX;
      touchDeltaX = 0;
      stop();
    }, { passive: true });

    root.addEventListener('touchmove', function (event) {
      if (!event.touches || !event.touches.length) return;
      touchDeltaX = event.touches[0].clientX - touchStartX;
    }, { passive: true });

    root.addEventListener('touchend', function () {
      if (Math.abs(touchDeltaX) > 44) {
        render(touchDeltaX < 0 ? index + 1 : index - 1);
      }
      start();
    });

    window.addEventListener('resize', applyResponsiveState, { passive: true });
    window.addEventListener('orientationchange', applyResponsiveState);
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) {
        stop();
      } else {
        start();
      }
    });

    render(0);
    resetProgress();
    start();
  }

  document.addEventListener('DOMContentLoaded', function () {
    Array.prototype.slice.call(document.querySelectorAll('[data-chs-slider]')).forEach(initSlider);
  });
})();
