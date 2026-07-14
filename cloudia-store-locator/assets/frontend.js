(function () {
  'use strict';

  var config = window.cloudiaStoreLocator || {};
  var locations = Array.isArray(config.locations) ? config.locations.slice() : [];
  var provider = config.provider || 'leaflet';
  var strings = config.i18n || {};

  function $(selector, context) { return (context || document).querySelector(selector); }
  function formatDistance(km) {
    if (!isFinite(km)) return '';
    if (km < 1) return Math.round(km * 1000) + ' m';
    return km.toFixed(km < 10 ? 1 : 0) + ' km';
  }

  function haversine(lat1, lon1, lat2, lon2) {
    var toRad = function (v) { return v * Math.PI / 180; };
    var R = 6371;
    var dLat = toRad(lat2 - lat1);
    var dLon = toRad(lon2 - lon1);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
  }

  function createLeafletMap(node, points) {
    var map = L.map(node, { scrollWheelZoom: false });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    var markers = [];
    points.forEach(function (point) {
      var marker = L.marker([point.lat, point.lng]).addTo(map).bindPopup('<strong>' + point.name + '</strong><br>' + point.address);
      markers.push(marker);
    });
    if (markers.length === 1) {
      map.setView([points[0].lat, points[0].lng], 11);
    } else {
      var group = L.featureGroup(markers);
      map.fitBounds(group.getBounds().pad(0.15));
    }
    return {
      focus: function (point) {
        map.setView([point.lat, point.lng], 12);
      },
      user: function (coords) {
        L.circleMarker([coords.latitude, coords.longitude], { radius: 8 }).addTo(map);
      }
    };
  }

  function createGoogleMap(node, points) {
    var map = new google.maps.Map(node, {
      center: { lat: points[0].lat, lng: points[0].lng },
      zoom: 6,
      mapTypeControl: false,
      streetViewControl: false
    });
    var bounds = new google.maps.LatLngBounds();
    points.forEach(function (point) {
      new google.maps.Marker({
        position: { lat: point.lat, lng: point.lng },
        map: map,
        title: point.name
      });
      bounds.extend({ lat: point.lat, lng: point.lng });
    });
    if (points.length > 1) {
      map.fitBounds(bounds, 60);
    } else {
      map.setZoom(11);
    }
    return {
      focus: function (point) {
        map.panTo({ lat: point.lat, lng: point.lng });
        map.setZoom(12);
      },
      user: function (coords) {
        new google.maps.Marker({
          position: { lat: coords.latitude, lng: coords.longitude },
          map: map,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 7,
            fillColor: '#2563eb',
            fillOpacity: 1,
            strokeColor: '#ffffff',
            strokeWeight: 2
          }
        });
      }
    };
  }

  function initLocator(root) {
    var search = $('[data-csl-search]', root);
    var locate = $('[data-csl-locate]', root);
    var reset = $('[data-csl-reset]', root);
    var results = $('[data-csl-results]', root);
    var status = $('[data-csl-status]', root);
    var mapNode = $('[data-csl-map]', root);
    var featured = $('[data-csl-featured]', root);
    if (!mapNode || !results || !locations.length) return;

    var points = locations.map(function (item) {
      return Object.assign({}, item, {
        search: [item.name, item.address, item.province, item.country].join(' ').toLowerCase(),
        distance: null
      });
    });

    var map = provider === 'google' && window.google && google.maps
      ? createGoogleMap(mapNode, points)
      : createLeafletMap(mapNode, points);

    function updateFeatured(point) {
      if (!featured || !point) return;
      featured.hidden = false;
      $('[data-csl-featured-name]', featured).textContent = point.name;
      $('[data-csl-featured-meta]', featured).textContent = point.address + (point.distance !== null ? ' • ' + formatDistance(point.distance) + ' ' + (strings.distanceAway || 'away') : '');
      $('[data-csl-featured-branch]', featured).setAttribute('href', point.url);
      $('[data-csl-featured-call]', featured).setAttribute('href', 'tel:' + (point.phone || ''));
      $('[data-csl-featured-whatsapp]', featured).setAttribute('href', point.whatsapp || '#');
      $('[data-csl-featured-directions]', featured).setAttribute('href', point.directions || '#');
      map.focus(point);
    }

    function render(list) {
      results.innerHTML = '';
      if (!list.length) {
        status.textContent = strings.noMatches || 'No matching branches found.';
        if (featured) featured.hidden = true;
        return;
      }

      list.forEach(function (point) {
        var article = document.createElement('article');
        article.className = 'csl-card';
        article.innerHTML = [
          '<div class="csl-card__copy">',
          '<p class="csl-card__eyebrow">' + (point.province || point.country || '') + '</p>',
          '<h3 class="csl-card__title">' + point.name + '</h3>',
          '<p class="csl-card__meta">' + point.address + '</p>',
          point.distance !== null ? '<p class="csl-card__distance">' + formatDistance(point.distance) + ' ' + (strings.distanceAway || 'away') + '</p>' : '',
          '</div>',
          '<div class="csl-card__actions">',
          '<a class="csl-button" href="' + point.url + '">Branch page</a>',
          '<a class="csl-button csl-button--secondary" href="tel:' + (point.phone || '') + '">Call</a>',
          '<a class="csl-button csl-button--secondary" target="_blank" rel="noopener" href="' + (point.whatsapp || '#') + '">WhatsApp</a>',
          '<a class="csl-button csl-button--secondary" target="_blank" rel="noopener" href="' + (point.directions || '#') + '">Directions</a>',
          '</div>'
        ].join('');
        article.addEventListener('mouseenter', function () { map.focus(point); });
        results.appendChild(article);
      });

      updateFeatured(list[0]);
    }

    function filterAndRender() {
      var term = (search.value || '').trim().toLowerCase();
      var filtered = points.filter(function (point) {
        return !term || point.search.indexOf(term) !== -1;
      });
      filtered.sort(function (a, b) {
        if (a.distance === null && b.distance === null) return 0;
        if (a.distance === null) return 1;
        if (b.distance === null) return -1;
        return a.distance - b.distance;
      });
      if (status && term) {
        status.textContent = filtered.length ? ('Showing ' + filtered.length + ' matching branches.') : (strings.noMatches || 'No matching branches found.');
      }
      render(filtered);
    }

    function locateUser() {
      if (!navigator.geolocation) {
        status.textContent = strings.noGeo || 'Location access was unavailable. Showing all branches instead.';
        return;
      }
      status.textContent = strings.locating || 'Checking your location…';
      navigator.geolocation.getCurrentPosition(function (position) {
        points.forEach(function (point) {
          point.distance = haversine(position.coords.latitude, position.coords.longitude, point.lat, point.lng);
        });
        points.sort(function (a, b) { return a.distance - b.distance; });
        map.user(position.coords);
        status.textContent = strings.nearest || 'Nearest branches to your current location.';
        filterAndRender();
      }, function () {
        status.textContent = strings.noGeo || 'Location access was unavailable. Showing all branches instead.';
        filterAndRender();
      }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 600000 });
    }

    search.addEventListener('input', filterAndRender);
    locate.addEventListener('click', locateUser);
    reset.addEventListener('click', function () {
      search.value = '';
      points.forEach(function (point) { point.distance = null; });
      status.textContent = strings.showingAll || 'Showing all branches.';
      filterAndRender();
    });

    filterAndRender();
    locateUser();
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-csl-root]').forEach(initLocator);
  });
})();
