/**
 * COVE PDP — Three.js 360° product viewer.
 * Uses category-specific placeholder meshes.
 * Toggle with "View 3D" / "View photo" button.
 */
import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

(function () {
  'use strict';

  var REDUCED   = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var wrap      = document.getElementById('cove-pdp-3d-wrap');
  var canvas    = document.getElementById('cove-pdp-canvas');
  var toggleBtn = document.getElementById('cove-view-3d-btn');
  var pdpMain   = document.querySelector('[data-pdp-main]');
  var hasImage  = wrap && wrap.getAttribute('data-has-image') === 'true';
  var category  = (wrap && wrap.getAttribute('data-category')) || 'appliance';

  if (!wrap || !canvas) { return; }
  if (!window.WebGLRenderingContext) {
    if (toggleBtn) { toggleBtn.style.display = 'none'; }
    return;
  }

  var W = wrap.clientWidth;
  var H = wrap.clientHeight || W;

  var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true });
  renderer.setSize(W, H);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.1;

  var scene  = new THREE.Scene();
  scene.background = new THREE.Color(0xF7F4EE);

  var camera = new THREE.PerspectiveCamera(42, W / H, 0.1, 100);
  camera.position.set(0, 0.5, 3.5);

  var key  = new THREE.PointLight(0xFFF5E4, 3.0, 20); key.position.set(3, 3, 4);  scene.add(key);
  var fill = new THREE.PointLight(0xC8F0E8, 1.8, 20); fill.position.set(-3, 1, 2); scene.add(fill);
  var rim  = new THREE.PointLight(0xFFE4C8, 2.2, 20); rim.position.set(0, -3, -2); scene.add(rim);
  scene.add(new THREE.AmbientLight(0xffffff, 0.5));

  /* Category-specific placeholder mesh */
  var matAppl = new THREE.MeshPhysicalMaterial({
    color: 0xF0EDE8, roughness: 0.18, metalness: 0.12,
    clearcoat: 0.6, clearcoatRoughness: 0.1,
  });
  var matDark = new THREE.MeshPhysicalMaterial({
    color: 0x363B47, roughness: 0.25, metalness: 0.08,
  });
  var matAmber = new THREE.MeshStandardMaterial({ color: 0xE07B35, roughness: 0.3, metalness: 0.1 });

  function buildMesh(cat) {
    var g = new THREE.Group();
    switch (cat) {
      case 'laundry': {
        var body = new THREE.Mesh(new THREE.BoxGeometry(1.3, 1.45, 1.1), matAppl); g.add(body);
        var door = new THREE.Mesh(new THREE.CircleGeometry(0.44, 32), new THREE.MeshPhysicalMaterial({ color: 0x888EA0, roughness: 0.05, metalness: 0.2, opacity: 0.85, transparent: true }));
        door.position.set(0, 0, 0.555); g.add(door);
        var ring = new THREE.Mesh(new THREE.TorusGeometry(0.46, 0.045, 8, 32), matDark); ring.position.set(0, 0, 0.548); g.add(ring);
        var knob = new THREE.Mesh(new THREE.CylinderGeometry(0.07, 0.07, 0.055, 14), matAmber); knob.rotation.x = Math.PI / 2; knob.position.set(-0.35, 0.62, 0.557); g.add(knob);
        break;
      }
      case 'climate': {
        var body2 = new THREE.Mesh(new THREE.CylinderGeometry(0.50, 0.54, 2.2, 28), matAppl); g.add(body2);
        var ring2 = new THREE.Mesh(new THREE.TorusGeometry(0.50, 0.042, 8, 28), matAmber); ring2.position.y = 0.8; g.add(ring2);
        var vent2 = new THREE.Mesh(new THREE.CylinderGeometry(0.26, 0.26, 0.065, 28), matDark); vent2.position.y = 1.17; g.add(vent2);
        break;
      }
      case 'floor-care': {
        var base3 = new THREE.Mesh(new THREE.BoxGeometry(1.4, 0.22, 0.5), matAppl); g.add(base3);
        var tube3 = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.095, 2.0, 12), matDark); tube3.position.set(0, 1.1, 0); tube3.rotation.z = 0.15; g.add(tube3);
        var head3 = new THREE.Mesh(new THREE.SphereGeometry(0.28, 12, 10), matAppl); head3.position.set(0.18, 2.12, 0); g.add(head3);
        break;
      }
      case 'personal-care': {
        var body4 = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.22, 2.0, 24), matAppl); g.add(body4);
        var cap4  = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.24, 0.22, 24), matDark); cap4.position.y = 1.11; g.add(cap4);
        var btn4  = new THREE.Mesh(new THREE.BoxGeometry(0.28, 0.1, 0.05), matAmber); btn4.position.set(0, -0.3, 0.225); g.add(btn4);
        break;
      }
      default: { /* kitchen / appliance fallback */
        var body5 = new THREE.Mesh(new THREE.BoxGeometry(1.1, 1.35, 0.9), matAppl); g.add(body5);
        var panel5 = new THREE.Mesh(new THREE.BoxGeometry(1.1, 0.22, 0.12), matDark); panel5.position.set(0, 0.78, 0.48); g.add(panel5);
        var btn5   = new THREE.Mesh(new THREE.CylinderGeometry(0.085, 0.085, 0.055, 14), matAmber); btn5.rotation.x = Math.PI / 2; btn5.position.set(-0.3, 0.79, 0.545); g.add(btn5);
        var display5 = new THREE.Mesh(new THREE.BoxGeometry(0.5, 0.1, 0.02), new THREE.MeshStandardMaterial({ color: 0x222831, emissive: 0x2DB89A, emissiveIntensity: 0.4 })); display5.position.set(0.1, 0.79, 0.547); g.add(display5);
      }
    }
    return g;
  }

  var group = buildMesh(category);
  scene.add(group);

  /* PMREM environment */
  var pmrem   = new THREE.PMREMGenerator(renderer);
  var envScene = new RoomEnvironment();
  scene.environment = pmrem.fromScene(envScene, 0.04).texture;
  pmrem.dispose();
  envScene.dispose();

  /* Orbit controls */
  var controls = new OrbitControls(camera, renderer.domElement);
  controls.enableZoom = false;
  controls.enablePan  = false;
  controls.enableDamping  = true;
  controls.dampingFactor  = 0.06;
  controls.rotateSpeed    = 0.7;
  controls.autoRotate     = !REDUCED;
  controls.autoRotateSpeed = 1.0;

  /* Render loop */
  var animId = null;
  function animate() {
    animId = requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
  }

  function startRenderer() {
    if (!animId) { animate(); }
  }

  function stopRenderer() {
    if (animId) {
      cancelAnimationFrame(animId);
      animId = null;
    }
  }

  /* Toggle 3D / photo */
  var showing3d = false;

  if (hasImage && toggleBtn) {
    if (canvas) { canvas.hidden = true; }

    toggleBtn.addEventListener('click', function () {
      showing3d = !showing3d;
      if (showing3d) {
        if (pdpMain) { pdpMain.hidden = true; }
        canvas.hidden = false;
        startRenderer();
        toggleBtn.textContent = 'View photo';
        controls.autoRotate = !REDUCED;
      } else {
        canvas.hidden = true;
        if (pdpMain) { pdpMain.hidden = false; }
        toggleBtn.textContent = 'View 3D';
        controls.autoRotate = false;
        stopRenderer();
      }
    });
  } else {
    /* No product image — show 3D immediately */
    showing3d = true;
    startRenderer();
  }

  /* Resize */
  new ResizeObserver(function () {
    W = wrap.clientWidth;
    H = wrap.clientHeight || W;
    camera.aspect = W / H;
    camera.updateProjectionMatrix();
    renderer.setSize(W, H);
  }).observe(wrap);

  /* Pause when hidden */
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) { stopRenderer(); }
    else if (showing3d) { startRenderer(); }
  });

})();
