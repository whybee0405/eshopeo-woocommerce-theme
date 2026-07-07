$ErrorActionPreference = 'Stop'

$cardPath = Join-Path $PSScriptRoot '..\glow-theme\woocommerce\content-product.php'
$cssPath = Join-Path $PSScriptRoot '..\glow-theme\css\woocommerce.css'
$archivePath = Join-Path $PSScriptRoot '..\glow-theme\archive-product.php'

$card = Get-Content -Raw $cardPath
$css = Get-Content -Raw $cssPath
$archive = Get-Content -Raw $archivePath

if ($card -notmatch 'card-skin-fit') {
    throw 'Product cards should expose skin-fit metadata for clearer Korean skincare selection.'
}

if ($card -notmatch 'Add to cart') {
    throw 'Product card CTA should use standard Add to cart language.'
}

if ($card -match 'Add to routine') {
    throw 'Product card CTA should not use Add to routine language.'
}

if ($css -notmatch 'product-card-shell') {
    throw 'Product cards should use a light shell for the v2 card treatment.'
}

if ($css -notmatch 'transform:\s*translateY\(0\)') {
    throw 'Quick add should be visible by default, not hidden behind a hover-only reveal.'
}

if ($css -match 'rotate\(-1\.5deg\)') {
    throw 'Product image hover should not keep the old playful rotation.'
}

if ($archive -notmatch 'Modern Korean skincare') {
    throw 'Shop archive intro should use v2 Korean skincare positioning.'
}
