$ErrorActionPreference = 'Stop'

$guidelinesPath = Join-Path $PSScriptRoot '..\glow-theme\BRAND_GUIDELINES.md'
$brandKitPath = Join-Path $PSScriptRoot '..\glow-theme\page-brand-kit.php'

$guidelines = Get-Content -Raw $guidelinesPath
$brandKit = Get-Content -Raw $brandKitPath

foreach ($content in @($guidelines, $brandKit)) {
    if ($content -notmatch 'Premium Korean skincare') {
        throw 'Brand materials must lead with Premium Korean skincare.'
    }

    if ($content -notmatch 'Modern Korean Beauty') {
        throw 'Brand materials must include the v2 Modern Korean Beauty direction.'
    }

    if ($content -match 'ritual as architecture|Ritual as architecture|Core idea: ritual') {
        throw 'Brand materials must not keep the v1 ritual-as-architecture positioning.'
    }

    if ($content -match 'moss.*Brand anchor|Botanically grounded|mossy forests') {
        throw 'Brand materials must not keep moss/botanical cues as the dominant identity.'
    }
}
