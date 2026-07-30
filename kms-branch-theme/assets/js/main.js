/**
 * KMS Branch
 *
 * Two jobs, both small:
 *   1. Recompute open/closed on the client, because a full-page cache would
 *      otherwise freeze "Open now" at whatever it was when the page was built.
 *   2. Reveal sections on scroll, staggered, and only when motion is welcome.
 */
(function () {
	'use strict';

	var data = window.kmsData || {};

	/* ---------------------------------------------------------------------
	   Open / closed
	   --------------------------------------------------------------------- */

	var DAY_NAMES = [
		'Sunday',
		'Monday',
		'Tuesday',
		'Wednesday',
		'Thursday',
		'Friday',
		'Saturday',
	];

	function toMinutes(hhmm) {
		var parts = String(hhmm).split(':');
		return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
	}

	/**
	 * "Now" in the shop's timezone, not the visitor's. Someone checking from
	 * London must still see Johannesburg trading hours.
	 */
	function shopNow() {
		if (!data.timezone) {
			return new Date();
		}
		try {
			return new Date(
				new Date().toLocaleString('en-US', { timeZone: data.timezone })
			);
		} catch (e) {
			return new Date();
		}
	}

	function computeStatus(hours) {
		var now = shopNow();
		// PHP's date('N'): Monday = 1 ... Sunday = 7.
		var day = now.getDay() === 0 ? 7 : now.getDay();
		var mins = now.getHours() * 60 + now.getMinutes();
		var today = hours[day];

		if (today && today.length === 2) {
			var opens = toMinutes(today[0]);
			var closes = toMinutes(today[1]);

			if (mins >= opens && mins < closes) {
				return {
					open: true,
					label: data.strings.openNow,
					detail: data.strings.until.replace('%s', today[1]),
				};
			}

			if (mins < opens) {
				return {
					open: false,
					label: data.strings.closed,
					detail: data.strings.opensAt.replace('%s', today[0]),
				};
			}
		}

		for (var i = 1; i <= 7; i++) {
			var next = ((day + i - 1) % 7) + 1;
			var slot = hours[next];

			if (!slot || slot.length !== 2) {
				continue;
			}

			var name =
				i === 1
					? data.strings.tomorrow
					: DAY_NAMES[(now.getDay() + i) % 7];

			return {
				open: false,
				label: data.strings.closed,
				detail: data.strings.opensDay
					.replace('%1$s', name)
					.replace('%2$s', slot[0]),
			};
		}

		return { open: false, label: data.strings.closed, detail: '' };
	}

	function paintStatus() {
		if (!data.branches) {
			return;
		}

		var nodes = document.querySelectorAll('[data-branch-status]');

		Array.prototype.forEach.call(nodes, function (node) {
			var slug = node.getAttribute('data-branch-status');
			var branch = data.branches[slug];

			if (!branch || !branch.hours) {
				return;
			}

			var state = computeStatus(branch.hours);
			var labelEl = node.querySelector('[data-status-label]');
			var detailEl = node.querySelector('[data-status-detail]');

			node.classList.toggle('status--open', state.open);
			node.classList.toggle('status--closed', !state.open);

			if (labelEl) {
				labelEl.textContent = state.label;
			}

			if (detailEl) {
				detailEl.textContent = state.detail;
			}
		});
	}

	/* ---------------------------------------------------------------------
	   Reveal on scroll
	   --------------------------------------------------------------------- */

	function setupReveal() {
		var items = document.querySelectorAll('.reveal');

		if (!items.length) {
			return;
		}

		var reduced =
			window.matchMedia &&
			window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		if (reduced || !('IntersectionObserver' in window)) {
			return;
		}

		function revealAll() {
			Array.prototype.forEach.call(items, function (el) {
				el.classList.add('is-in', 'is-done');
			});
		}

		// Only now do we allow anything to be hidden.
		document.documentElement.classList.add('js-reveal');

		// Failsafe against the observer never running at all: if no callback
		// has arrived within three seconds, show everything.
		//
		// It is cancelled by the first callback rather than left on a timer,
		// because IntersectionObserver always reports on every observed
		// element immediately, so one callback proves it is working. A blanket
		// timer would instead punish anyone who reads the hero for a few
		// seconds before scrolling: the whole page would already have been
		// revealed by the time they got to it.
		var failsafe = setTimeout(revealAll, 3000);
		var observerAlive = false;

		var observer = new IntersectionObserver(
			function (entries) {
				if (!observerAlive) {
					observerAlive = true;
					clearTimeout(failsafe);
				}

				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}

					var el = entry.target;
					var siblings = el.parentNode
						? el.parentNode.querySelectorAll(':scope > .reveal')
						: [];
					var index = Array.prototype.indexOf.call(siblings, el);
					if (index < 0) {
						index = 0;
					}

					// 45ms apart, capped at five steps: a long stagger reads as
					// lag rather than craft, and grids here run to eight tiles.
					var delay = Math.min(index, 5) * 45;
					el.style.setProperty('--reveal-delay', delay + 'ms');
					el.classList.add('is-in');
					observer.unobserve(el);

					// Release the compositor hint once it has settled.
					window.setTimeout(function () {
						el.classList.add('is-done');
						el.style.removeProperty('--reveal-delay');
					}, delay + 800);
				});
			},
			// Start just before the element is comfortably in view, so things
			// are already arriving as the reader gets to them.
			{ rootMargin: '0px 0px -10% 0px', threshold: 0.05 }
		);

		Array.prototype.forEach.call(items, function (el) {
			observer.observe(el);
		});

		// A print or a full-page screenshot never scrolls, so honour those too.
		if (window.matchMedia) {
			var printQuery = window.matchMedia('print');
			if (printQuery.addEventListener) {
				printQuery.addEventListener('change', function (e) {
					if (e.matches) {
						clearTimeout(failsafe);
						revealAll();
					}
				});
			}
		}
	}

	/* ---------------------------------------------------------------------
	   Sticky action bar
	   --------------------------------------------------------------------- */

	/**
	 * Keep the bar down while the hero's own call to action is still on
	 * screen, otherwise the same green button appears twice at the top of
	 * the page. Opt-in from script, so if any of this fails the bar simply
	 * stays visible, which is the safe direction to fail in.
	 */
	function setupActionBar() {
		var bar = document.querySelector('.actionbar');
		var anchor = document.querySelector('[data-actionbar-anchor]');

		if (!bar || !anchor || !('IntersectionObserver' in window)) {
			return;
		}

		bar.classList.add('actionbar--auto');

		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					bar.classList.toggle('is-up', !entry.isIntersecting);
				});
			},
			{ rootMargin: '-8px 0px 0px 0px' }
		);

		observer.observe(anchor);
	}

	/* ---------------------------------------------------------------------
	   Boot
	   --------------------------------------------------------------------- */

	function init() {
		paintStatus();
		setupReveal();
		setupActionBar();

		// Keep the pill honest for anyone who leaves the tab open over closing time.
		setInterval(paintStatus, 60000);
		document.addEventListener('visibilitychange', function () {
			if (!document.hidden) {
				paintStatus();
			}
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
