# DevQ Starter Theme

A production-ready WordPress starter theme with 30 ACF blocks, programmatic page creation, auto-updates via GitHub releases, and a child theme system for per-client customization.

---

## Quick Start

### New Client Site (Automated)

1. Create a fresh Local site
2. Clone this theme: `git clone https://github.com/Jyager31/devq-starter-theme.git devq-starter`
3. Install ACF Pro, Gravity Forms, Yoast SEO
4. Run bootstrap: `wp eval-file "wp-content/themes/devq-starter/scripts/bootstrap.php" "Client Name"`
5. Run setup: `wp eval-file "wp-content/themes/devq-starter/scripts/setup-site.php"`

Or use `/site-build` in Claude Code for a fully automated build from a reference URL or brief.

### New Block

1. Read **[CLAUDE.md](CLAUDE.md)** for complete instructions
2. Add the block name to `$basefunctions` in `functions/blocks.php`
3. Create `blocks/[blockname]/code.php` using the template
4. Create `acfjson/group_[blockname]_block.json` with Content, Options, and Animation tabs

---

## Theme Architecture

### File Structure

```
devq-starter/
├── CLAUDE.md                  — Complete dev reference (blocks, fields, conventions)
├── README.md                  — This file
├── style.css                  — Main stylesheet + theme header (version source of truth)
├── functions.php              — Theme setup, requires all function files
├── header.php                 — Desktop nav + mobile menu
├── footer.php                 — Footer with dynamic copyright
├── front-page.php             — Front page template
├── single.php                 — Single post template
├── archive.php                — Archive/category template
├── index.php                  — Blog listing fallback
├── search.php                 — Search results
├── 404.php                    — 404 page (configurable via Theme Settings)
├── theme-settings-css.php     — Generates CSS variables from ACF options
│
├── functions/
│   ├── acf.php                — ACF options pages, Local JSON paths
│   ├── animations.php         — devq_aos() helper for per-element animations
│   ├── blocks.php             — Block registration (30 blocks), category, allowed types
│   ├── emailnotifications.php — Disables WP update notification emails
│   ├── navwalker.php          — Desktop dropdown walker + mobile accordion walker
│   ├── page-builder.php       — devq_create_page(), REST API endpoints, Block Library admin
│   ├── page-presets.php       — Page layout presets (home, about, contact, services, landing)
│   ├── posttype.php           — Custom post type registration (boilerplate)
│   ├── scripts.php            — Conditional script/style enqueues + custom login page
│   ├── shortcodes.php         — [name], [phone], [email], [address] shortcodes
│   ├── spacing.php            — Centralized responsive spacing system
│   ├── theme-disconnect.php   — One-click "flatten & sever" tool (Tools > Disconnect Theme)
│   └── theme-updater.php      — GitHub release auto-updater via plugin-update-checker
│
├── blocks/                    — 30 block folders, each with code.php + optional style.css/script.js
│   ├── hero/                  ├── herosplit/          ├── herovideo/
│   ├── heroslider/            ├── herofullscreen/     ├── textimage/
│   ├── content/               ├── about/              ├── blogposts/
│   ├── tabs/                  ├── cards/              ├── team/
│   ├── pricing/               ├── comparisontable/    ├── testimonials/
│   ├── logobar/               ├── stats/              ├── marquee/
│   ├── image/                 ├── gallery/            ├── video/
│   ├── map/                   ├── beforeafter/        ├── banner/
│   ├── cta/                   ├── contactsplit/       ├── faq/
│   ├── process/               ├── featureslist/       └── timeline/
│
├── acfjson/                   — ACF Local JSON field groups (auto-synced)
│
├── scripts/
│   ├── bootstrap.php          — Creates child theme from boilerplate, activates it
│   ├── setup-site.php         — Scaffolds pages from presets, sets front page, builds menu
│   ├── create-block-library.php — Generates showcase page with all 30 blocks
│   └── site-health.php        — WP-CLI audit script (theme, plugins, settings, content)
│
├── devq-starter-child/        — Child theme boilerplate (copied per client by bootstrap.php)
│   ├── style.css
│   └── functions.php
│
├── plugin-update-checker/     — Third-party library (do not edit)
├── .github/workflows/         — GitHub Actions: auto-builds release zip on tag push
└── assets/
    ├── css/                   — aos.css, reflex.css, slick.css, beefup.css, magnific-popup.css
    └── js/                    — aos.js, slick.js, beefup.min.js, magnific-popup.min.js,
                                 mobile-menu.js, custom.js
```

