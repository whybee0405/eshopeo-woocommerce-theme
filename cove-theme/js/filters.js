/**
 * COVE catalogue — filter sidebar interactions.
 * Mobile drawer toggle, price range dual slider, active chip dismissal.
 */
(function () {
  'use strict';

  function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

  /* ------------------------------------------------------------------
   * Mobile sidebar drawer
   * ------------------------------------------------------------------ */
  var sidebar     = qs('.filter-sidebar');
  var toggleBtn   = qs('.filter-toggle-btn');
  var overlay     = null;

  function createOverlay() {
    if (overlay) { return overlay; }
    overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;z-index:149;background:rgba(37,40,48,0.45);';
    overlay.addEventListener('click', closeDrawer);
    document.body.appendChild(overlay);
    return overlay;
  }

  function openDrawer() {
    if (!sidebar) { return; }
    sidebar.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    createOverlay();
  }

  function closeDrawer() {
    if (!sidebar) { return; }
    sidebar.classList.remove('is-open');
    document.body.style.overflow = '';
    if (overlay) { overlay.remove(); overlay = null; }
  }

  if (toggleBtn) { toggleBtn.addEventListener('click', openDrawer); }
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeDrawer(); } });

  /* ------------------------------------------------------------------
   * Price range dual slider
   * ------------------------------------------------------------------ */
  var rangeWrap = qs('.range-wrap[data-price-range]');
  if (rangeWrap) {
    var thumbMin  = qs('.range-thumb[data-min]', rangeWrap);
    var thumbMax  = qs('.range-thumb[data-max]', rangeWrap);
    var fill      = qs('.range-fill', rangeWrap);
    var labelMin  = qs('[data-label-min]', rangeWrap);
    var labelMax  = qs('[data-label-max]', rangeWrap);
    var inputMin  = qs('input[name="price_min"]');
    var inputMax  = qs('input[name="price_max"]');

    function updateRange() {
      if (!thumbMin || !thumbMax) { return; }
      var min = parseInt(thumbMin.min, 10);
      var max = parseInt(thumbMin.max, 10);
      var vMin = parseInt(thumbMin.value, 10);
      var vMax = parseInt(thumbMax.value, 10);

      if (vMin > vMax - 500) { thumbMin.value = vMax - 500; vMin = vMax - 500; }

      var pMin = ((vMin - min) / (max - min)) * 100;
      var pMax = ((vMax - min) / (max - min)) * 100;

      if (fill) {
        fill.style.left  = pMin + '%';
        fill.style.right = (100 - pMax) + '%';
      }
      if (labelMin) { labelMin.textContent = 'R' + vMin.toLocaleString(); }
      if (labelMax) { labelMax.textContent = 'R' + vMax.toLocaleString(); }
      if (inputMin) { inputMin.value = vMin; }
      if (inputMax) { inputMax.value = vMax; }
    }

    if (thumbMin) { thumbMin.addEventListener('input', updateRange); }
    if (thumbMax) { thumbMax.addEventListener('input', updateRange); }
    updateRange();
  }

  /* ------------------------------------------------------------------
   * Active filter chips — clicking × removes filter from URL
   * ------------------------------------------------------------------ */
  qsa('.active-chip__remove').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var param = btn.closest('.active-chip') && btn.closest('.active-chip').dataset.param;
      if (!param) { return; }
      var url = new URL(window.location.href);
      url.searchParams.delete(param);
      window.location.href = url.toString();
    });
  });

  /* ------------------------------------------------------------------
   * Sort select — redirect on change
   * ------------------------------------------------------------------ */
  var sortSelect = qs('.catalogue-sort .select[name="orderby"]');
  if (sortSelect) {
    sortSelect.addEventListener('change', function () {
      var url = new URL(window.location.href);
      url.searchParams.set('orderby', sortSelect.value);
      window.location.href = url.toString();
    });
  }

  /* ------------------------------------------------------------------
   * Auto-submit filter form on checkbox change
   * ------------------------------------------------------------------ */
  var filterForm = qs('[data-filter-form]');
  if (filterForm) {
    qsa('input[type="checkbox"]', filterForm).forEach(function (cb) {
      cb.addEventListener('change', function () {
        filterForm.submit();
      });
    });
  }

})();
