$ErrorActionPreference = 'Stop'

$themePath = Join-Path $PSScriptRoot '..\glow-theme'
$headerPath = Join-Path $themePath 'header.php'
$functionsPath = Join-Path $themePath 'functions.php'
$stylePath = Join-Path $themePath 'style.css'
$seoPath = Join-Path $themePath 'inc\seo.php'
$loyaltyTemplatePath = Join-Path $themePath 'page-loyalty-program.php'

$header = Get-Content -Raw $headerPath
$functions = Get-Content -Raw $functionsPath
$style = Get-Content -Raw $stylePath
$seo = Get-Content -Raw $seoPath

if ($header -notmatch 'notice-ticker') {
    throw 'Notice bar must render as an animated ticker.'
}

if (($header | Select-String -Pattern 'notice-ticker-track' -AllMatches).Matches.Count -lt 2) {
    throw 'Notice ticker must duplicate the message track for seamless looping.'
}

if ($header -notmatch 'aria-hidden="true"') {
    throw 'Duplicated ticker content must be hidden from screen readers.'
}

if ($style -notmatch '@keyframes\s+glow-notice-ticker') {
    throw 'Notice ticker must define a keyframe animation.'
}

if ($style -notmatch '\.notice-ticker-inner\s*\{[\s\S]*?width:\s*200%' -or $style -notmatch '\.notice-ticker-track\s*\{[\s\S]*?flex:\s*0 0 50%' -or $style -notmatch '\.notice-ticker-track\s*\{[\s\S]*?justify-content:\s*space-around') {
    throw 'Notice ticker tracks must each span the viewport and distribute items evenly.'
}

if ($style -notmatch '@media\s*\(max-width:\s*900px\)[\s\S]*?\.notice-ticker-inner\s*\{[\s\S]*?width:\s*max-content[\s\S]*?animation:\s*glow-notice-ticker-mobile' -or $style -notmatch '@media\s*\(max-width:\s*900px\)[\s\S]*?\.notice-ticker-track\s*\{[\s\S]*?flex:\s*0 0 auto[\s\S]*?justify-content:\s*flex-start') {
    throw 'Notice ticker needs compact mobile marquee rules so it keeps moving and does not become thick.'
}

if ($style -notmatch '@keyframes\s+glow-notice-ticker-mobile') {
    throw 'Notice ticker must define a mobile marquee keyframe for content-width tracks.'
}

if ($style -notmatch '\.notice-ticker:hover\s+\.notice-ticker-inner\s*\{[\s\S]*?animation-play-state:\s*paused') {
    throw 'Notice ticker must pause on hover.'
}

if ($style -notmatch '@media\s*\(prefers-reduced-motion:\s*reduce\)[\s\S]*?\.notice-ticker-inner\s*\{[\s\S]*?animation:\s*none') {
    throw 'Notice ticker must stop animation for reduced-motion users.'
}

if (-not (Test-Path $loyaltyTemplatePath)) {
    throw 'Missing Loyalty Program page template.'
}

$loyaltyTemplate = Get-Content -Raw $loyaltyTemplatePath

foreach ($needle in @(
    'served at /loyalty-program',
    'Glow Rewards',
    'Earn points',
    'Redeem rewards',
    'wc_get_page_permalink( ''myaccount'' )',
    'glow_loyalty_points_for_user'
)) {
    if ($loyaltyTemplate -notmatch [regex]::Escape($needle)) {
        throw "Loyalty template missing expected WooCommerce-ready content: $needle"
    }
}

if ($header -notmatch "home_url\(\s*'/loyalty-program/'\s*\)") {
    throw 'Desktop and mobile navigation must link to /loyalty-program/.'
}

if ($functions -notmatch "'loyalty-program'\s*=>\s*'Loyalty Program'") {
    throw 'Theme must auto-create the Loyalty Program page.'
}

if ($functions -notmatch 'add_rewrite_endpoint\(\s*''glow-loyalty''') {
    throw 'WooCommerce My Account must register a Glow loyalty endpoint.'
}

if ($functions -notmatch 'glow_flush_rewrites_on_switch' -or $functions -notmatch 'flush_rewrite_rules\(\)') {
    throw 'Theme activation must flush rewrites so the Glow loyalty account endpoint resolves.'
}

foreach ($hook in @(
    'woocommerce_account_menu_items',
    'woocommerce_account_glow-loyalty_endpoint',
    'woocommerce_order_status_completed'
)) {
    if ($functions -notmatch [regex]::Escape($hook)) {
        throw "Loyalty program must integrate with WooCommerce hook: $hook"
    }
}

foreach ($needle in @(
    'glow_loyalty_points_for_user',
    'glow_loyalty_award_order_points',
    '_glow_loyalty_points',
    '_glow_loyalty_points_awarded',
    'Glow Rewards'
)) {
    if ($functions -notmatch [regex]::Escape($needle)) {
        throw "Missing loyalty implementation detail: $needle"
    }
}

if ($functions -notmatch "home_url\(\s*'/loyalty-program/'\s*\)") {
    throw 'Footer links must include the Loyalty Program page.'
}

if ($seo -notmatch "is_page_template\( 'page-loyalty-program.php' \)") {
    throw 'Loyalty Program page should have a dedicated meta description.'
}
