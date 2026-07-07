$ErrorActionPreference = 'Stop'

$frontPagePath = Join-Path $PSScriptRoot '..\glow-theme\front-page.php'
$stylePath = Join-Path $PSScriptRoot '..\glow-theme\style.css'

$frontPage = Get-Content -Raw $frontPagePath
$style = Get-Content -Raw $stylePath

if ($frontPage -notmatch 'brand-loop-section') {
    throw 'Homepage must include the Korean beauty brand logo loop section.'
}

if ($frontPage -notmatch 'aria-label="<\?php esc_attr_e\( ''Korean beauty brands featured on Glow''') {
    throw 'Brand logo loop must expose a useful accessible region label.'
}

foreach ($brand in @('COSRX', 'Laneige', 'Innisfree', 'Beauty of Joseon', 'Dr.Jart+', 'Sulwhasoo', 'Anua', 'Round Lab', 'Skin1004', 'Klairs', 'Etude', 'Missha')) {
    if ($frontPage -notmatch [regex]::Escape($brand)) {
        throw "Brand logo loop must include $brand."
    }
}

if ($frontPage -notmatch 'aria-hidden="true"') {
    throw 'Brand logo loop must render a hidden duplicate track for seamless looping without duplicate screen-reader output.'
}

if ($style -notmatch '@keyframes\s+glow-logo-loop') {
    throw 'Brand logo loop must define a marquee keyframe animation.'
}

if ($style -notmatch '\.brand-loop-track:hover\s*\{[\s\S]*?animation-play-state:\s*paused') {
    throw 'Brand logo loop must pause on hover.'
}

if ($style -notmatch '\.brand-loop\s*::before[\s\S]*?\.brand-loop\s*::after') {
    throw 'Brand logo loop must have edge fade pseudo-elements.'
}

if ($style -notmatch '@media\s*\(prefers-reduced-motion:\s*reduce\)[\s\S]*?\.brand-loop-track\s*\{[\s\S]*?animation:\s*none') {
    throw 'Brand logo loop must stop animation for reduced-motion users.'
}
