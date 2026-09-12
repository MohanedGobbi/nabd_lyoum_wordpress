# نبض اليوم — Handoff

Everything anyone (a developer, the client, or future-you) needs to pick up
this project: what it is, how to run it, what's real vs. placeholder, and
what's left to do.

## What this is

A full custom WordPress theme for **نبض اليوم** (Nabd Aljazair), an
Algerian news site. Arabic/RTL, red-black-white identity, ten fixed
category colors, dark mode, built to match the client's approved design
(originally prototyped in Next.js, then rebuilt as real WordPress on the
client's request — the WordPress version is the one going forward).

**Repo:** https://github.com/MohanedGobbi/nabd_lyoum_wordpress
**Theme folder:** `nabd-aljazair/` (this is what gets zipped/uploaded to a
real WordPress install)

## Run it locally right now

```bash
cd wordpress-theme
docker compose up -d
```

Then open **http://localhost:8080**.

- **Site:** http://localhost:8080
- **wp-admin:** http://localhost:8080/wp-admin
  - Username: `admin`
  - Password: `19uVuaDI@wP3nar*(Q`

(These are local-dev-only credentials for the Docker container on this
machine — they mean nothing once this is deployed to real hosting, where a
fresh WordPress install will need its own admin account created during
setup.)

To stop it without losing anything: `docker compose stop` (from the same
folder). Data lives in Docker volumes and survives stop/start; only
`docker compose down -v` would wipe it.

If Docker Desktop isn't running, start it first (Windows: launch "Docker
Desktop" from the Start menu, wait ~30–60s for it to finish starting, then
run the command above).

### If you change the CSS

Styling is Tailwind, compiled ahead of time — there's no live build at
runtime:

```bash
cd nabd-aljazair
npm install        # once
npm run build:css  # after any class-name change
```

Then bump `NABD_VERSION` in `functions.php` by one so the browser doesn't
serve a cached copy of the old CSS/JS.

### Re-seeding demo content

`seed.sh` creates ~30 demo posts across all ten categories via WP-CLI. It
needs to be copied into the running container and run once:

```bash
docker cp seed.sh <container-name>:/tmp/seed.sh
docker exec <container-name> bash -c "chmod +x /tmp/seed.sh && /tmp/seed.sh"
```

(`docker ps` shows the container name, normally `wordpress-theme-wordpress-1`.)
WP-CLI itself isn't part of the WordPress image — if a fresh container
doesn't have `wp` at `/usr/local/bin/wp`, download it first:

```bash
docker exec <container-name> bash -c "curl -sL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x /usr/local/bin/wp"
```

## What's real vs. placeholder

**Real, working WordPress content** (not mocked):
- Articles = WordPress posts. Categories = the native WordPress category
  taxonomy. Images = real featured images (with a category-tinted
  placeholder graphic shown when a post has none).
- The view counter (shown as "الأكثر قراءة" sort and on single posts) is
  real — it increments on real visits (not counting logged-in editors).
- The video rail and the "فيديو" category section both pull real posts
  from the real "فيديو" category — there's no separate/fake video list.
- The ten categories (الجزائر, العرب والعالم, سياسة, اقتصاد, مجتمع, رياضة,
  تكنولوجيا, ثقافة, منوعات, فيديو) auto-create on theme activation with
  their fixed identity colors — see `inc/categories.php`.

**Still placeholder / needs a real decision before launch:**
- **Currency rates** — a static array in `inc/template-helpers.php`
  (`nabd_currency_rates()`). No WordPress content type fits this
  naturally; either hand-edit that function when rates change, or wire it
  to a real FX API on a cron later.
- **Newsletter signup form** — has no mailing-list provider connected.
  Point its `action` at Mailchimp/Brevo/etc. before launch.
- **App Store / Google Play links** — default to `#`. Set the real URLs
  in Appearance → Customize → إعدادات نبض اليوم once the app exists.
- **Comments are disabled site-wide** (deliberate — no moderation
  workflow exists yet). Re-enable per-post from a post's editor if wanted.
- **Demo posts from `seed.sh`** should be deleted (Posts → Trash) once
  real content is ready to take over.

## The category color system

Each category has a fixed accent color, defined once in
`inc/categories.php` (`nabd_category_colors()`), with a lighter dark-mode
variant for the three hues too dark to read on a near-black background.
That single array drives every badge, meta-line label, and section header
— change a color there and it changes everywhere.

فيديو (video) posts get an extra treatment beyond the color: any place a
video post shows as a card, the headline sits in a solid video-colored
panel directly under the thumbnail (not just colored text), plus a
play-icon badge on the thumbnail itself and its duration if set — see
`template-parts/article-card.php`.

## Known fixed bugs worth knowing about

Two real bugs were found and fixed during development, both worth
remembering if this pattern gets reused elsewhere in the theme:

1. **CSS custom-property override order.** `:root` and `.dark` on
   `<html>` have equal specificity, so whichever rule is written *later*
   in the stylesheet wins — not whichever is "more specific" in intent.
   The dark-mode category text colors were silently ignored for months
   until the light-mode block was moved before the `.dark` block instead
   of after.
2. **RTL `scrollLeft` direction.** In an RTL element, `scrollLeft` ranges
   from `-(scrollWidth - clientWidth)` to `0` — the mirror image of the
   usual `[0, max]` range. Code written assuming the LTR range (like a
   naive drag-to-scroll handler) silently clamps to zero and looks like
   it's doing nothing. `assets/js/main.js`'s drag handler accounts for
   this; keep that in mind if any other custom scroll interaction gets
   added.

## What's NOT done yet

- **No real hosting.** This only exists locally in Docker. Deploying it
  is a normal WordPress install (any PHP 7.4+/MySQL host) — zip
  `nabd-aljazair/` and upload it under Appearance → Themes → Add New →
  Upload Theme, or drop it into `wp-content/themes/` via FTP/SFTP.
- **No custom domain, SSL, backups, or security hardening** — all of
  that is whatever the eventual host provides or the client arranges.
- **English/French locales** were an explicitly deferred phase from the
  original brief — this build is Arabic/RTL only.
- **No `/admin`-equivalent custom dashboard** — wp-admin itself *is* the
  content dashboard now (Posts, Categories, Media, Users), which is a
  step up from the mocked dashboard the original Next.js prototype had.

## Quick file map

| Where | What |
|---|---|
| `functions.php` + `inc/` | Theme setup, category colors, view counter, breaking-news meta, icons, Customizer fields |
| `header.php` / `footer.php` | Utility bar, main nav, category slider, breaking ticker, mobile drawer, footer, bottom tab bar |
| `front-page.php` | Homepage |
| `category.php` | Category archive (three tabs: latest / most-read / articles) |
| `single.php` | Article page |
| `template-parts/` | Reusable pieces (article card, list row, category section, video rail, currency widget, newsletter) |
| `page-templates/all-news.php` | The "كل الأخبار" catch-all feed (auto-assigned to an auto-created page) |
| `assets/css/input.css` → `main.css` | Tailwind source → compiled output (commit both) |
| `assets/js/main.js` | Drawer, dark mode, category-page tabs, menu-bar drag-to-slide |
| `seed.sh` | WP-CLI demo content seeder |
| `docker-compose.yml` | Local WordPress + MySQL |
