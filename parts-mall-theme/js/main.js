/* Parts-Mall theme interactions: sticky header, mobile menu, filter drawer, enquiry modal and toast. */
(function () {
  'use strict';

  var data = window.partsmallData || {};
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var FOCUSABLE = 'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])';

  function $(selector, context) { return (context || document).querySelector(selector); }
  function $all(selector, context) { return Array.prototype.slice.call((context || document).querySelectorAll(selector)); }

  var lockCount = 0;
  function lockScroll() {
    lockCount += 1;
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
  }
  function unlockScroll() {
    lockCount = Math.max(0, lockCount - 1);
    if (lockCount === 0) {
      document.documentElement.style.overflow = '';
      document.body.style.overflow = '';
    }
  }

  function trapFocus(container, event) {
    var nodes = $all(FOCUSABLE, container).filter(function (node) {
      return node.offsetParent !== null || node === document.activeElement;
    });
    if (!nodes.length) return;
    var first = nodes[0];
    var last = nodes[nodes.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  }

  function ensureToastRegion() {
    var region = $('.toast-region');
    if (!region) {
      region = document.createElement('div');
      region.className = 'toast-region';
      region.setAttribute('aria-live', 'polite');
      region.setAttribute('aria-atomic', 'true');
      document.body.appendChild(region);
    }
    return region;
  }

  function toast(message) {
    var region = ensureToastRegion();
    var item = document.createElement('div');
    item.className = 'toast';
    item.setAttribute('role', 'status');
    item.innerHTML = '<span>' + String(message || '') + '</span><button type="button" class="toast__close" aria-label="Dismiss">&times;</button>';
    region.appendChild(item);
    window.requestAnimationFrame(function () { item.classList.add('is-visible'); });
    var dismiss = function () {
      item.classList.remove('is-visible');
      window.setTimeout(function () {
        if (item.parentNode) item.parentNode.removeChild(item);
      }, reduceMotion ? 0 : 220);
    };
    $('.toast__close', item).addEventListener('click', dismiss);
    window.setTimeout(dismiss, 4200);
  }
  window.partsmallToast = toast;

  function initHeader() {
    var header = $('[data-site-header]');
    if (!header) return;
    var ticking = false;
    function update() {
      header.classList.toggle('is-scrolled', window.scrollY > 10);
      ticking = false;
    }
    window.addEventListener('scroll', function () {
      if (!ticking) {
        ticking = true;
        window.requestAnimationFrame(update);
      }
    }, { passive: true });
    update();
  }

  function initSearchPanel() {
    var toggle = $('[data-search-toggle]');
    var panel = $('[data-search-panel]');
    if (!toggle || !panel) return;

    function close() {
      panel.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      document.removeEventListener('keydown', onKey);
      document.removeEventListener('click', onOutside, true);
    }
    function open() {
      panel.classList.add('is-open');
      toggle.setAttribute('aria-expanded', 'true');
      var input = $('[data-search-input]', panel);
      if (input) input.focus();
      document.addEventListener('keydown', onKey);
      document.addEventListener('click', onOutside, true);
    }
    function onKey(event) {
      if (event.key === 'Escape') {
        close();
        toggle.focus();
      }
    }
    function onOutside(event) {
      if (!panel.contains(event.target) && !toggle.contains(event.target)) close();
    }
    toggle.addEventListener('click', function () {
      if (panel.classList.contains('is-open')) close(); else open();
    });
  }

  function initMobileMenu() {
    var toggle = $('[data-nav-toggle]');
    var menu = $('[data-mobile-menu]');
    if (!toggle || !menu) return;

    function close() {
      if (!menu.classList.contains('is-open')) return;
      menu.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      unlockScroll();
      document.removeEventListener('keydown', onKey);
      toggle.focus();
    }
    function open() {
      menu.classList.add('is-open');
      toggle.setAttribute('aria-expanded', 'true');
      lockScroll();
      document.addEventListener('keydown', onKey);
      var first = $(FOCUSABLE, menu);
      if (first) first.focus();
    }
    function onKey(event) {
      if (event.key === 'Escape') close();
      else if (event.key === 'Tab') trapFocus(menu, event);
    }

    toggle.addEventListener('click', function () {
      if (menu.classList.contains('is-open')) close(); else open();
    });
    $all('[data-nav-close]', menu).forEach(function (button) {
      button.addEventListener('click', close);
    });
  }

  function initReveals() {
    var items = $all('[data-reveal]');
    if (!items.length) return;
    if (reduceMotion || !('IntersectionObserver' in window)) {
      items.forEach(function (item) { item.classList.add('is-visible'); });
      return;
    }
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -10% 0px' });
    items.forEach(function (item) { observer.observe(item); });
  }

  function initFilterDrawer() {
    var drawer = $('[data-filter-drawer]');
    var scrim = $('[data-filter-scrim]');
    var openers = $all('[data-filter-open]');
    if (!drawer || !scrim || !openers.length) return;

    function close() {
      drawer.classList.remove('is-open');
      scrim.classList.remove('is-open');
      unlockScroll();
      document.removeEventListener('keydown', onKey);
    }
    function open() {
      drawer.classList.add('is-open');
      scrim.classList.add('is-open');
      lockScroll();
      document.addEventListener('keydown', onKey);
      var focusable = $(FOCUSABLE, drawer);
      if (focusable) focusable.focus();
    }
    function onKey(event) {
      if (event.key === 'Escape') close();
      else if (event.key === 'Tab') trapFocus(drawer, event);
    }

    openers.forEach(function (button) {
      button.addEventListener('click', open);
    });
    $all('[data-filter-close]').forEach(function (button) {
      button.addEventListener('click', close);
    });
    scrim.addEventListener('click', close);
  }

  function initBranchFinder() {
    $all('[data-branch-finder]').forEach(function (scope) {
      var root = scope.closest('.locator-preview__layout, .editorial, .page-shell, .section, .container') || scope.parentNode || scope;
      var input = $('[data-branch-finder-input]', scope);
      var cards = $all('[data-branch-card]', root);
      var groups = $all('[data-branch-group]', root);
      var resultNode = $('[data-branch-results]', root);
      var emptyState = $('[data-branch-empty]', root);
      var featured = $('[data-branch-featured]', root);
      if (!input || !cards.length) return;

      function updateFeatured(card) {
        if (!featured || !card) return;
        var name = $('[data-branch-featured-name]', featured);
        var address = $('[data-branch-featured-address]', featured);
        var link = $('[data-branch-featured-link]', featured);
        var call = $('[data-branch-featured-call]', featured);
        var directions = $('[data-branch-featured-directions]', featured);
        if (name) name.textContent = card.getAttribute('data-branch-name') || '';
        if (address) address.textContent = card.getAttribute('data-branch-address') || '';
        if (link) link.setAttribute('href', card.getAttribute('data-branch-url') || '#');
        if (call) call.setAttribute('href', 'tel:' + (card.getAttribute('data-branch-phone') || ''));
        if (directions) directions.setAttribute('href', card.getAttribute('data-branch-directions') || '#');
      }

      function render() {
        var term = input.value.trim().toLowerCase();
        var visibleCount = 0;
        var firstMatch = null;
        cards.forEach(function (card) {
          var haystack = String(card.getAttribute('data-branch-search') || '').toLowerCase();
          var match = !term || haystack.indexOf(term) !== -1;
          card.style.display = match ? '' : 'none';
          if (match) {
            visibleCount += 1;
            if (!firstMatch) firstMatch = card;
          }
        });
        groups.forEach(function (group) {
          var visibleInGroup = $all('[data-branch-card]', group).filter(function (card) {
            return card.style.display !== 'none';
          }).length;
          group.style.display = visibleInGroup ? '' : 'none';
          var countNode = $('[data-branch-group-count]', group);
          if (countNode) {
            countNode.textContent = visibleInGroup + ' ' + (group.id === 'pan-africa' ? 'country points' : 'locations');
          }
        });
        if (resultNode) {
          resultNode.textContent = visibleCount ? (visibleCount + ' branch points currently visible') : 'No branch points currently visible';
        }
        if (emptyState) emptyState.hidden = visibleCount !== 0;
        if (featured) featured.hidden = visibleCount === 0;
        if (firstMatch) updateFeatured(firstMatch);
      }

      input.addEventListener('input', render);
      render();
    });
  }

  function initPromoSlider() {
    $all('[data-promo-slider]').forEach(function (slider) {
      var slides = $all('[data-promo-slide]', slider);
      var dots = $all('[data-promo-dot]', slider);
      var prev = $('[data-promo-prev]', slider);
      var next = $('[data-promo-next]', slider);
      var index = 0;
      if (!slides.length) return;

      function render(nextIndex) {
        index = (nextIndex + slides.length) % slides.length;
        slides.forEach(function (slide, slideIndex) {
          slide.classList.toggle('is-active', slideIndex === index);
        });
        dots.forEach(function (dot, dotIndex) {
          dot.classList.toggle('is-active', dotIndex === index);
        });
      }

      if (prev) prev.addEventListener('click', function () { render(index - 1); });
      if (next) next.addEventListener('click', function () { render(index + 1); });
      dots.forEach(function (dot, dotIndex) {
        dot.addEventListener('click', function () { render(dotIndex); });
      });

      render(0);
    });
  }

  var modal;
  var refocus;

  function buildModal() {
    if (modal) return modal;
    var wrap = document.createElement('div');
    wrap.className = 'enquiry-modal';
    wrap.innerHTML = [
      '<div class="enquiry-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="partsmall-enquiry-title">',
      '<button type="button" class="enquiry-modal__close" aria-label="Close">&times;</button>',
      '<h2 id="partsmall-enquiry-title" class="t-2">Enquire about this part</h2>',
      '<form class="enquiry-modal__form">',
      '<input type="hidden" name="type" value="part">',
      '<input type="hidden" name="product_id" value="">',
      '<input type="hidden" name="product_name" value="">',
      '<label class="label">Name<input type="text" name="name" required></label>',
      '<label class="label">Email<input type="email" name="email"></label>',
      '<label class="label">Contact number<input type="text" name="phone"></label>',
      '<label class="label">Company<input type="text" name="company"></label>',
      '<label class="label">Area / branch preference<input type="text" name="area"></label>',
      '<label class="label">Message<textarea name="message" placeholder="Tell Parts-Mall which application, quantity, branch or OEM reference you need."></textarea></label>',
      '<div class="cluster"><button type="submit" class="btn btn--signal">Send enquiry</button><div class="form-status" data-form-status role="status" aria-live="polite"></div></div>',
      '</form>',
      '</div>'
    ].join('');
    document.body.appendChild(wrap);
    modal = wrap;
    $('.enquiry-modal__close', modal).addEventListener('click', closeModal);
    modal.addEventListener('click', function (event) {
      if (event.target === modal) closeModal();
    });
    document.addEventListener('keydown', function (event) {
      if (!modal.classList.contains('is-open')) return;
      if (event.key === 'Escape') closeModal();
      else if (event.key === 'Tab') trapFocus($('.enquiry-modal__dialog', modal), event);
    });
    bindAjaxForm($('.enquiry-modal__form', modal));
    return modal;
  }

  function openModal(trigger) {
    var node = buildModal();
    refocus = trigger || null;
    $('[name="type"]', node).value = trigger && trigger.getAttribute('data-enquiry-type') ? trigger.getAttribute('data-enquiry-type') : 'part';
    $('[name="product_id"]', node).value = trigger && trigger.getAttribute('data-product-id') ? trigger.getAttribute('data-product-id') : '';
    $('[name="product_name"]', node).value = trigger && trigger.getAttribute('data-product-name') ? trigger.getAttribute('data-product-name') : '';
    $('#partsmall-enquiry-title', node).textContent = $('[name="type"]', node).value === 'bulk' ? 'Ask about bulk / trade pricing' : 'Enquire about this part';
    node.classList.add('is-open');
    lockScroll();
    var first = $('[name="name"]', node);
    if (first) first.focus();
  }

  function closeModal() {
    if (!modal) return;
    modal.classList.remove('is-open');
    unlockScroll();
    if (refocus) refocus.focus();
  }

  function serializeForm(form) {
    var payload = new FormData(form);
    payload.append('action', 'partsmall_enquiry');
    payload.append('nonce', data.nonce || '');
    return payload;
  }

  function bindAjaxForm(form) {
    if (!form) return;
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      var status = $('[data-form-status]', form);
      if (status) status.textContent = 'Sending…';
      fetch(data.ajaxUrl || '', {
        method: 'POST',
        credentials: 'same-origin',
        body: serializeForm(form)
      }).then(function (response) {
        return response.json();
      }).then(function (result) {
        if (status) status.textContent = result && result.message ? result.message : '';
        toast(result && result.message ? result.message : 'Enquiry sent.');
        if (result && result.ok) {
          form.reset();
          var typeField = $('[name="type"]', form);
          if (typeField && typeField.defaultValue) typeField.value = typeField.defaultValue;
          window.setTimeout(function () {
            if (form.closest('.enquiry-modal')) closeModal();
          }, 300);
        }
      }).catch(function () {
        if (status) status.textContent = 'Something went wrong. Please try again.';
        toast('Something went wrong. Please try again.');
      });
    });
  }

  function initEnquiries() {
    $all('[data-enquiry-trigger]').forEach(function (button) {
      button.addEventListener('click', function () {
        openModal(button);
      });
    });
    $all('[data-enquiry-form]').forEach(function (form) {
      bindAjaxForm(form);
    });
  }

  initHeader();
  initSearchPanel();
  initMobileMenu();
  initReveals();
  initFilterDrawer();
  initBranchFinder();
  initPromoSlider();
  initEnquiries();
})();
