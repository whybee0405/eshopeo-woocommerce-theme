$ErrorActionPreference = 'Stop'

$root = Join-Path $PSScriptRoot '..'
$brandKitPath = Join-Path $root 'cove-theme\COVE_Brand_Kit_Design.md'
$functionsPath = Join-Path $root 'cove-theme\functions.php'
$stylePath = Join-Path $root 'cove-theme\style.css'
$frontPath = Join-Path $root 'cove-theme\front-page.php'
$archivePath = Join-Path $root 'cove-theme\archive-product.php'
$singleProductPath = Join-Path $root 'cove-theme\single-product.php'
$scrollPath = Join-Path $root 'cove-theme\js\scroll-animations.js'
$pdp3dPath = Join-Path $root 'cove-theme\js\pdp-3d.js'

if (-not (Test-Path $brandKitPath)) {
    throw 'COVE_Brand_Kit_Design.md must be the active COVE brand source.'
}

$brandKit = Get-Content -Raw $brandKitPath
$functions = Get-Content -Raw $functionsPath
$style = Get-Content -Raw $stylePath
$front = Get-Content -Raw $frontPath
$archive = Get-Content -Raw $archivePath
$singleProduct = Get-Content -Raw $singleProductPath
$scroll = Get-Content -Raw $scrollPath
$pdp3d = Get-Content -Raw $pdp3dPath

if ($brandKit -notmatch 'Appliances made clear' -or $brandKit -notmatch 'Premium appliances\. Clearly graded\. Better priced\.') {
    throw 'COVE brand kit must define the new positioning and tagline.'
}

if ($functions -notmatch 'Inter\+Tight:wght@400;500;600;700' -or $functions -notmatch 'Manrope:wght@400;500;600;700;800') {
    throw 'COVE runtime fonts should follow the refined premium UI and data stacks.'
}

if ($style -match 'Fraunces|Plus Jakarta Sans|DM Mono') {
    throw 'COVE stylesheet tokens should not keep old template font stacks.'
}

foreach ($token in '--porcelain', '--liquid-blue', '--cove-blue', '--glass-silver', '--deep-navy') {
    if ($style -notmatch [regex]::Escape($token)) {
        throw "COVE stylesheet missing brand token $token."
    }
}

foreach ($asset in 'cove-hero-showroom-photo.png', 'cove-category-showroom-photo.png', 'cove-grade-inspection-photo.png') {
    if ($front -notmatch [regex]::Escape($asset)) {
        throw "Homepage must use generated brand asset $asset."
    }
}

if ($front -match 'cove-hero-clarity-portal\.png|cove-category-showroom\.png|cove-grade-trust-system\.png|cove-product-card-pdp-system\.png') {
    throw 'Homepage should not use the previous UI-mockup imagery.'
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

foreach ($needle in 'Inspection Passport', 'Grade clarity', 'Condition verified', 'Simple delivery') {
    if ($singleProduct -notmatch [regex]::Escape($needle)) {
        throw "PDP should expose $needle above the fold."
    }
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

Write-Host 'COVE premium refresh regression passed.'