### Blocks (30 total)

| Category | Blocks |
|----------|--------|
| Heroes | Hero, Hero Split, Hero Video, Hero Slider, Hero Fullscreen |
| Content | Text Image, Content, About, Blog Posts, Tabs |
| Cards & Grids | Cards, Team, Pricing, Comparison Table |
| Social Proof | Testimonials, Logo Bar, Stats, Marquee |
| Media | Image, Gallery, Video, Map, Before/After |
| Conversion | Banner, CTA, Contact Split |
| Lists | FAQ, Process, Features List, Timeline |

### JS Libraries

**Always loaded:** jQuery (WP bundled), AOS, Mobile Menu (custom vanilla JS)

**Conditionally loaded** (auto-detected from page blocks):
- Slick — when Hero Slider or Testimonials blocks are present
- BeefUp — when FAQ block is present
- Magnific Popup — when Gallery block is present

### CSS Breakpoints

- **Tablet:** `@media (max-width: 1199px)`
- **Mobile:** `@media (max-width: 767px)`

### Theme Settings (ACF Options)

| Category | Fields |
|----------|--------|
| Branding | Logo, alt logo, favicon, company name, header CTA |
| Contact | Phone, email, address |
| Social | Facebook, Instagram, LinkedIn, YouTube, Twitter |
| Styles — Colors | Primary, secondary, accent |
| Styles — Typography | Font embed, heading font/weight/line-height, body font/weight/size/line-height |
| Styles — Buttons | Border radius, padding |
| Layout | Header style, mobile menu style, footer style |
| Scripts | Header/footer scripts, GA, GTM, Facebook Pixel |
| 404 Page | Title, message, search toggle, quick links |

---

## Releasing Updates

This theme auto-updates on all client sites via GitHub releases.

1. Bump `Version:` in `style.css`
2. Commit and tag: `git tag vX.Y.Z && git push origin master vX.Y.Z`
3. GitHub Actions builds the zip and creates the release automatically

---

## Child Theme System

Per-client customizations live in child themes. The boilerplate in `devq-starter-child/` is copied by `bootstrap.php` for each new site.

Child themes can:
- **Add blocks** via the `devq_blocks` filter
- **Override templates** by copying `blocks/[name]/code.php` to the same path
- **Override styles/scripts** by copying `blocks/[name]/style.css` or `script.js`
- **Remove blocks** via `array_diff` on the filter

### Theme Disconnect

When a client site is finalized and no longer needs parent theme updates, use **Tools > Disconnect Theme** to merge the child into the parent, remove the updater, and create a standalone theme.

---

## Page Builder

Create pages programmatically with blocks via PHP, WP-CLI, or REST API.

### Presets

| Preset | Blocks |
|--------|--------|
| `home` | Hero, Text Image, Cards, CTA |
| `about` | Hero, Content, Text Image, CTA |
| `contact` | Hero, Contact Split |
| `services` | Hero, Content, Cards, FAQ, CTA |
| `landing` | Hero, Text Image, Cards, FAQ, CTA |

### REST API

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/wp-json/devq/v1/create-page` | POST | Create a page with blocks |
| `/wp-json/devq/v1/create-menu` | POST | Create/replace primary menu |
| `/wp-json/devq/v1/setup-front-page` | POST | Set static front page |
| `/wp-json/devq/v1/site-info` | GET | Site URL, theme, blocks, presets |

### Admin Tools

- **Appearance > Block Library** — Generate a showcase page with all 30 blocks
- **Tools > Disconnect Theme** — Flatten child theme into standalone
- **WP-CLI:** `wp eval-file ".../scripts/site-health.php"` — Audit site configuration

---

## Documentation

| Document | Purpose |
|----------|---------|
| [CLAUDE.md](CLAUDE.md) | Complete dev reference — blocks, fields, conventions, animation system |
| [blocks/README.md](blocks/README.md) | Block creation guidelines |
| [blocks/BLOCK-TEMPLATE.md](blocks/BLOCK-TEMPLATE.md) | Quick reference checklist |
| [acfjson/README.md](acfjson/README.md) | ACF Local JSON auto-sync system |
