/* Parts-Mall live catalogue search for header and hero forms. */
(function () {
  'use strict';

  var data = window.partsmallData || {};

  function $(selector, context) { return (context || document).querySelector(selector); }
  function $all(selector, context) { return Array.prototype.slice.call((context || document).querySelectorAll(selector)); }

  function debounce(fn, wait) {
    var timeout;
    return function () {
      var args = arguments;
      window.clearTimeout(timeout);
      timeout = window.setTimeout(function () { fn.apply(null, args); }, wait);
    };
  }

  function createPayload(term) {
    var payload = new FormData();
    payload.append('action', 'partsmall_catalogue_search');
    payload.append('nonce', data.nonce || '');
    payload.append('term', term);
    return payload;
  }

  function bindSearch(form) {
    var input = $('[data-search-input]', form);
    var results = $('[data-search-results]', form);
    if (!input || !results) return;

    function clear() {
      results.classList.remove('is-active');
      results.innerHTML = '';
    }

    function render(term) {
      if (!term || term.length < 2) {
        clear();
        return;
      }
      fetch(data.ajaxUrl || '', {
        method: 'POST',
        credentials: 'same-origin',
        body: createPayload(term)
      }).then(function (response) {
        return response.json();
      }).then(function (payload) {
        if (!payload || !payload.cards_html) {
          clear();
          return;
        }
        results.innerHTML = '<p class="catalogue-search__status">' + String(payload.count || 0) + ' result(s)</p>' + payload.cards_html;
        results.classList.add('is-active');
      }).catch(clear);
    }

    var debounced = debounce(function () {
      render(input.value.trim());
    }, 180);

    input.addEventListener('input', debounced);
    input.addEventListener('focus', function () {
      if (input.value.trim().length >= 2) render(input.value.trim());
    });
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      render(input.value.trim());
    });
    document.addEventListener('click', function (event) {
      if (!form.contains(event.target)) clear();
    });
  }

  $all('[data-catalogue-search]').forEach(bindSearch);
})();
