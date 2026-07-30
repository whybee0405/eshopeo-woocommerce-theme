#!/usr/bin/env bash
#
# Package the theme for upload to WordPress.
#
#   bash build/package.sh
#
# Writes dist/kms-branch-theme.zip containing only what the running site
# needs: no preview harness, no source photography, no build scripts.

set -euo pipefail

THEME="kms-branch-theme"
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST="$ROOT/dist"
STAGE="$DIST/$THEME"

rm -rf "$STAGE" "$DIST/$THEME.zip"
mkdir -p "$STAGE"

# Rebuild images first so the package can never ship a stale crop.
if command -v python >/dev/null 2>&1; then
	( cd "$ROOT/assets/img" && python build-images.py >/dev/null )
	echo "images rebuilt"
elif command -v python3 >/dev/null 2>&1; then
	( cd "$ROOT/assets/img" && python3 build-images.py >/dev/null )
	echo "images rebuilt"
else
	echo "python not found, shipping existing images" >&2
fi

copy() {
	if [ -e "$ROOT/$1" ]; then
		mkdir -p "$STAGE/$(dirname "$1")"
		cp -r "$ROOT/$1" "$STAGE/$1"
	fi
}

for item in \
	style.css functions.php index.php page.php 404.php \
	header.php footer.php front-page.php \
	page-lenasia.php page-vereeniging.php \
	screenshot.png \
	inc template-parts \
	assets/css assets/js assets/fonts
do
	copy "$item"
done

# Images, minus the originals and the build script.
mkdir -p "$STAGE/assets/img"
find "$ROOT/assets/img" -maxdepth 1 -type f \( -name '*.webp' -o -name '*.png' \) \
	-exec cp {} "$STAGE/assets/img/" \;

# zip(1) is not present on a stock Windows Git Bash, so fall back to Python's
# zipfile, which is already a dependency of the image build above.
if command -v zip >/dev/null 2>&1; then
	( cd "$DIST" && zip -qr "$THEME.zip" "$THEME" )
else
	PY=$(command -v python || command -v python3)
	"$PY" - "$DIST" "$THEME" <<'PY'
import os, sys, zipfile
dist, theme = sys.argv[1], sys.argv[2]
root = os.path.join(dist, theme)
with zipfile.ZipFile(os.path.join(dist, theme + '.zip'), 'w', zipfile.ZIP_DEFLATED) as z:
    for base, _, files in os.walk(root):
        for f in files:
            full = os.path.join(base, f)
            z.write(full, os.path.join(theme, os.path.relpath(full, root)).replace('\\', '/'))
PY
fi

rm -rf "$STAGE"

echo "built $DIST/$THEME.zip ($(du -h "$DIST/$THEME.zip" | cut -f1))"
