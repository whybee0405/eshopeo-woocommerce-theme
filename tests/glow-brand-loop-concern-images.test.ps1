$ErrorActionPreference = 'Stop'

$frontPagePath = Join-Path $PSScriptRoot '..\glow-theme\front-page.php'
$stylePath = Join-Path $PSScriptRoot '..\glow-theme\style.css'
$brandDir = Join-Path $PSScriptRoot '..\glow-theme\images\product brands'

$frontPage = Get-Content -Raw $frontPagePath
$style = Get-Content -Raw $stylePath

foreach ($file in @(
    'anua.png',
    'banila co.png',
    'beauty of joseon.png',
    'cosrx.png',
    'etude.png',
    'innisfree.png',
    'klairs.png',
    'laneige.png',
    'mediheal.png',
    'missha.png',
    'round lab.png',
    'skin1004.png',
    'torriden.png'
)) {
    if (-not (Test-Path (Join-Path $brandDir $file))) {
        throw "Missing expected product brand logo file: $file"
    }

    if ($frontPage -notmatch [regex]::Escape("'file' => '$file'")) {
        throw "Brand loop should use product brand logo file: $file"
    }
}

if ($frontPage -match "Dr\.Jart\+|Sulwhasoo") {
    throw 'Brand loop should not render text-only brands that do not have matching PNG logo files.'
}

if ($frontPage -notmatch 'class="brand-loop-logo"' -or $frontPage -notmatch '--brand-logo:' -or $frontPage -notmatch 'images/product brands/') {
    throw 'Brand loop should render PNG logo masks from the product brands image folder.'
}

if ($style -notmatch '\.brand-loop-logo\s*\{[\s\S]*?background:\s*var\(--brand-loop-logo-color' -or $style -notmatch 'mask-image:\s*var\(--brand-logo\)' -or $style -notmatch '-webkit-mask-image:\s*var\(--brand-logo\)') {
    throw 'Brand loop logo CSS should force all PNG marks to a consistent grey via CSS masks.'
}

if ($frontPage -notmatch 'class="concern-image"' -or ($frontPage | Select-String -Pattern 'class="concern-image"' -AllMatches).Matches.Count -lt 4) {
    throw 'Each homepage concern row should include a square concern image.'
}

foreach ($image in @('product-step-05.jpg', 'product-step-02.jpg', 'product-step-03.jpg', 'product-step-04.jpg')) {
    if ($frontPage -notmatch [regex]::Escape("/images/products/$image")) {
        throw "Concern rows should use static theme image: $image"
    }
}

if ($style -notmatch '\.concern-image\s*\{[\s\S]*?aspect-ratio:\s*1 / 1' -or $style -notmatch '\.concern-image img\s*\{[\s\S]*?object-fit:\s*cover') {
    throw 'Concern image CSS should enforce square cropped image blocks.'
}

if ($style -notmatch '@media\s*\(max-width:\s*900px\)[\s\S]*?\.concern-row\s*\{[\s\S]*?grid-template-columns:\s*2\.8rem 84px minmax\(0,\s*1fr\) auto' -or $style -notmatch '@media\s*\(max-width:\s*640px\)[\s\S]*?\.concern-row\s*\{[\s\S]*?grid-template-columns:\s*2\.4rem 72px minmax\(0,\s*1fr\) auto') {
    throw 'Concern rows should keep the image column visible across mobile and tablet breakpoints.'
}
