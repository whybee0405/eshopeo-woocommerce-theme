$ErrorActionPreference = 'Stop'

$themePath = Join-Path $PSScriptRoot '..\glow-theme'
$functionsPath = Join-Path $themePath 'functions.php'
$seoPath = Join-Path $themePath 'inc\seo.php'

$functions = Get-Content -Raw $functionsPath
$seo = Get-Content -Raw $seoPath

$pages = @(
    @{
        Slug = 'privacy-policy'
        Title = 'Privacy Policy'
        File = 'page-privacy-policy.php'
        MustContain = @('POPIA', 'Cookies', 'Your choices and rights')
    },
    @{
        Slug = 'refunds-policy'
        Title = 'Refunds Policy'
        File = 'page-refunds-policy.php'
        MustContain = @('7 days', '14 days', 'Damaged, defective or incorrect items')
    },
    @{
        Slug = 'terms-of-service'
        Title = 'Terms of Service'
        File = 'page-terms-of-service.php'
        MustContain = @('Skincare guidance is not medical advice', 'Orders and acceptance', 'Acceptable use')
    }
)

foreach ($page in $pages) {
    $templatePath = Join-Path $themePath $page.File
    if (-not (Test-Path $templatePath)) {
        throw "Missing policy template: $($page.File)"
    }

    $template = Get-Content -Raw $templatePath

    if ($template -notmatch [regex]::Escape("served at /$($page.Slug)")) {
        throw "$($page.File) must document the /$($page.Slug) route."
    }

    if ($functions -notmatch "'$($page.Slug)'\s*=>\s*'$($page.Title)'") {
        throw "Theme must ensure the $($page.Title) page exists."
    }

    if ($functions -notmatch "home_url\(\s*'/$($page.Slug)/'\s*\)") {
        throw "Footer must link to /$($page.Slug)/."
    }

    foreach ($needle in $page.MustContain) {
        if ($template -notmatch [regex]::Escape($needle)) {
            throw "$($page.File) is missing expected policy content: $needle"
        }
    }

    if ($seo -notmatch [regex]::Escape("is_page_template( '$($page.File)' )")) {
        throw "$($page.Title) should have a dedicated meta description."
    }
}

if ($functions -notmatch [regex]::Escape("__( 'Policies', 'glow-glow' )")) {
    throw 'Footer must include a Policies column.'
}
