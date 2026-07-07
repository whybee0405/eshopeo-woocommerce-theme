$ErrorActionPreference = 'Stop'

$frontPagePath = Join-Path $PSScriptRoot '..\glow-theme\front-page.php'
$stylePath = Join-Path $PSScriptRoot '..\glow-theme\style.css'
$assetPath = Join-Path $PSScriptRoot '..\glow-theme\images\hero\hero-korean-beauty-faces.png'

$frontPage = Get-Content -Raw $frontPagePath
$style = Get-Content -Raw $stylePath

if (-not (Test-Path $assetPath)) {
    throw 'Generated hero background asset must exist in glow-theme/images/hero/hero-korean-beauty-faces.png.'
}

if ($frontPage -notmatch 'hero-search') {
    throw 'The eShopeo shortcode must render inside the hero foreground, not only above the hero.'
}

if ($frontPage -match 'pre-hero') {
    throw 'The old pre-hero shortcode placement should be removed from the homepage.'
}

if ($style -notmatch 'hero-korean-beauty-faces\.png') {
    throw 'Hero CSS must reference the local Korean beauty background image with diverse glowing faces.'
}

if ($style -match '\.hero-search button') {
    throw 'Hero search must not override eShopeo button styling; plugin buttons should keep their original styles.'
}

if ($style -match 'padding-block:\s*clamp\(64px,\s*8vw,\s*110px\)') {
    throw 'Hero vertical padding must be reduced so the full section is visible at a glance.'
}

if ($style -notmatch '\.hero \.t-hero\s*\{[\s\S]*?font-size:\s*clamp\(2rem,\s*4vw,\s*3\.85rem\)') {
    throw 'Homepage hero H1 must be scaled down from the global t-hero size.'
}

if ($style -notmatch 'aspect-ratio:\s*4 / 4\.6') {
    throw 'Hero product slider must keep its original desktop aspect ratio.'
}

if ($frontPage -notmatch 'Premium Korean skincare') {
    throw 'Homepage hero must lead with the v2 Korean skincare positioning.'
}

if ($frontPage -match 'ritual|method,\s*</em>\s*not the miracle') {
    throw 'Homepage hero copy must not use v1 ritual/method positioning.'
}

if ($style -notmatch '\.hero::before') {
    throw 'Hero background image must be implemented as a pseudo-element layer.'
}

if ($style -match 'oklch\(18% 0\.024 145 / 0\.92\)') {
    throw 'Hero must not keep the old dark moss overlay treatment.'
}
