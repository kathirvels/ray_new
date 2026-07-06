# Rayinfos Technologies — website (Astro rebuild)

Modern rebuild of the old PHP site in `../ray_old`, keeping the exact same theme,
pages, content, SEO meta tags and logo (logo upscaled to 2x for retina screens,
design unchanged).

## Requirements

- Node.js **20.3+** (the system Node 18.15 is too old for Astro 5 — install a
  current LTS, e.g. `brew install node`)

## Commands

| Command | Action |
| --- | --- |
| `npm install` | Install dependencies |
| `npm run dev` | Dev server at `http://localhost:4321` |
| `npm run build` | Build the static site into `dist/` |
| `npm run preview` | Serve the built `dist/` locally |

## Deployment

`npm run build`, then upload the contents of `dist/` to the web root of any
Apache/PHP host (same hosting as the old site works). Included in the output:

- `.htaccess` — 301-redirects the old `*.php` URLs to the new `*.html` pages
  (preserves search rankings) and wires up the 404 page.
- `js/owlmail.php` — the contact-form endpoint. Unlike the old site's stub,
  it now really emails the form to `info@rayinfos.com` via PHP `mail()`
  (requires PHP + a configured mailer on the host; it is skipped by the Astro
  dev/preview servers). The recipient is fixed server-side.
- `sitemap.xml` / `robots.txt` — updated to the new `.html` URLs.

## Notes

- The Google Analytics tag (`UA-12624119-1`) was carried over as-is, but
  Universal Analytics stopped processing data in July 2023 — create a GA4
  property and swap in its `G-XXXXXXX` measurement ID in
  `src/layouts/BaseLayout.astro`.
- The footer copyright year is rendered at build time, so rebuild at least
  once a year (or whenever content changes).
