(function () {
  'use strict';

  var doc = document;
  var body = doc.body;

  function qs(selector, root) {
    return (root || doc).querySelector(selector);
  }

  function qsa(selector, root) {
    return Array.prototype.slice.call((root || doc).querySelectorAll(selector));
  }

  function initHeader() {
    var header = qs('[data-header]');
    if (!header) {
      return;
    }
    var onScroll = function () {
      header.classList.toggle('is-scrolled', window.scrollY > 8);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  function initMenu() {
    var toggle = qs('[data-menu-toggle]');
    var menu = qs('[data-mobile-menu]');
    var close = qs('[data-menu-close]');
    if (!toggle || !menu) {
      return;
    }

    function openMenu() {
      menu.classList.add('is-open');
      menu.setAttribute('aria-hidden', 'false');
      toggle.setAttribute('aria-expanded', 'true');
      body.classList.add('menu-open');
    }

    function closeMenu() {
      menu.classList.remove('is-open');
      menu.setAttribute('aria-hidden', 'true');
      toggle.setAttribute('aria-expanded', 'false');
      body.classList.remove('menu-open');
      toggle.focus();
    }

    toggle.addEventListener('click', openMenu);
    if (close) {
      close.addEventListener('click', closeMenu);
    }
    qsa('a', menu).forEach(function (link) {
      link.addEventListener('click', function () {
        menu.classList.remove('is-open');
        menu.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
        body.classList.remove('menu-open');
      });
    });
    doc.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && menu.classList.contains('is-open')) {
        closeMenu();
      }
    });
  }

  function initReveal() {
    var items = qsa('.reveal');
    if (!items.length) {
      return;
    }
    if (!('IntersectionObserver' in window)) {
      items.forEach(function (item) {
        item.classList.add('is-visible');
      });
      return;
    }
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });
    items.forEach(function (item, index) {
      item.style.transitionDelay = Math.min(index % 4, 3) * 45 + 'ms';
      observer.observe(item);
    });
  }

  function initMenuNav() {
    var nav = qs('[data-menu-nav]');
    if (!nav || !('IntersectionObserver' in window)) {
      return;
    }
    var links = qsa('a', nav);
    var map = {};
    links.forEach(function (link) {
      map[link.getAttribute('href')] = link;
    });
    var sections = links.map(function (link) {
      return qs(link.getAttribute('href'));
    }).filter(Boolean);
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) {
          return;
        }
        links.forEach(function (link) {
          link.classList.remove('is-active');
        });
        var active = map['#' + entry.target.id];
        if (active) {
          active.classList.add('is-active');
        }
      });
    }, { rootMargin: '-30% 0px -55% 0px', threshold: 0 });
    sections.forEach(function (section) {
      observer.observe(section);
    });
  }

  function initForms() {
    qsa('[data-kbap-form]').forEach(function (form) {
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        var note = qs('[data-form-note]', form);
        var submit = qs('button[type="submit"]', form);
        var data = window.kbapData || {};
        var params = new URLSearchParams(new FormData(form));
        params.set('action', 'kbap_enquiry');
        params.set('nonce', data.nonce || '');

        if (note) {
          note.textContent = 'Sending...';
        }
        if (submit) {
          submit.disabled = true;
        }

        fetch(data.ajaxUrl || '/wp-admin/admin-ajax.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
          body: params.toString()
        }).then(function (response) {
          return response.json();
        }).then(function (payload) {
          if (payload && payload.success) {
            form.reset();
            if (note) {
              note.textContent = payload.data.message || 'Thanks. We will reply shortly.';
            }
          } else {
            throw new Error(payload && payload.data && payload.data.message ? payload.data.message : 'Please check the form and try again.');
          }
        }).catch(function (error) {
          if (note) {
            note.textContent = error.message;
          }
        }).finally(function () {
          if (submit) {
            submit.disabled = false;
          }
        });
      });
    });
  }

  doc.addEventListener('DOMContentLoaded', function () {
    initHeader();
    initMenu();
    initReveal();
    initMenuNav();
    initForms();
  });
}());
