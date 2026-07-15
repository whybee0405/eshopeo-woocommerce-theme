(function () {
  'use strict';

  var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
  var coarsePointer = window.matchMedia('(pointer: coarse)');
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  if (!finePointer.matches || coarsePointer.matches || reducedMotion.matches) {
    return;
  }

  var interactiveSelector = 'a, button, .btn, [role="button"], summary, label, select, input[type="checkbox"], input[type="radio"], .category-tile, .product-card, .pdp-thumb, .header-icon-btn';
  var textSelector = 'input:not([type="checkbox"]):not([type="radio"]):not([type="range"]), textarea, [contenteditable="true"]';
  var disabledSelector = ':disabled, [disabled], [aria-disabled="true"], .is-disabled';
  var dragSelector = '[draggable="true"], input[type="range"], .range-thumb';
  var inspectSelector = '[data-confidence-stage], [data-confidence-stage] *';

  var cursor = document.createElement('div');
  cursor.className = 'cove-cursor';
  cursor.setAttribute('aria-hidden', 'true');
  cursor.innerHTML = '<span class="cove-cursor__trail"></span><span class="cove-cursor__core"></span>';
  document.body.appendChild(cursor);
  document.documentElement.classList.add('cove-custom-cursor');

  var core = cursor.querySelector('.cove-cursor__core');
  var trail = cursor.querySelector('.cove-cursor__trail');
  var targetX = window.innerWidth / 2;
  var targetY = window.innerHeight / 2;
  var coreX = targetX;
  var coreY = targetY;
  var trailX = targetX;
  var trailY = targetY;
  var visible = false;
  var pressed = false;

  function closest(target, selector) {
    return target && target.closest && target.closest(selector);
  }

  function setState(event) {
    var target = event.target;
    var state = 'default';

    cursor.classList.remove('is-inspect');

    if (closest(target, inspectSelector)) {
      state = 'inspect';
      cursor.classList.add('is-inspect');
    } else if (closest(target, disabledSelector)) {
      state = 'disabled';
    } else if (pressed || closest(target, dragSelector)) {
      state = pressed ? 'grabbing' : 'grab';
    } else if (closest(target, textSelector)) {
      state = 'text';
    } else if (closest(target, interactiveSelector)) {
      state = 'pointer';
    }

    cursor.dataset.cursorState = state;
    document.documentElement.setAttribute('data-cursor-state', state);
  }

  function move(event) {
    targetX = event.clientX;
    targetY = event.clientY;
    visible = true;
    cursor.classList.add('is-visible');
    setState(event);
  }

  function animate() {
    coreX += (targetX - coreX) * 0.34;
    coreY += (targetY - coreY) * 0.34;
    trailX += (targetX - trailX) * 0.14;
    trailY += (targetY - trailY) * 0.14;

    core.style.transform = 'translate3d(' + coreX + 'px,' + coreY + 'px,0) translate3d(-50%,-50%,0)';
    trail.style.transform = 'translate3d(' + trailX + 'px,' + trailY + 'px,0) translate3d(-50%,-50%,0)';

    requestAnimationFrame(animate);
  }

  document.addEventListener('pointermove', move, { passive: true });
  document.addEventListener('pointerdown', function (event) {
    pressed = true;
    cursor.classList.add('is-pressed');
    setState(event);
  }, { passive: true });
  document.addEventListener('pointerup', function (event) {
    pressed = false;
    cursor.classList.remove('is-pressed');
    setState(event);
  }, { passive: true });
  document.addEventListener('pointerleave', function () {
    visible = false;
    cursor.classList.remove('is-visible');
  });
  document.addEventListener('pointerover', setState, { passive: true });

  if (!visible) {
    cursor.classList.remove('is-visible');
  }

  requestAnimationFrame(animate);
}());
