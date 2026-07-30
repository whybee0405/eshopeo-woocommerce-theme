"""
Turn the source photography into the web asset set.

Run from this directory:  python build-images.py

Sources live in ./source and are never shipped. Everything the theme
references is written next to this script as WebP at two widths, so the
templates can hand the browser a real srcset.
"""

import os
from PIL import Image, ImageOps

HERE = os.path.dirname(os.path.abspath(__file__))
SRC = os.path.join(HERE, "source")

# Some frames need a specific region rather than a centre crop: the KMS boards
# sit left of centre on the street shot, and the parts on the counter shot sit
# low and left of the figure. Boxes are (left, top, right, bottom) in source px.
BOXES = {
    "street": (30, 170, 1010, 721),      # both yellow boards, filling the frame
    "counter-hands": (90, 250, 2190, 1650),  # filters, plugs and the pump in hand
    # Phone crop of the hero: pull in on the parts so they still read at
    # 360px wide, where the full 21:9 frame would leave them tiny.
    "hero-portrait": (1500, 0, 3168, 1344),
}

# name, source file, crop aspect (w/h) or None to keep, output widths
JOBS = [
    # The hero frame is shot with its subject in the right third and the left
    # two thirds empty, so the headline can sit in the picture on desktop.
    ("hero",          "hero-wide.png",       21 / 9,  [1400, 2800]),
    ("hero-portrait", "hero-wide.png",       16 / 10, [800, 1600]),
    ("alternator",    "hero-alternator.png", 4 / 5,   [700, 1400]),
    ("hero-counter",  "gen-counter.png",   16 / 9,  [1000, 2000]),
    ("storeroom",     "gen-storeroom.png", 21 / 9,  [1200, 2400]),
    ("counter-hands", "gen-hands.png",     3 / 2,   [800, 1600]),
    ("shopfront",     "kempton.webp",      3 / 4,   [600, 1200]),
    ("street",        "storefront2.jpg",   16 / 9,  [800, 1600]),
    ("cat-engine",       "cat-Engine-parts.webp",      4 / 3, [420, 840]),
    ("cat-brakes",       "cat-Brake-Parts.webp",       4 / 3, [420, 840]),
    ("cat-suspension",   "cat-Suspension.webp",        4 / 3, [420, 840]),
    ("cat-service-kits", "cat-Service-Kit.webp",       4 / 3, [420, 840]),
    ("cat-electrical",   "cat-Electrical-Parts.webp",  4 / 3, [420, 840]),
    ("cat-transmission", "cat-Transmission-Part.webp", 4 / 3, [420, 840]),
    ("cat-body",         "cat-Body-Part.webp",         4 / 3, [420, 840]),
]


def crop_to(im, aspect):
    """Centre-crop to an exact aspect ratio without distorting."""
    w, h = im.size
    target = aspect
    current = w / h
    if abs(current - target) < 0.001:
        return im
    if current > target:
        new_w = int(round(h * target))
        left = (w - new_w) // 2
        return im.crop((left, 0, left + new_w, h))
    new_h = int(round(w / target))
    top = (h - new_h) // 2
    return im.crop((0, top, w, top + new_h))


def main():
    for name, src, aspect, widths in JOBS:
        path = os.path.join(SRC, src)
        if not os.path.exists(path):
            print(f"  skip {name}: missing {src}")
            continue

        im = Image.open(path)
        im = ImageOps.exif_transpose(im).convert("RGB")

        if name in BOXES:
            im = im.crop(BOXES[name])

        if aspect:
            im = crop_to(im, aspect)

        for w in widths:
            if w > im.width:
                out = im.copy()
            else:
                h = int(round(w * im.height / im.width))
                out = im.resize((w, h), Image.LANCZOS)

            suffix = "" if w == widths[0] else f"@{w}"
            fname = f"{name}{suffix}.webp"
            out.save(
                os.path.join(HERE, fname),
                "WEBP",
                quality=82,
                method=6,
            )
            print(f"  {fname}  {out.width}x{out.height}  "
                  f"{os.path.getsize(os.path.join(HERE, fname)) // 1024}KB")

    # Logos keep their transparency, so they stay PNG.
    for out_name, src, width in [
        ("kms-logo.png", "kms-wordmark-full.png", 499),
        ("kms-badge.png", "kms-logo-badge.png", 256),
    ]:
        path = os.path.join(SRC, src)
        if not os.path.exists(path):
            continue
        im = Image.open(path).convert("RGBA")
        if width < im.width:
            h = int(round(width * im.height / im.width))
            im = im.resize((width, h), Image.LANCZOS)
        im.save(os.path.join(HERE, out_name), "PNG", optimize=True)
        print(f"  {out_name}  {im.width}x{im.height}")


if __name__ == "__main__":
    main()
