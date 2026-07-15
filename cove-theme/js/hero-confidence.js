(function () {
  'use strict';

  var hero = document.querySelector('[data-confidence-hero]');
  if (!hero) {
    return;
  }

  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var stage = hero.querySelector('[data-confidence-stage]');
  var lens = hero.querySelector('[data-lens]');
  var note = hero.querySelector('[data-confidence-note]');
  var gradeOptions = Array.prototype.slice.call(hero.querySelectorAll('[data-grade-option]'));
  var hotspots = Array.prototype.slice.call(hero.querySelectorAll('[data-hotspot]'));
  var retailPrice = hero.querySelector('[data-retail-price]');
  var covePrice = hero.querySelector('[data-cove-price]');
  var savingNote = hero.querySelector('[data-saving-note]');
  var rafId = 0;
  var targetX = 58;
  var targetY = 42;
  var currentX = targetX;
  var currentY = targetY;

  function setNotePosition(event, hotspot) {
    if (!stage || !note) {
      return;
    }

    var stageRect = stage.getBoundingClientRect();
    var sourceRect = hotspot ? hotspot.getBoundingClientRect() : null;
    var clientX = event && event.clientX ? event.clientX : sourceRect ? sourceRect.left + (sourceRect.width / 2) : stageRect.left + (stageRect.width * 0.58);
    var clientY = event && event.clientY ? event.clientY : sourceRect ? sourceRect.top + (sourceRect.height / 2) : stageRect.top + (stageRect.height * 0.42);
    var x = ((clientX - stageRect.left) / stageRect.width) * 100;
    var y = ((clientY - stageRect.top) / stageRect.height) * 100;
    var clampedX = Math.max(18, Math.min(82, x));
    var clampedY = Math.max(18, Math.min(76, y));
    var shiftX = clampedX > 66 ? '-100%' : clampedX < 34 ? '0%' : '-50%';

    note.style.setProperty('--note-x', clampedX.toFixed(2) + '%');
    note.style.setProperty('--note-y', clampedY.toFixed(2) + '%');
    note.style.setProperty('--note-shift-x', shiftX);
  }

  function setLensPosition(x, y) {
    targetX = Math.max(12, Math.min(88, x));
    targetY = Math.max(12, Math.min(82, y));

    if (!rafId) {
      rafId = window.requestAnimationFrame(updateLens);
    }
  }

  function updateLens() {
    rafId = 0;
    currentX += (targetX - currentX) * 0.18;
    currentY += (targetY - currentY) * 0.18;
    stage.style.setProperty('--lens-x', currentX.toFixed(2) + '%');
    stage.style.setProperty('--lens-y', currentY.toFixed(2) + '%');

    if (Math.abs(targetX - currentX) > 0.08 || Math.abs(targetY - currentY) > 0.08) {
      rafId = window.requestAnimationFrame(updateLens);
    }
  }

  function handlePointer(event) {
    if (reducedMotion || !stage) {
      return;
    }

    var rect = stage.getBoundingClientRect();
    var x = ((event.clientX - rect.left) / rect.width) * 100;
    var y = ((event.clientY - rect.top) / rect.height) * 100;
    setLensPosition(x, y);
  }

  function activateHotspot(hotspot, event) {
    hotspots.forEach(function (item) {
      item.classList.toggle('is-active', item === hotspot);
    });

    if (!note) {
      return;
    }

    var title = hotspot.getAttribute('data-note') || '';
    var impact = hotspot.getAttribute('data-impact') || '';
    note.classList.remove('is-changing');
    void note.offsetWidth;
    note.classList.add('is-changing');
    note.querySelector('strong').textContent = title;
    note.querySelector('span').textContent = impact;
    setNotePosition(event, hotspot);
  }

  function activateGrade(button) {
    gradeOptions.forEach(function (item) {
      var active = item === button;
      item.classList.toggle('is-active', active);
      item.setAttribute('aria-pressed', active ? 'true' : 'false');
    });

    var retail = button.getAttribute('data-retail') || '';
    var price = button.getAttribute('data-price') || '';
    var saving = button.getAttribute('data-saving') || '';

    [retailPrice, covePrice, savingNote].forEach(function (item) {
      if (item) {
        item.classList.remove('is-changing');
        void item.offsetWidth;
        item.classList.add('is-changing');
      }
    });

    if (retailPrice) {
      retailPrice.textContent = retail;
    }
    if (covePrice) {
      covePrice.textContent = price;
    }
    if (savingNote) {
      savingNote.textContent = saving;
    }
  }

  if (stage && lens) {
    stage.style.setProperty('--lens-x', currentX + '%');
    stage.style.setProperty('--lens-y', currentY + '%');
    stage.addEventListener('pointermove', handlePointer, { passive: true });
    stage.addEventListener('pointerenter', function () {
      stage.classList.add('is-exploring');
    });
    stage.addEventListener('pointerleave', function () {
      stage.classList.remove('is-exploring');
      setLensPosition(58, 42);
    });
  }

  hotspots.forEach(function (hotspot) {
    hotspot.addEventListener('mouseenter', function (event) {
      activateHotspot(hotspot, event);
    });
    hotspot.addEventListener('pointermove', function (event) {
      if (hotspot.classList.contains('is-active')) {
        setNotePosition(event, hotspot);
      }
    });
    hotspot.addEventListener('focus', function () {
      activateHotspot(hotspot);
    });
    hotspot.addEventListener('click', function (event) {
      activateHotspot(hotspot, event);
    });
  });

  gradeOptions.forEach(function (button) {
    button.addEventListener('click', function () {
      activateGrade(button);
    });
  });
})();
