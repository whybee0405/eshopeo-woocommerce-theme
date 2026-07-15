$ErrorActionPreference = 'Stop'

$root = Join-Path $PSScriptRoot '..'
$theme = Join-Path $root 'cove-theme'

function Read-ThemeFile($relative) {
    Get-Content -Raw (Join-Path $theme $relative)
}

$front = Read-ThemeFile 'front-page.php'
$style = Read-ThemeFile 'style.css'
$functions = Read-ThemeFile 'functions.php'
$card = Read-ThemeFile 'woocommerce/content-product.php'

foreach ($asset in 'cove-hero-showroom-photo.png', 'cove-category-showroom-photo.png', 'cove-grade-inspection-photo.png') {
    $assetPath = Join-Path $theme ("images\brand\$asset")
    if (-not (Test-Path $assetPath)) {
        throw "Missing generated photographic asset $asset."
    }
    if ($front -notmatch [regex]::Escape($asset)) {
        throw "Homepage must reference photographic asset $asset."
    }
}

if ($front -match 'cove-hero-clarity-portal\.png|cove-category-showroom\.png|cove-grade-trust-system\.png|cove-product-card-pdp-system\.png') {
    throw 'Homepage should not use screenshot-like UI mockup imagery.'
}

if ($functions -match 'Roboto\+Mono') {
    throw 'Runtime fonts should no longer enqueue Roboto Mono.'
}

if ($style -match '--font-mono:\s*"Sohne Mono"|"Roboto Mono"|Geist Mono') {
    throw 'The old mono/data font stack should be removed from the design system.'
}

if ($style -notmatch '--font-data:\s*"Manrope"') {
    throw 'A softer premium data font should be defined for prices and specs.'
}

if ($style -notmatch 'font-size:\s*clamp\(2\.45rem,\s*5\.4vw,\s*5\.35rem\)') {
    throw 'Hero H1 scale must be reduced from the oversized previous setting.'
}

if ($style -notmatch 'min-height:\s*clamp\(560px,\s*74svh,\s*760px\)') {
    throw 'Hero height must be capped so the first section is not too tall.'
}

if ($style -notmatch '@media \(max-width:\s*640px\)' -or $style -notmatch 'font-size:\s*clamp\(2\.25rem,\s*11vw,\s*3\.15rem\)') {
    throw 'Mobile hero typography must be explicitly scaled down.'
}

if ($style -notmatch '\.product-card__current[^{]*\{[^}]*font-family:\s*var\(--font-data\)' -and $style -notmatch 'font-family:\s*var\(--font-data\)[^}]*\.product-card__current') {
    throw 'Product card price must use the new premium data font.'
}

if ($card -notmatch 'cove-product-proof-photo\.png') {
    throw 'Product card fallback image should use the photographic product proof asset.'
}

Write-Host 'COVE mobile imagery typography regression passed.'
