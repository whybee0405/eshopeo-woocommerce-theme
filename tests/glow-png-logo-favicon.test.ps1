$ErrorActionPreference = 'Stop'

$functionsPath = Join-Path $PSScriptRoot '..\glow-theme\functions.php'
$headerPath = Join-Path $PSScriptRoot '..\glow-theme\header.php'
$cssPath = Join-Path $PSScriptRoot '..\glow-theme\style.css'
$seoPath = Join-Path $PSScriptRoot '..\glow-theme\inc\seo.php'
$guidelinesPath = Join-Path $PSScriptRoot '..\glow-theme\BRAND_GUIDELINES.md'

$logoPath = Join-Path $PSScriptRoot '..\glow-theme\images\Glow K-Beauty - Logo.png'
$faviconPath = Join-Path $PSScriptRoot '..\glow-theme\images\Glow K-Beauty - Favicon.png'

foreach ($asset in @($logoPath, $faviconPath)) {
    if (-not (Test-Path $asset)) {
        throw "Expected brand asset missing: $asset"
    }
}

$functions = Get-Content -Raw $functionsPath
$header = Get-Content -Raw $headerPath
$css = Get-Content -Raw $cssPath
$seo = Get-Content -Raw $seoPath
$guidelines = Get-Content -Raw $guidelinesPath

if ($functions -notmatch 'Glow K-Beauty - Logo\.png' -or $functions -notmatch 'Glow K-Beauty - Favicon\.png') {
    throw 'Theme helpers should reference the new PNG logo and favicon assets.'
}

if ($functions -match '<svg[^>]+viewBox="-2 -2 118 42"' -or $functions -match '/images/favicon\.svg') {
    throw 'Inline vector logo and SVG favicon fallback should not be used for brand assets.'
}

if ($functions -notmatch '<img class="brand-logo"' -or $functions -notmatch 'glow_logo_url\(\)' -or $functions -notmatch 'width="354"' -or $functions -notmatch 'height="126"') {
    throw 'Fallback brand logo should render the new PNG as an image with intrinsic dimensions.'
}

if ($header -match 'the_custom_logo|has_custom_logo') {
    throw 'Header should use the bundled PNG logo helper instead of a potentially stale custom logo override.'
}

if ($css -notmatch '\.brand-logo\s*\{' -or $css -match '\.brand svg') {
    throw 'Brand CSS should size the PNG logo, not the old inline SVG.'
}

if ($seo -notmatch 'glow_logo_url\(\)' -or $seo -match "return get_template_directory_uri\(\) \. '/screenshot\.png'") {
    throw 'SEO image fallback should use the PNG logo asset.'
}

if ($guidelines -notmatch 'Glow K-Beauty - Logo\.png' -or $guidelines -notmatch 'Glow K-Beauty - Favicon\.png') {
    throw 'Brand guidelines should document the current PNG logo and favicon files.'
}
