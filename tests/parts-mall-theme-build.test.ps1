$Root = Split-Path -Parent $PSScriptRoot
$Theme = Join-Path $Root 'parts-mall-theme'

function Read-ThemeFile($relative) {
  Get-Content -Raw (Join-Path $Theme $relative)
}

$style = Read-ThemeFile 'style.css'
$functions = Read-ThemeFile 'functions.php'
$seo = Read-ThemeFile 'inc/seo.php'
$archive = Read-ThemeFile 'archive-product.php'
$single = Read-ThemeFile 'single-product.php'
$main = Read-ThemeFile 'js/main.js'
$search = Read-ThemeFile 'js/catalogue-search.js'

foreach ($file in 'single-branch.php') {
  if (-not (Test-Path (Join-Path $Theme $file))) { throw "Missing theme file: $file" }
}

$singleBranch = Read-ThemeFile 'single-branch.php'

foreach ($file in 'front-page.php','archive-product.php','single-product.php','page-branches.php','page-agent.php','page-about.php','page-contact.php','woocommerce/content-product.php','dummy-products.php','dummy-branches.php','README.md') {
  if (-not (Test-Path (Join-Path $Theme $file))) { throw "Missing theme file: $file" }
}

foreach ($token in '--color-blue-900: #0a1733','--brand-accent: var(--color-green-600);','Barlow Condensed','Archivo','JetBrains Mono') {
  if ($style -notmatch [regex]::Escape($token)) { throw "Missing design token or font: $token" }
}

foreach ($needle in 'function partsmall_category_groups(): array','function partsmall_makes(): array','function partsmall_private_brands(): array','function partsmall_meta( int $id, string $key )','function partsmall_branches(): array','function partsmall_part_badges( WC_Product $p ): array','partsmall_catalogue_search','partsmall_enquiry') {
  if ($functions -notmatch [regex]::Escape($needle)) { throw "functions.php missing: $needle" }
}

foreach ($needle in 'function partsmall_flatten_branches(): array','function partsmall_get_branch_by_slug( string $slug )','function partsmall_branch_url( array $branch ): string','partsmall_branch','partsmall_branch_template') {
  if ($functions -notmatch [regex]::Escape($needle)) { throw "functions.php missing dynamic branch support: $needle" }
}

foreach ($needle in 'PERSONA 1','FAQPage','SearchAction','AutoPartsStore') {
  if ($seo -notmatch [regex]::Escape($needle)) { throw "seo.php missing: $needle" }
}

foreach ($needle in 'data-filter-drawer','category[]','availability[]') {
  if ($archive -notmatch [regex]::Escape($needle)) { throw "archive-product.php missing: $needle" }
}

foreach ($needle in 'Enquire about this part','Ask about bulk / trade pricing','Warranty & quality') {
  if ($single -notmatch [regex]::Escape($needle)) { throw "single-product.php missing: $needle" }
}

foreach ($needle in 'data-branch-slug','data-branch-name','branch-gallery','Get directions','WhatsApp','Call branch','name="branch_slug"','name="branch_name"') {
  if ($singleBranch -notmatch [regex]::Escape($needle)) { throw "single-branch.php missing: $needle" }
}

foreach ($needle in 'data-enquiry-trigger','data-filter-open','partsmallToast') {
  if ($main -notmatch [regex]::Escape($needle)) { throw "main.js missing: $needle" }
}

foreach ($needle in 'branch-detail','branch-cta-grid','branch-gallery','branch-contact-layout') {
  if ($style -notmatch [regex]::Escape($needle)) { throw "style.css missing branch detail styles: $needle" }
}

foreach ($needle in 'partsmall_catalogue_search','data-search-input','cards_html') {
  if ($search -notmatch [regex]::Escape($needle)) { throw "catalogue-search.js missing: $needle" }
}

Write-Host 'Parts-Mall theme build contract passed.'
