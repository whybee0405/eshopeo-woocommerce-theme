$ErrorActionPreference = 'Stop'

$mainPath = Join-Path $PSScriptRoot '..\glow-theme\js\main.js'
$cardPath = Join-Path $PSScriptRoot '..\glow-theme\woocommerce\content-product.php'
$cssPath = Join-Path $PSScriptRoot '..\glow-theme\css\woocommerce.css'
$stylePath = Join-Path $PSScriptRoot '..\glow-theme\style.css'
$functionsPath = Join-Path $PSScriptRoot '..\glow-theme\functions.php'

$main = Get-Content -Raw $mainPath
$card = Get-Content -Raw $cardPath
$css = Get-Content -Raw $cssPath
$style = Get-Content -Raw $stylePath
$functions = Get-Content -Raw $functionsPath

if ($main -notmatch "menu\.addEventListener\('click'[\s\S]+closest\('a'\)[\s\S]+closeMenu\(\)") {
    throw 'Mobile menu links should close the open menu immediately when tapped.'
}

$mobileMenuBlock = [regex]::Match($style, '(?m)^\.mobile-menu\s*\{[\s\S]*?\n\}')
$menuOpenBlock = [regex]::Match($style, 'body\.menu-open\s*\{[\s\S]*?\n\}')
if (-not $mobileMenuBlock.Success -or $mobileMenuBlock.Value -notmatch 'height:\s*100dvh' -or $mobileMenuBlock.Value -notmatch 'overflow-y:\s*auto' -or $mobileMenuBlock.Value -notmatch '-webkit-overflow-scrolling:\s*touch' -or $mobileMenuBlock.Value -notmatch 'overscroll-behavior:\s*contain' -or -not $menuOpenBlock.Success -or $menuOpenBlock.Value -notmatch 'position:\s*fixed' -or $menuOpenBlock.Value -notmatch 'width:\s*100%' -or $menuOpenBlock.Value -notmatch 'touch-action:\s*none') {
    throw 'Mobile menu must be its own scroll container and prevent background page scrolling.'
}

if ($card -notmatch "esc_html_e\(\s*'Add to cart'") {
    throw 'Product card quick-add CTA should say Add to cart.'
}

if ($card -match 'Add to routine') {
    throw 'Product card quick-add CTA should not use Add to routine.'
}

$quickAddBlock = [regex]::Match($card, '<button class="quick-add"[\s\S]+?</button>')
if (-not $quickAddBlock.Success) {
    throw 'Product card should keep a quick-add button for purchasable products.'
}

if ($quickAddBlock.Value -match 'get_price_html|card-price|class="mono"') {
    throw 'Product card quick-add CTA should not repeat the product price.'
}

if ($functions -notmatch "return __\(\s*'Add to cart'") {
    throw 'PDP add-to-cart wording helper should return Add to cart.'
}

if ($card -match 'foreach\s*\(\s*array\(\s*\$glow_skin\s*,\s*\$glow_actives\s*\)' -or $card -match '\$glow_extra_chip_count' -or $card -match 'card-chip-more') {
    throw 'Product card metadata should not mix key ingredient chips into the compact listing card.'
}

if ($card -notmatch 'preg_split\(\s*''/\[,\\|\]\+/''\s*,\s*wp_strip_all_tags\(\s*\$glow_skin\s*\)' -or $card -notmatch 'Product skin types') {
    throw 'Product card metadata should render skin type chips only.'
}

if ($css -notmatch '\.card-skin-fit\s*\{[\s\S]+max-height:' -or $css -notmatch '\.card-skin-fit span\s*\{[\s\S]+text-overflow:\s*ellipsis') {
    throw 'Product card metadata chips should be height bounded and truncate long chip text.'
}

if ($css -match '@media \(max-width:\s*640px\)[\s\S]*?\.card-title\s*\{[\s\S]*?-webkit-line-clamp:\s*2') {
    throw 'Mobile product card titles should show the full product name instead of truncating with ellipsis.'
}

if ($css -notmatch '@media \(max-width:\s*480px\)[\s\S]+\.quick-add\s*\{[\s\S]+justify-content:\s*center') {
    throw 'Mobile quick-add buttons should use centered compact copy without stretching around removed price.'
}
