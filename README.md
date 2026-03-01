# DevQ Starter Theme

A production-ready WordPress starter theme with ACF block integration, centralized spacing management, and comprehensive AI block generation instructions.

---

## Quick Start

### Creating a New Site from This Starter

1. Copy the theme into your WordPress `themes/` directory
2. Activate the theme and install ACF Pro
3. Visit **Custom Fields > Field Groups** and click "Sync" if prompted
4. Configure Theme Settings (branding, colors, fonts, spacing)
5. Start building pages with ACF blocks

### Creating a New Block

1. Read **[CLAUDE.md](CLAUDE.md)** for complete instructions
2. Add the block name to `$basefunctions` in `functions/blocks.php`
3. Create `blocks/[blockname]/code.php` using the template
4. Create `acfjson/group_[blockname]_block.json` with Content, Options, and Animation tabs
5. Test all tabs, responsive design, and spacing

---

## Theme Architecture

### Block System

- **Location**: `blocks/` directory — each block has its own folder with `code.php`
- **Registration**: Automatic via `functions/blocks.php` `$basefunctions` array
- **ACF JSON**: Auto-synced field definitions in `acfjson/`
- **Spacing**: Centralized responsive margin system via `functions/spacing.php`

### Included Blocks

- **Image** (`blocks/image/`) — Full/contained image with mobile variant support
- **WYSIWYG** (`blocks/wysiwyg/`) — Rich text content block
- **Hero** (`blocks/hero/`) — Full-width hero with background image, overlay, heading, and CTA button
- **Text Image** (`blocks/textimage/`) — Two-column text + image layout with left/right positioning
- **Cards** (`blocks/cards/`) — Grid of cards (2/3/4 columns) with icon, title, description, and link
- **CTA** (`blocks/cta/`) — Full-width call-to-action banner with custom background color
- **FAQ** (`blocks/faq/`) — Accordion FAQ section using BeefUp library

### Key Files

```
DevQ Starter/
├── CLAUDE.md              — AI block generator instructions
├── README.md              — This file
├── functions.php          — Theme setup and requires
├── style.css              — Main stylesheet
├── header.php             — Site header with desktop/mobile menus
├── footer.php             — Site footer with dynamic copyright
├── front-page.php         — Front page (ACF blocks via the_content)
├── single.php             — Single post template
├── archive.php            — Archive/category template
├── index.php              — Blog listing fallback
├── search.php             — Search results template
├── 404.php                — 404 error page (configurable via Theme Settings)
├── theme-settings-css.php — Generates CSS variables from Theme Settings
├── functions/
│   ├── acf.php            — ACF options pages and Local JSON config
│   ├── blocks.php         — Block registration (7 blocks)
│   ├── spacing.php        — Centralized spacing system
│   ├── scripts.php        — Script/style enqueues
│   ├── shortcodes.php     — [name], [phone], [email], [address] shortcodes
│   ├── navwalker.php      — Custom nav menu walker with dropdowns
│   ├── posttype.php       — Custom post type registration (boilerplate)
│   ├── emailnotifications.php — Disable update notification emails
│   ├── page-builder.php   — Programmatic page creation helpers + REST API
│   └── page-presets.php   — Page layout presets (home, about, contact, etc.)
├── blocks/
│   ├── README.md          — Block creation guidelines
│   ├── BLOCK-TEMPLATE.md  — Quick reference checklist
│   ├── image/code.php     — Image block (reference implementation)
│   ├── wysiwyg/code.php   — WYSIWYG block
│   ├── hero/code.php      — Hero block
│   ├── textimage/code.php — Text + Image block
│   ├── cards/code.php     — Cards block
│   ├── cta/code.php       — CTA block
│   └── faq/code.php       — FAQ block
├── acfjson/
│   ├── README.md          — ACF auto-sync documentation
│   ├── group_image_block.json
│   ├── group_wysiwyg_block.json
│   ├── group_hero_block.json
│   ├── group_textimage_block.json
│   ├── group_cards_block.json
│   ├── group_cta_block.json
│   ├── group_faq_block.json
│   └── group_theme_styles.json
├── scripts/
│   └── setup-site-example.php — Example client site setup script
└── assets/
    ├── css/               — Library stylesheets
    └── js/                — Library scripts and custom.js
```

### JS Libraries

Always loaded: jQuery (WP bundled), Slick, AOS, Mmenu, BeefUp

Conditionally available (uncomment in `functions/scripts.php`): Magnific Popup, jQuery Validate

### CSS Breakpoints

- **Tablet**: `@media (max-width: 1199px)`
- **Mobile**: `@media (max-width: 767px)`

### Theme Settings

Configurable via WP Admin > Theme Settings:
- **Branding** — Logo, favicon, alt logo
- **Header** — Phone, CTA
- **Contact** — Email, phone, address
- **Social** — Facebook, Twitter, Instagram, LinkedIn, YouTube
- **Styles** — Colors, typography, buttons, spacing
- **Scripts** — Header/footer scripts, Google Analytics, GTM, Facebook Pixel
- **404 Page** — Title, message, search toggle, quick links

---

## Page Builder

The theme includes a programmatic page builder for fast site setup. Create pages with blocks via PHP, WP-CLI, or REST API.

### WP-CLI Commands

```bash
wp devq create-page --title="About" --preset=about --status=draft
wp devq bulk-create --file=pages.json
wp devq list-presets
wp devq list-blocks
```

### Page Presets

| Preset | Blocks |
|--------|--------|
| `home` | Hero, Text Image, Cards, CTA |
| `about` | Hero, WYSIWYG, Text Image, CTA |
| `contact` | Hero, WYSIWYG |
| `services` | Hero, WYSIWYG, Cards, FAQ, CTA |
| `landing` | Hero, Text Image, Cards, FAQ, CTA |

### Quick Site Setup

Run the example setup script to create Home, About, Services, and Contact pages with a primary menu:

```bash
wp eval-file "wp-content/themes/DevQ Starter/scripts/setup-site-example.php"
```

See `scripts/setup-site-example.php` and adapt for each client.

---

## Documentation

| Document | Purpose |
|----------|---------|
| [CLAUDE.md](CLAUDE.md) | Complete AI block generation instructions |
| [blocks/README.md](blocks/README.md) | Block creation guidelines |
| [blocks/BLOCK-TEMPLATE.md](blocks/BLOCK-TEMPLATE.md) | Quick reference checklist |
| [acfjson/README.md](acfjson/README.md) | ACF Local JSON auto-sync system |
