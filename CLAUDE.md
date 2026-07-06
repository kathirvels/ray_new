# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Astro 5 site for Rayinfos Technologies, originally a port of the old PHP
brochure site in `../ray_old`. The whole site now runs on the eStartup
Bootstrap theme (BootstrapMade), mirrored from https://rayinfos.com/proj/ray/
into `public/assets/`. The old OWL Templates jQuery theme is gone from the
pages (its assets still sit unused in `public/css` and `public/js`; the old
`public/images/*` are still used for portfolio/team/product photos). Static
output (`dist/`) deploys to any Apache/PHP host.

## Commands

- `npm run dev` — dev server (needs Node 20.3+; the system Node here is too
  old — see the standalone Node 20 tarball workaround in memory)
- `npm run build` — static build into `dist/`
- `npm run preview` — serve `dist/`

There are no tests or linters.

## Architecture

- `src/pages/index.astro` — standalone full-HTML home page (no layout):
  eStartup header/nav, hero, get-started, about-us, "Amazing Features" and
  contact sections, footer. Nav uses in-page anchors for sections that live
  on the home page (`#about-us`, `#contact`) and `.html` links elsewhere.
- `src/layouts/ThemeLayout.astro` — shared layout for the 10 inner pages
  (about, services, products, portfolio, team, price, faq, contact, sitemap,
  404). Props: `page` (nav-highlight slug) and `heading` (breadcrumbs-band
  title + `<title>` suffix). It contains the eStartup header, breadcrumbs
  band, footer and all vendor script tags.
- Theme CSS (`public/assets/css/style.css`) scopes component styles to
  section IDs — reuse them on inner pages to inherit the look:
  `#get-started`/`#features` (feature-block cards), `#team` (team-block),
  `#pricing` (block-pricing tables), `#blog` (block-blog cards, used by the
  portfolio page), `#contact` (info + form).
- All theme scripts are loaded with `is:inline` (jQuery, Bootstrap, superfish,
  AOS, owl.carousel, modal-video, php-email-form validate.js, then
  `assets/js/main.js`) — do not let Astro bundle them, load order matters.
  main.js builds the mobile nav and initialises everything unconditionally;
  the modal-video/owl.carousel vendor files must stay loaded even though no
  page currently uses them, or main.js throws.
- Removed pages: blog, blog-single and the old template demo pages
  (elements, headings, column, price-layouts). `.htaccess` 301s their old
  `.php`/`.html` URLs to live pages.
- `astro.config.mjs` uses `build.format: 'file'` so pages emit as
  `about.html` etc. at the site root; that's why in-page relative asset paths
  (`assets/...`, `images/...`) work. Don't switch to directory format without
  rewriting those paths.

## Contact form

The home page and contact page both use the eStartup form
(`assets/vendor/php-email-form/validate.js`) POSTing name/email/subject/
message to `public/forms/contact.php`. That endpoint emails
`info@rayinfos.com` (recipient fixed server-side, header-injection safe) and
must echo the literal `OK` on success — validate.js shows the error branch
for anything else. It only executes on a PHP-enabled host, not under
`astro dev`/`preview`. (`public/js/owlmail.php` is the old theme's endpoint,
kept but no longer referenced.)

## SEO invariants

Keep these intact when editing: the meta description/keywords in
index.astro and ThemeLayout.astro, `public/sitemap.xml` (lists exactly the
nine indexable pages), `public/robots.txt`, and `public/.htaccess` (301
redirects from the old `.php` URLs and from the removed pages — this is what
preserves the old site's search rankings).
