/**
 * COVE hero room — Three.js interactive room environment.
 * Products are hot spots; hovering glows them and shows a tooltip card.
 * Mouse parallax tilts the camera ±3°.
 * Falls back silently on mobile or no-WebGL.
 */
import * as THREE from 'three';

(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (window.innerWidth < 768) { return; }
  if (!window.WebGLRenderingContext) { return; }

  var canvas    = document.getElementById('cove-hero-canvas');
  var container = canvas && canvas.parentElement;
  var tooltipEl = document.getElementById('cove-hero-tooltip');
  if (!canvas || !container) { return; }

  var W = container.clientWidth;
  var H = container.clientHeight;

  /* Renderer */
  var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: false });
  renderer.setSize(W, H);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;

  /* Scene */
  var scene = new THREE.Scene();
  scene.background = new THREE.Color(0xEDE9DF);
  scene.fog = new THREE.Fog(0xEDE9DF, 18, 32);

  /* Camera */
  var camera = new THREE.PerspectiveCamera(42, W / H, 0.1, 50);
  camera.position.set(0, 2.2, 9.5);
  camera.lookAt(0, 0.5, 0);
  var camBase = camera.position.clone();

  /* Lights */
  scene.add(new THREE.AmbientLight(0xF7F4EE, 1.1));

  var sun = new THREE.DirectionalLight(0xFFF5E4, 2.2);
  sun.position.set(6, 9, 6);
  sun.castShadow = true;
  sun.shadow.camera.near = 0.1;
  sun.shadow.camera.far = 30;
  sun.shadow.camera.left = sun.shadow.camera.bottom = -9;
  sun.shadow.camera.right = sun.shadow.camera.top = 9;
  sun.shadow.mapSize.set(1024, 1024);
  scene.add(sun);

  var fill = new THREE.PointLight(0xE8C5A0, 1.2, 22);
  fill.position.set(-6, 5, 4);
  scene.add(fill);

  /* Materials */
  var matFloor   = new THREE.MeshLambertMaterial({ color: 0xD4C9B5 });
  var matWall    = new THREE.MeshLambertMaterial({ color: 0xF0EBE2 });
  var matCounter = new THREE.MeshLambertMaterial({ color: 0x3A3F4A });
  var matBase    = new THREE.MeshLambertMaterial({ color: 0x4A4F5A });
  var matAppl    = new THREE.MeshPhongMaterial({ color: 0xF0EDE8, shininess: 55 });
  var matDark    = new THREE.MeshPhongMaterial({ color: 0x363B47, shininess: 30 });
  var matAmber   = new THREE.MeshPhongMaterial({ color: 0xE07B35, shininess: 80 });
  var matGlass   = new THREE.MeshPhongMaterial({ color: 0x888EA0, shininess: 120, opacity: 0.8, transparent: true });
  var matGreen   = new THREE.MeshPhongMaterial({ color: 0x2DB89A, shininess: 60 });

  /* Room geometry */
  var floor = new THREE.Mesh(new THREE.PlaneGeometry(22, 16), matFloor);
  floor.rotation.x = -Math.PI / 2;
  floor.position.y = -2.1;
  floor.receiveShadow = true;
  scene.add(floor);

  var backWall = new THREE.Mesh(new THREE.BoxGeometry(22, 11, 0.25), matWall);
  backWall.position.set(0, 3.4, -4.2);
  scene.add(backWall);

  var leftWall = new THREE.Mesh(new THREE.BoxGeometry(0.25, 11, 16), matWall);
  leftWall.position.set(-7, 3.4, 0);
  scene.add(leftWall);

  /* Kitchen counter */
  var counter = new THREE.Mesh(new THREE.BoxGeometry(5.2, 0.15, 1.6), matCounter);
  counter.position.set(3.5, -0.65, -2);
  counter.castShadow = true;
  counter.receiveShadow = true;
  scene.add(counter);

  var counterBody = new THREE.Mesh(new THREE.BoxGeometry(5.2, 1.5, 1.55), matBase);
  counterBody.position.set(3.5, -1.45, -2);
  scene.add(counterBody);

  /* Product builder helpers */
  function addShadow(mesh) {
    mesh.traverse(function (c) {
      if (c.isMesh) { c.castShadow = true; c.receiveShadow = true; }
    });
    return mesh;
  }

  function makeCoffeeMachine() {
    var g = new THREE.Group();
    g.add(addShadow(new THREE.Mesh(new THREE.BoxGeometry(0.65, 0.85, 0.55), matAppl)));
    var tank = new THREE.Mesh(new THREE.BoxGeometry(0.28, 0.62, 0.32), matDark);
    tank.position.set(0.2, 0.1, 0);
    g.add(tank);
    var btn = new THREE.Mesh(new THREE.CylinderGeometry(0.065, 0.065, 0.045, 12), matAmber);
    btn.rotation.x = Math.PI / 2;
    btn.position.set(-0.12, -0.1, 0.29);
    g.add(btn);
    return g;
  }

  function makeKettle() {
    var g = new THREE.Group();
    var body = new THREE.Mesh(new THREE.CylinderGeometry(0.20, 0.17, 0.52, 18), matAppl);
    body.castShadow = true;
    g.add(body);
    var lid = new THREE.Mesh(new THREE.CylinderGeometry(0.21, 0.21, 0.06, 18), matDark);
    lid.position.y = 0.29;
    g.add(lid);
    var spout = new THREE.Mesh(new THREE.CylinderGeometry(0.027, 0.032, 0.32, 10), matDark);
    spout.rotation.z = -0.65;
    spout.position.set(0.20, 0.06, 0);
    g.add(spout);
    return g;
  }

  function makeAirPurifier() {
    var g = new THREE.Group();
    var body = new THREE.Mesh(new THREE.CylinderGeometry(0.30, 0.32, 1.5, 22), matAppl);
    body.castShadow = true;
    g.add(body);
    var ring = new THREE.Mesh(new THREE.TorusGeometry(0.30, 0.028, 8, 22), matGreen);
    ring.position.y = 0.55;
    g.add(ring);
    var vent = new THREE.Mesh(new THREE.CylinderGeometry(0.16, 0.16, 0.045, 22), matDark);
    vent.position.y = 0.78;
    g.add(vent);
    return g;
  }

  function makeVacuum() {
    var g = new THREE.Group();
    var base = new THREE.Mesh(new THREE.BoxGeometry(0.85, 0.16, 0.32), matAppl);
    base.castShadow = true;
    g.add(base);
    var tube = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.065, 1.25, 10), matDark);
    tube.position.set(0, 0.7, 0);
    tube.rotation.z = 0.18;
    g.add(tube);
    var head = new THREE.Mesh(new THREE.SphereGeometry(0.18, 10, 8), matAppl);
    head.position.set(0.12, 1.35, 0);
    g.add(head);
    return g;
  }

  function makeWashingMachine() {
    var g = new THREE.Group();
    var body = new THREE.Mesh(new THREE.BoxGeometry(0.78, 0.88, 0.68), matAppl);
    body.castShadow = true;
    g.add(body);
    var door = new THREE.Mesh(new THREE.CircleGeometry(0.27, 28), matGlass);
    door.position.set(0, 0, 0.342);
    g.add(door);
    var ring = new THREE.Mesh(new THREE.TorusGeometry(0.28, 0.03, 8, 28), matDark);
    ring.position.set(0, 0, 0.335);
    g.add(ring);
    var panel = new THREE.Mesh(new THREE.BoxGeometry(0.78, 0.14, 0.12), matDark);
    panel.position.set(0, 0.50, 0.29);
    g.add(panel);
    var knob = new THREE.Mesh(new THREE.CylinderGeometry(0.048, 0.048, 0.045, 14), matAmber);
    knob.rotation.x = Math.PI / 2;
    knob.position.set(-0.22, 0.51, 0.345);
    g.add(knob);
    return g;
  }

  /* Product data */
  var products = [
    {
      id:         'coffee',
      name:       'Espresso Coffee Machine',
      price:      'from R1 299',
      grade:      'New',
      badgeClass: 'badge-new',
      link:       '/shop?cat=kitchen',
      build:      makeCoffeeMachine,
      pos:        new THREE.Vector3(2.2, -0.25, -1.35),
      scale:      1.0,
    },
    {
      id:         'kettle',
      name:       'Variable Temp Kettle',
      price:      'from R499 · Grade A',
      grade:      'Grade A',
      badgeClass: 'badge-grade-a',
      link:       '/shop?cat=kitchen&condition=grade-a',
      build:      makeKettle,
      pos:        new THREE.Vector3(3.9, -0.38, -1.35),
      scale:      1.0,
    },
    {
      id:         'air-purifier',
      name:       'Air Purifier 45m²',
      price:      'from R2 199',
      grade:      'New',
      badgeClass: 'badge-new',
      link:       '/shop?cat=climate',
      build:      makeAirPurifier,
      pos:        new THREE.Vector3(-5.2, -1.35, -3.0),
      scale:      1.0,
    },
    {
      id:         'vacuum',
      name:       'Cordless Stick Vacuum',
      price:      'from R899 · Grade B',
      grade:      'Grade B',
      badgeClass: 'badge-grade-b',
      link:       '/shop?cat=floor-care',
      build:      makeVacuum,
      pos:        new THREE.Vector3(-2.8, -2.02, 0.6),
      scale:      0.92,
    },
    {
      id:         'washer',
      name:       'Front Loader 7kg',
      price:      'from R3 999 · Grade B',
      grade:      'Grade B',
      badgeClass: 'badge-grade-b',
      link:       '/shop?cat=laundry',
      build:      makeWashingMachine,
      pos:        new THREE.Vector3(-5.0, -1.66, -2.8),
      scale:      1.0,
    },
  ];

  /* Place product meshes + hotspot spheres */
  var hotspotMeshes = [];
  var hoverLights   = {};

  products.forEach(function (p) {
    var g = p.build();
    g.position.copy(p.pos);
    g.scale.setScalar(p.scale);
    scene.add(g);

    /* Invisible hotspot */
    var hs = new THREE.Mesh(
      new THREE.SphereGeometry(0.6, 8, 8),
      new THREE.MeshBasicMaterial({ visible: false })
    );
    hs.position.copy(p.pos);
    hs.userData.productId = p.id;
    scene.add(hs);
    hotspotMeshes.push(hs);

    /* Per-product amber glow light (starts at 0) */
    var light = new THREE.PointLight(0xE07B35, 0, 4.5);
    light.position.copy(p.pos);
    light.position.y += 0.6;
    scene.add(light);
    hoverLights[p.id] = light;
  });

  /* Tooltip helpers */
  var activeId = null;

  function showTooltip(pid, sx, sy) {
    var p = products.find(function (q) { return q.id === pid; });
    if (!p || !tooltipEl) { return; }

    tooltipEl.querySelector('.hero-tooltip__badge').textContent = p.grade;
    tooltipEl.querySelector('.hero-tooltip__badge').className = 'hero-tooltip__badge badge ' + p.badgeClass;
    tooltipEl.querySelector('.hero-tooltip__name').textContent = p.name;
    tooltipEl.querySelector('.hero-tooltip__price').textContent = p.price;
    tooltipEl.querySelector('.hero-tooltip__link').href = p.link;

    var offset = 16;
    tooltipEl.style.left = (sx + offset) + 'px';
    tooltipEl.style.top  = (sy - 20) + 'px';
    tooltipEl.classList.add('is-visible');

    products.forEach(function (q) {
      hoverLights[q.id].intensity = (q.id === pid) ? 4 : 0;
    });
  }

  function hideTooltip() {
    if (tooltipEl) { tooltipEl.classList.remove('is-visible'); }
    products.forEach(function (q) { hoverLights[q.id].intensity = 0; });
    activeId = null;
  }

  /* Raycaster */
  var raycaster   = new THREE.Raycaster();
  var mouseNDC    = new THREE.Vector2(-10, -10);
  var mouseScreen = { x: 0, y: 0 };

  canvas.addEventListener('mousemove', function (e) {
    var rect = canvas.getBoundingClientRect();
    mouseNDC.x = ((e.clientX - rect.left) / W) * 2 - 1;
    mouseNDC.y = -((e.clientY - rect.top)  / H) * 2 + 1;
    mouseScreen.x = e.clientX - rect.left;
    mouseScreen.y = e.clientY - rect.top;
  }, { passive: true });

  canvas.addEventListener('mouseleave', function () {
    mouseNDC.set(-10, -10);
    hideTooltip();
  }, { passive: true });

  canvas.addEventListener('click', function () {
    if (activeId) {
      var p = products.find(function (q) { return q.id === activeId; });
      if (p) { window.location.href = p.link; }
    }
  });

  /* Parallax */
  var pxTarget  = { x: 0, y: 0 };
  var pxCurrent = { x: 0, y: 0 };
  var MAX_PX = 0.055;

  document.addEventListener('mousemove', function (e) {
    pxTarget.x = (e.clientX / window.innerWidth  - 0.5) * 2;
    pxTarget.y = (e.clientY / window.innerHeight - 0.5) * 2;
  }, { passive: true });

  /* Render loop */
  var animId = null;

  function animate() {
    animId = requestAnimationFrame(animate);

    if (!REDUCED) {
      pxCurrent.x += (pxTarget.x - pxCurrent.x) * 0.04;
      pxCurrent.y += (pxTarget.y - pxCurrent.y) * 0.04;
      camera.position.x = camBase.x + pxCurrent.x * MAX_PX * 9;
      camera.position.y = camBase.y - pxCurrent.y * MAX_PX * 4;
      camera.lookAt(0, 0.5, 0);
    }

    raycaster.setFromCamera(mouseNDC, camera);
    var hits = raycaster.intersectObjects(hotspotMeshes);

    if (hits.length > 0) {
      var hitId = hits[0].object.userData.productId;
      if (hitId !== activeId) {
        activeId = hitId;
        canvas.style.cursor = 'pointer';
      }
      showTooltip(hitId, mouseScreen.x, mouseScreen.y);
    } else if (activeId) {
      hideTooltip();
      canvas.style.cursor = '';
    }

    renderer.render(scene, camera);
  }

  animate();

  /* Resize */
  new ResizeObserver(function () {
    W = container.clientWidth;
    H = container.clientHeight;
    camera.aspect = W / H;
    camera.updateProjectionMatrix();
    renderer.setSize(W, H);
  }).observe(container);

  /* Pause when tab hidden */
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) { cancelAnimationFrame(animId); animId = null; }
    else if (!animId) { animate(); }
  });

})();
