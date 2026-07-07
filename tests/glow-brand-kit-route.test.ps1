$ErrorActionPreference = 'Stop'

$functionsPath = Join-Path $PSScriptRoot '..\glow-theme\functions.php'
$brandKitPath = Join-Path $PSScriptRoot '..\glow-theme\page-brand-kit.php'

$functions = Get-Content -Raw $functionsPath
$brandKit = Get-Content -Raw $brandKitPath

if ($brandKit -notmatch 'served at /brand-kit') {
    throw 'Brand kit template must document the /brand-kit route.'
}

if ($functions -notmatch "'brand-kit'\s*=>\s*'Brand Kit'") {
    throw 'Theme must create or verify a WordPress page with slug brand-kit.'
}

if ($functions -notmatch "add_action\(\s*'admin_init'\s*,\s*'glow_ensure_theme_pages'\s*\)") {
    throw 'Brand kit page must be ensured on admin_init so already-active installs do not keep returning 404.'
}

if ($functions -notmatch "add_action\(\s*'after_switch_theme'\s*,\s*'glow_ensure_theme_pages'\s*\)") {
    throw 'Brand kit page must still be ensured when the theme is activated.'
}
