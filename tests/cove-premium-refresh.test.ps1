$ErrorActionPreference = 'Stop'

$root = Join-Path $PSScriptRoot '..'
$designPath = Join-Path $root 'cove-theme\DESIGN.md'
$functionsPath = Join-Path $root 'cove-theme\functions.php'
$stylePath = Join-Path $root 'cove-theme\style.css'
$brandKitPath = Join-Path $root 'cove-theme\page-brand-kit.php'
$archivePath = Join-Path $root 'cove-theme\archive-product.php'
$singleProductPath = Join-Path $root 'cove-theme\single-product.php'
$scrollPath = Join-Path $root 'cove-theme\js\scroll-animations.js'
$pdp3dPath = Join-Path $root 'cove-theme\js\pdp-3d.js'

if (-not (Test-Path $designPath)) {
    throw 'Cove needs a dedicated DESIGN.md so brand decisions do not inherit the Glow project context.'
}

$design = Get-Content -Raw $designPath
$functions = Get-Content -Raw $functionsPath
$style = Get-Content -Raw $stylePath
$brandKit = Get-Content -Raw $brandKitPath
$archive = Get-Content -Raw $archivePath
$singleProduct = Get-Content -Raw $singleProductPath
$scroll = Get-Content -Raw $scrollPath
$pdp3d = Get-Content -Raw $pdp3dPath

if ($design -notmatch 'Inspection Passport') {
    throw 'Cove design docs should define the Inspection Passport as the core trust pattern.'
}

if ($functions -match 'Fraunces|Plus\+Jakarta|DM\+Mono') {
    throw 'Cove runtime fonts should move away from the old Fraunces / Plus Jakarta Sans / DM Mono stack.'
}

if ($style -match 'Fraunces|Plus Jakarta Sans|DM Mono') {
    throw 'Cove stylesheet tokens should not keep the old template font stack.'
}

if ($brandKit -match 'Fraunces|Plus Jakarta Sans|DM Mono|transition:\s*all') {
    throw 'Cove brand kit should reflect the v2 typography and avoid transition: all.'
}

if ($archive -match 'type="checkbox"\s+name="condition"|type="checkbox"\s+name="cat"|type="checkbox"\s+name="brand"') {
    throw 'Single-value catalogue filters should not use checkbox controls.'
}

if ($archive -notmatch 'type="radio"\s+name="condition"|type="radio"\s+name="cat"|type="radio"\s+name="brand"') {
    throw 'Catalogue filters should use radio controls for single-value filters.'
}

if ($singleProduct -match '<div class="pdp-sticky-bar" aria-hidden="true"') {
    throw 'The sticky PDP buy bar must remain accessible to assistive technology.'
}

if ($singleProduct -notmatch 'Inspection Passport') {
    throw 'PDP should expose an Inspection Passport trust module above the fold.'
}

if ($scroll -notmatch "trigger:\s*'.category-strip'") {
    throw 'Scroll animation should target the actual category-strip markup.'
}

if ($pdp3d -match 'animate\(\);\s*/\*\s*start loop even while hidden') {
    throw 'PDP 3D should not render continuously while hidden behind the product photo.'
}

if ($pdp3d -notmatch 'startRenderer\(\)') {
    throw 'PDP 3D should use an explicit startRenderer() lifecycle.'
}
