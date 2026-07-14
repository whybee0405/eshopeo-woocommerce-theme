(function () {
  const config = window.cloudiaWhatsAppButton;
  const root = document.querySelector('[data-cwb-root]');
  const button = root ? root.querySelector('[data-cwb-button]') : null;

  if (!config || !root || !button) {
    return;
  }

  const sessionState = {
    impressionSent: false,
  };

  function detectDeviceType() {
    const width = window.innerWidth || 0;
    if (width <= 767) return 'mobile';
    if (width <= 1024) return 'tablet';
    return 'desktop';
  }

  function detectOs(ua) {
    if (/Windows/i.test(ua)) return 'Windows';
    if (/Android/i.test(ua)) return 'Android';
    if (/iPhone|iPad|iPod/i.test(ua)) return 'iOS';
    if (/Mac OS X/i.test(ua)) return 'macOS';
    if (/Linux/i.test(ua)) return 'Linux';
    return 'Unknown';
  }

  function detectBrowser(ua) {
    if (/Edg\//i.test(ua)) return 'Edge';
    if (/Chrome\//i.test(ua) && !/Edg\//i.test(ua)) return 'Chrome';
    if (/Safari\//i.test(ua) && !/Chrome\//i.test(ua)) return 'Safari';
    if (/Firefox\//i.test(ua)) return 'Firefox';
    return 'Unknown';
  }

  function track(eventType) {
    const ua = navigator.userAgent || '';
    const payload = new URLSearchParams({
      action: 'cwb_track',
      nonce: config.nonce,
      event_type: eventType,
      page_id: String(config.pageId || 0),
      page_title: config.pageTitle || document.title || '',
      page_url: window.location.href,
      page_path: window.location.pathname,
      post_type: config.postType || '',
      template_slug: config.templateSlug || '',
      referrer_url: document.referrer || config.referrer || '',
      utm_source: (config.utm && config.utm.source) || '',
      utm_medium: (config.utm && config.utm.medium) || '',
      utm_campaign: (config.utm && config.utm.campaign) || '',
      utm_content: (config.utm && config.utm.content) || '',
      utm_term: (config.utm && config.utm.term) || '',
      device_type: detectDeviceType(),
      os_name: detectOs(ua),
      browser_name: detectBrowser(ua),
      language_code: navigator.language || '',
      timezone_label: Intl.DateTimeFormat().resolvedOptions().timeZone || '',
      screen_width: String(window.screen.width || 0),
      screen_height: String(window.screen.height || 0),
      viewport_width: String(window.innerWidth || 0),
      viewport_height: String(window.innerHeight || 0),
      button_position: root.dataset.cwbPosition || config.position || '',
      click_target: 'whatsapp',
      phone: button.dataset.cwbPhone || config.phone || '',
      message: button.dataset.cwbMessage || config.message || '',
    });

    if (navigator.sendBeacon) {
      navigator.sendBeacon(config.ajaxUrl, payload);
      return;
    }

    fetch(config.ajaxUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
      },
      body: payload.toString(),
      credentials: 'same-origin',
      keepalive: true,
    }).catch(function () {});
  }

  function maybeTrackImpression() {
    if (sessionState.impressionSent) {
      return;
    }

    sessionState.impressionSent = true;
    track('impression');
  }

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        maybeTrackImpression();
      }
    });
  }, { threshold: 0.35 });

  observer.observe(root);

  button.addEventListener('click', function () {
    track('click');
  });
})();
