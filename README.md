# نبض اليوم — WordPress theme

A full custom WordPress theme rebuild of the نبض اليوم (Nabd Aljazair) news
site — the same design (RTL Arabic, red/black/white palette, ten fixed
category colors, dark mode, the alarabiya.net-style article layout) as real
WordPress content, editable from the standard `wp-admin` screens.

This is a genuine rebuild, not a wrapper: there's no Next.js/React at
runtime. Templates are plain PHP, styling is Tailwind CSS compiled ahead of
time into a static file, and interactivity (drawer, dark mode, category
tabs) is plain vanilla JS. Categories, articles, images, and comments are
real WordPress content (posts, the built-in category taxonomy, featured
images) — not placeholder data.

## What's in `nabd-aljazair/`

- `functions.php` + `inc/` — theme setup, the category color system,
  the view-counter and breaking-news post meta, the icon library
  (`inc/icons.php` — hand-authored inline SVGs, no icon font/emoji),
  and a few Customizer fields (Appearance → Customize → إعدادات نبض اليوم)
  for things that aren't post/page content (weather text, footer blurb,
  app store links, a breaking-banner fallback).
- `header.php` / `footer.php` — the utility bar, main nav, breaking ticker,
  mobile drawer, and footer/bottom-nav — shared by every page.
- `front-page.php` — homepage: hero + "آخر الأخبار" list, the video rail
  (pulls real posts from the "فيديو" category), then one stacked section
  per official category, then the currency widget and newsletter signup.
- `category.php` — a category archive with the three tabs (أحدث الأخبار /
  الأكثر قراءة / المقالات), all rendered up front and toggled with plain JS.
- `single.php` — article page with related-articles.
- `template-parts/` — the reusable pieces (article-card, article-list-row,
  category-section, video-rail, currency-widget, newsletter).
- `page-templates/all-news.php` — the "كل الأخبار" catch-all feed, assigned
  automatically to an auto-created page on activation (see
  `nabd_create_news_page()` in `inc/setup.php`) — nothing to configure.

## The ten categories are created automatically

Activating the theme creates all ten official categories (الجزائر, العرب
والعالم, سياسة, اقتصاد, مجتمع, رياضة, تكنولوجيا, ثقافة, منوعات, فيديو) if
they don't already exist — see `nabd_create_default_categories()` in
`inc/categories.php`. Their colors are fixed in the same file
(`nabd_category_colors()`); assign any post to one of them and its badge,
card meta line, and section header pick up that color automatically.

## Local development

A Docker Compose file at the repo root of `wordpress-theme/` spins up
WordPress + MySQL with this theme mounted live:

```bash
cd wordpress-theme
docker compose up -d
```

Visit `http://localhost:8080` and run through the WordPress installer, then
activate "نبض اليوم" under Appearance → Themes.

### Editing the CSS

Styling is Tailwind, compiled ahead of time (there's no build step at
runtime — `assets/css/main.css` is a committed, compiled file):

```bash
cd nabd-aljazair
npm install
npm run build:css        # one-off build
npm run watch:css         # rebuild on every save, while you work
```

### Seeding demo content

`seed.sh` creates ~30 demo posts across all ten categories (plus a couple
flagged breaking / with a video duration) using WP-CLI, so you have
something realistic to look at immediately. It's meant to be copied into
the running container and run once:

```bash
docker cp seed.sh <container>:/tmp/seed.sh
docker exec <container> bash -c "chmod +x /tmp/seed.sh && /tmp/seed.sh"
```

Delete the demo posts from wp-admin (Posts → Bulk actions → Trash) whenever
real content is ready to take over.

## Known placeholders (by design, for now)

- **Currency rates** (`nabd_currency_rates()` in `inc/template-helpers.php`)
  are a small static array — there's no natural WordPress content type for
  this. Update the numbers by editing that function, or upgrade it to pull
  from a real FX API on a cron later; the markup won't need to change.
- **Newsletter signup** has no mailing-list provider wired up yet — point
  the form's `action` at Mailchimp/Brevo/etc. before launch.
- **App Store / Google Play links** default to `#` — set the real URLs in
  Appearance → Customize once the app exists.
- Comments are disabled site-wide (`inc/setup.php`) — a news portal with no
  moderation workflow yet. Re-enable per-post if the client wants discussion.

## Deploying to real hosting

This is a standard WordPress theme — zip the `nabd-aljazair/` folder (make
sure `assets/css/main.css` is committed/built first) and upload it under
Appearance → Themes → Add New → Upload Theme on any WordPress hosting, or
drop it into `wp-content/themes/` via FTP/SFTP. No special requirements
beyond a normal WordPress install (PHP 7.4+, MySQL/MariaDB).
