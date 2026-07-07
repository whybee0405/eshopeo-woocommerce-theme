$ErrorActionPreference = 'Stop'

$templatePath = Join-Path $PSScriptRoot '..\glow-theme\single-product.php'
$cssPath = Join-Path $PSScriptRoot '..\glow-theme\css\woocommerce.css'
$functionsPath = Join-Path $PSScriptRoot '..\glow-theme\functions.php'

$template = Get-Content -Raw $templatePath
$css = Get-Content -Raw $cssPath
$functions = Get-Content -Raw $functionsPath

if ($template -notmatch 'pdp-clarity-strip') {
    throw 'PDP should include a v2 clarity strip before the buy panel.'
}

if ($template -notmatch 'Why this product') {
    throw 'PDP should frame the short description as Why this product.'
}

if ($template -notmatch 'Skin fit' -or $template -notmatch 'Key ingredients') {
    throw 'PDP should keep skin fit and key ingredients visible in the assessment area.'
}

if (($template + $functions) -notmatch 'Add to routine') {
    throw 'PDP add-to-cart button should be relabelled to Add to routine.'
}

if ($template -match 'Reacted to it\?') {
    throw 'PDP assurance copy should use calmer v2 support language.'
}

if ($css -notmatch 'pdp-clarity-strip') {
    throw 'PDP v2 clarity strip must be styled.'
}

if ($css -notmatch 'background:\s*color-mix\(in srgb, var\(--rice\)') {
    throw 'PDP panels should use light rice/ivory surfaces.'
}

$pdpPanelBlocks = [regex]::Matches($css, '\.pdp-(?:buy-panel|callout|clarity-item)\s*\{[^}]+\}')
foreach ($block in $pdpPanelBlocks) {
    if ($block.Value -match 'background:\s*#fff') {
        throw 'PDP panels should not use pure white backgrounds.'
    }
}
