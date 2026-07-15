$Root = Split-Path -Parent $PSScriptRoot
$Theme = Join-Path $Root 'cove-theme'

function Read-ThemeFile($relative) {
  Get-Content -Raw (Join-Path $Theme $relative)
}

$front = Read-ThemeFile 'front-page.php'
$style = Read-ThemeFile 'style.css'
$functions = Read-ThemeFile 'functions.php'
$header = Read-ThemeFile 'header.php'
$card = Read-ThemeFile 'woocommerce/content-product.php'
$single = Read-ThemeFile 'single-product.php'
$cursor = Read-ThemeFile 'js/cove-cursor.js'
$dummy = Read-ThemeFile 'dummy-products.php'
$main = Read-ThemeFile 'js/main.js'
$promotionsPage = Read-ThemeFile 'page-promotions.php'
$buyingGuidePage = Read-ThemeFile 'page-buying-guide.php'
$rewardsPage = Read-ThemeFile 'page-rewards.php'

if ($front -notmatch 'cove-hero-showroom-photo\.png') { throw 'Homepage must use the generated photographic hero asset.' }
if ($front -notmatch 'Premium appliances, clearly graded\.') { throw 'Homepage must use the confidence reveal hero headline.' }
if ($front -notmatch 'cove-category-showroom-photo\.png') { throw 'Homepage must use the generated photographic category showroom asset.' }
if ($front -notmatch 'cove-grade-inspection-photo\.png') { throw 'Homepage must use the generated photographic grade inspection asset.' }
if ($front -match 'cove-product-proof-photo\.png') { throw 'Homepage should not keep the removed product clarity image section.' }

$smartValueIndex = $front.IndexOf('Best value drops')
$newArrivalsIndex = $front.IndexOf('Latest inspected stock')
$aftercareIndex = $front.IndexOf('What happens after checkout?')
$trustRibbonIndex = $front.IndexOf('cove-trust-ribbon')

if ($front -match 'Product clarity' -or $front -match 'Every card answers the buying questions first\.') {
  throw 'Homepage should not include the Product clarity section.'
}

if ($smartValueIndex -lt 0 -or $newArrivalsIndex -lt 0 -or $aftercareIndex -lt 0) {
  throw 'Homepage must include best value drops, latest inspected stock, and aftercare reassurance.'
}

if (-not ($smartValueIndex -lt $newArrivalsIndex -and $newArrivalsIndex -lt $aftercareIndex)) {
  throw 'Homepage customer journey should show best value drops, then latest inspected stock, then aftercare reassurance.'
}

if (-not ($smartValueIndex -gt 0 -and $trustRibbonIndex -gt 0 -and $smartValueIndex -lt $trustRibbonIndex)) {
  throw 'Best value drops should appear immediately after the hero, before the trust ribbon.'
}

foreach ($needle in 'Choose your comfort level', 'What happens after checkout?', 'Delivery arranged', 'Warranty path clear', 'Inspection record kept') {
  if ($front -notmatch [regex]::Escape($needle)) { throw "Homepage customer journey missing reassurance hook: $needle." }
}

foreach ($needle in 'cove-home-search', 'Find your appliance', 'Search by brand, model, category or grade', 'name="post_type" value="product"') {
  if ($front -notmatch [regex]::Escape($needle)) { throw "Homepage search strip missing: $needle." }
}

if (-not ($front.IndexOf('cove-trust-ribbon') -lt $front.IndexOf('cove-home-search') -and $front.IndexOf('cove-home-search') -lt $front.IndexOf('cove-category-showroom'))) {
  throw 'Homepage search strip should sit after trust ribbon and before category routing.'
}

foreach ($token in '--porcelain', '--liquid-blue', '--cove-blue', '--glass-silver', '--deep-navy') {
  if ($style -notmatch [regex]::Escape($token)) { throw "Missing brand token $token in style.css." }
}

if ($functions -notmatch 'Inter\+Tight:wght@400;500;600;700' -or $functions -notmatch 'Manrope:wght@400;500;600;700;800') {
  throw 'functions.php must enqueue the brand kit font families.'
}

foreach ($label in 'Shop', 'Promotions', 'Contact Us', 'About Us', 'Buying Guide', 'Rewards') {
  if ($header -notmatch [regex]::Escape($label)) { throw "Header navigation missing $label." }
}

foreach ($needle in 'primary-nav__item', 'primary-nav__trigger', 'primary-nav__dropdown', 'primary-nav__dropdown-title', 'mobile-nav__group', 'mobile-nav__submenu') {
  if ($header -notmatch [regex]::Escape($needle)) { throw "Header nav needs hover/focus dropdown structure: $needle." }
}

foreach ($needle in 'get_terms', "'taxonomy' => 'product_cat'", '$shop_categories', 'hide_empty') {
  if ($header -notmatch [regex]::Escape($needle)) { throw "Shop dropdown must load backend product categories dynamically: $needle." }
}

foreach ($needle in 'promotions', 'contact', 'about', 'buying-guide', 'rewards') {
  if ($functions -notmatch [regex]::Escape($needle)) { throw "Theme activation should create dummy nav page: $needle." }
}

foreach ($needle in 'COVE Promotions', 'Best value drops') {
  if ($promotionsPage -notmatch [regex]::Escape($needle)) { throw "Promotions dummy page missing $needle." }
}

