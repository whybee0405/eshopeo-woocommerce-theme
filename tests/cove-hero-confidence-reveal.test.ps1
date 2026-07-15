$ErrorActionPreference = 'Stop'

$root = Join-Path $PSScriptRoot '..'
$theme = Join-Path $root 'cove-theme'

function Read-ThemeFile($relative) {
    Get-Content -Raw (Join-Path $theme $relative)
}

$front = Read-ThemeFile 'front-page.php'
$style = Read-ThemeFile 'style.css'
$functions = Read-ThemeFile 'functions.php'
$heroJsPath = Join-Path $theme 'js\hero-confidence.js'

if ($front -notmatch 'Premium appliances, clearly graded\.') {
    throw 'Hero should lead with the clearer premium/value headline.'
}

foreach ($needle in 'Inspected demo and graded appliances, priced around their real condition.', 'Shop Better-Value Appliances', 'See Grade Examples') {
    if ($front -notmatch [regex]::Escape($needle)) {
        throw "Hero missing confidence/value copy: $needle"
    }
}

if ($front -match 'Small cosmetic marks become smart savings when you know exactly what you are buying') {
    throw 'Hero overlay copy should be concise enough to avoid clipping.'
}

foreach ($needle in 'confidence-reveal', 'data-confidence-hero', 'data-lens', 'data-grade-option', 'data-hotspot', 'data-price-card') {
    if ($front -notmatch [regex]::Escape($needle)) {
        throw "Hero missing interaction hook $needle."
    }
}

foreach ($needle in 'cove-confidence-hero--full-bleed', 'confidence-reveal__copy-panel', 'data-hero-copy-panel') {
    if ($front -notmatch [regex]::Escape($needle)) {
        throw "Hero missing full-bleed integrated copy hook $needle."
    }
}

foreach ($grade in @('New', 'A Grade', 'B Grade', 'C Grade')) {
    if ($front -notmatch [regex]::Escape($grade)) {
        throw "Hero grade control missing $grade."
    }
}

foreach ($proof in 'Cosmetic mark disclosed', 'No performance impact', 'Performance tested', 'Why it costs less', 'Warranty included', 'Delivery ready', 'A Grade example', 'confidence-reveal__mobile-facts') {
    if ($front -notmatch [regex]::Escape($proof)) {
        throw "Hero confidence reveal missing proof note: $proof"
    }
}

foreach ($nodeClass in 'confidence-reveal__hotspot--scuff', 'confidence-reveal__hotspot--tested', 'confidence-reveal__hotspot--saving', 'confidence-reveal__hotspot--warranty', 'confidence-reveal__hotspot--delivery', 'confidence-reveal__hotspot--grade') {
    if ($front -notmatch [regex]::Escape($nodeClass)) {
        throw "Hero confidence reveal missing expanded node: $nodeClass"
    }
}

if (-not (Test-Path $heroJsPath)) {
    throw 'Hero confidence interaction script is missing.'
}

$heroJs = Get-Content -Raw $heroJsPath

foreach ($needle in 'prefers-reduced-motion: reduce', 'pointermove', 'data-grade-option', 'aria-pressed', 'requestAnimationFrame') {
    if ($heroJs -notmatch [regex]::Escape($needle)) {
        throw "Hero JS missing expected interaction behavior: $needle"
    }
}

if ($functions -notmatch 'hero-confidence\.js' -or $functions -notmatch 'cove-hero-confidence') {
    throw 'functions.php must enqueue the hero confidence script.'
}

foreach ($selector in '.confidence-reveal__hotspot', '.confidence-reveal__lens', '.confidence-reveal__price-card', '.confidence-reveal__grades') {
    if ($style -notmatch [regex]::Escape($selector)) {
        throw "style.css missing hero selector $selector."
    }
}

foreach ($selector in '.cove-confidence-hero--full-bleed', '.confidence-reveal__copy-panel', '.cove-confidence-hero--full-bleed .cove-clarity-hero__visual') {
    if ($style -notmatch [regex]::Escape($selector)) {
        throw "style.css missing full-bleed hero selector $selector."
    }
}

if ($style -notmatch 'max-width:\s*none' -or $style -notmatch 'grid-area:\s*1\s*/\s*1') {
    throw 'Full-bleed hero should remove the container cap and layer copy over the visual surface.'
}

foreach ($needle in 'height: clamp(470px, 70svh, 788px)', 'max-height: 788px', 'min-height: 0', 'backdrop-filter: blur(34px) saturate(190%)') {
    if ($style -notmatch [regex]::Escape($needle)) {
        throw "Hero polish missing compressed/liquid glass rule: $needle"
    }
}

foreach ($needle in 'width: min(460px, 38%, calc(100% - clamp(1rem, 4vw, 4rem)))', 'max-height: calc(100% - clamp(1rem, 4vw, 4rem))', 'box-sizing: border-box') {
    if ($style -notmatch [regex]::Escape($needle)) {
        throw "Hero copy panel must be proportionally bound to the image stage: $needle"
    }
}

foreach ($needle in 'backdrop-filter: blur(34px) saturate(190%)', 'linear-gradient(115deg, rgba(254, 255, 254, 0.62)', '.confidence-reveal__copy-panel::after', 'animation: heroGlassDrift 7s ease-in-out infinite') {
    if ($style -notmatch [regex]::Escape($needle)) {
        throw "Hero copy panel missing stronger liquid glass treatment: $needle"
    }
}

foreach ($needle in 'cursor: none', 'width: clamp(34px, 3.6vw, 46px)', 'height: clamp(34px, 3.6vw, 46px)', 'border-radius: 50%', '.confidence-reveal__lens::before', '.confidence-reveal__lens::after', 'animation: lensLiquidWave 3.8s ease-in-out infinite', 'animation: lensHandleDrift 3.8s ease-in-out infinite', '.confidence-reveal__lens span', 'display: none') {
    if ($style -notmatch [regex]::Escape($needle)) {
        throw "Inspection lens must behave like a small liquid cursor: $needle"
    }
}

foreach ($needle in '--cursor-default:', '--cursor-pointer:', '--cursor-text:', '--cursor-grab:', '--cursor-grabbing:', '--cursor-disabled:', '--cursor-inspect:', 'body { cursor: var(--cursor-default); }', 'cursor: var(--cursor-pointer)', 'cursor: var(--cursor-text)', 'cursor: var(--cursor-grab)', 'cursor: var(--cursor-grabbing)', 'cursor: var(--cursor-disabled)') {
    if ($style -notmatch [regex]::Escape($needle)) {
        throw "COVE custom cursor system missing state: $needle"
    }
}

foreach ($needle in '.confidence-reveal__hotspot span', 'opacity: 0', '.confidence-reveal__note {', 'left: var(--note-x, 58%)', 'top: var(--note-y, 42%)', '.confidence-reveal__grades {', '.confidence-reveal__hotspot.is-invite', 'animation: nodeInvitePulse 3.6s ease-in-out infinite', '.confidence-reveal__mobile-facts') {
    if ($style -notmatch [regex]::Escape($needle)) {
        throw "Hero polish missing non-overlap rule: $needle"
    }
}

foreach ($needle in 'function setNotePosition', '--note-x', '--note-y', 'event.clientX', 'hotspot.getBoundingClientRect') {
    if ($heroJs -notmatch [regex]::Escape($needle)) {
        throw "Hero JS missing cursor-adjacent inspection note behavior: $needle"
    }
}

if ($style -notmatch '@media \(prefers-reduced-motion:\s*reduce\)' -or $style -notmatch '@media \(max-width:\s*640px\)') {
    throw 'Hero confidence reveal needs reduced-motion and mobile CSS handling.'
}

Write-Host 'COVE hero confidence reveal regression passed.'