foreach ($needle in 'COVE Buying Guide', 'Choose the right grade') {
  if ($buyingGuidePage -notmatch [regex]::Escape($needle)) { throw "Buying guide dummy page missing $needle." }
}

foreach ($needle in 'COVE Rewards', 'Coming soon') {
  if ($rewardsPage -notmatch [regex]::Escape($needle)) { throw "Rewards dummy page missing $needle." }
}

foreach ($needle in '.primary-nav__item:hover .primary-nav__dropdown', '.primary-nav__item:focus-within .primary-nav__dropdown', '.primary-nav__dropdown', '.mobile-nav__submenu') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "Header dropdown styling missing: $needle." }
}

foreach ($needle in '.primary-nav__item::after', 'top: 100%', 'height: 0.9rem', '.primary-nav__trigger svg', 'position: absolute', 'padding-right: 1.65rem') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "Header dropdown hover bridge or chevron normalization missing: $needle." }
}

foreach ($needle in 'data-search-toggle', 'data-search-overlay', 'data-search-close', 'data-search-input', 'name="post_type" value="product"', 'Search fridges, washing machines, A Grade Bosch') {
  if ($header -notmatch [regex]::Escape($needle)) { throw "Header search overlay missing: $needle." }
}

foreach ($needle in 'openSearch', 'closeSearch', '[data-search-overlay]', '[data-search-input]', 'Escape') {
  if ($main -notmatch [regex]::Escape($needle)) { throw "Main JS missing search overlay behavior: $needle." }
}

foreach ($needle in '.search-overlay', '.search-overlay.is-open', '.cove-home-search', '.cove-home-search__form', '.search-quick-links') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "Search UI styling missing: $needle." }
}

foreach ($needle in 'product-card__model', 'product-card__category', 'Delivery', 'Inspection') {
  if ($card -notmatch [regex]::Escape($needle)) { throw "Product card missing $needle." }
}

foreach ($needle in 'badge-sale', 'esc_html_e( ''Sale'', ''cove'' )', '$display_price', 'wc_get_price_to_display', 'product-card__current') {
  if ($card -notmatch [regex]::Escape($needle)) { throw "Product card sale pricing missing: $needle." }
}

if ($card -match 'get_price_html\(\)') {
  throw 'Product card must not use get_price_html(), because WooCommerce sale HTML duplicates the original price.'
}

foreach ($needle in '.product-card__badges .badge-sale', 'Save now') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "Product card sale badge styling missing: $needle." }
}

foreach ($needle in '.product-card__price .product-card__saving-badge', 'position: static', 'align-self: center') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "Product card saving badge should stay inside its card price row: $needle." }
}

foreach ($needle in 'cove_product_fallback_image_url', 'images/fallback/', 'appliance-microwave.png', 'appliance-washing-machine.png', 'appliance-dishwasher.png', 'appliance-refrigerator.png', 'appliance-vacuum.png', 'appliance-air-conditioner.png') {
  if ($functions -notmatch [regex]::Escape($needle)) { throw "Product fallback imagery missing appliance mapping: $needle." }
}

if ($functions -match 'images\.pexels\.com') {
  throw 'Product fallback imagery must use controlled local COVE assets, not remote stock-photo URLs.'
}

if ($dummy -match 'images\.pexels\.com') {
  throw 'Dummy products must use controlled local COVE assets, not remote stock-photo URLs.'
}

if ($card -notmatch 'cove_product_fallback_image_url\s*\(') {
  throw 'Product card fallback image should use the appliance-aware helper.'
}

foreach ($needle in 'cove_product_has_demo_thumbnail', 'pexels-photo') {
  if ($functions -notmatch [regex]::Escape($needle)) { throw "Product cards must ignore old imported demo stock thumbnails: $needle." }
}

foreach ($asset in 'appliance-microwave.png', 'appliance-washing-machine.png', 'appliance-dishwasher.png', 'appliance-refrigerator.png', 'appliance-vacuum.png', 'appliance-air-conditioner.png', 'appliance-coffee-machine.png', 'appliance-kettle.png', 'appliance-air-fryer.png', 'appliance-mixer.png', 'appliance-blender.png', 'appliance-fan.png', 'appliance-personal-care.png', 'appliance-small.png') {
  if (-not (Test-Path (Join-Path $Theme "images/fallback/$asset"))) { throw "Missing local appliance fallback asset $asset." }
}

foreach ($needle in 'cove-cursor', 'js/cove-cursor.js') {
  if ($functions -notmatch [regex]::Escape($needle)) { throw "Animated cursor must be enqueued: $needle." }
}

foreach ($needle in 'requestAnimationFrame', 'cove-cursor__trail', 'data-cursor-state', 'prefers-reduced-motion: reduce', 'pointer: coarse', 'is-inspect', 'interactiveSelector') {
  if ($cursor -notmatch [regex]::Escape($needle)) { throw "Animated cursor behavior missing: $needle." }
}

foreach ($needle in '.product-card__badges .badge', 'backdrop-filter: blur(16px) saturate(170%)', 'background: linear-gradient(135deg, rgba(254, 255, 254, 0.82)', 'box-shadow:') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "Product condition chip should be liquid-glass and legible: $needle." }
}

foreach ($needle in 'Grade clarity', 'Condition verified', 'Simple delivery') {
  if ($single -notmatch [regex]::Escape($needle)) { throw "PDP missing $needle." }
}

Write-Host 'COVE brand kit overhaul contract passed.'
