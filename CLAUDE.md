# DevQ Starter Theme - Claude Block Generator Instructions

## Theme Architecture

- **Theme root:** This directory
- **Block location:** `blocks/[blockname]/code.php`
- **Block registration:** `functions/blocks.php` — `$basefunctions` array
- **ACF JSON:** `acfjson/group_[blockname]_block.json`
- **Spacing system:** `functions/spacing.php` — centralized responsive spacing
- **Page builder:** `functions/page-builder.php` — programmatic page creation
- **Page presets:** `functions/page-presets.php` — common page layouts
- **Theme settings CSS:** `theme-settings-css.php` — generates CSS variables from ACF options
- **Main stylesheet:** `style.css`
- **Theme updater:** `functions/theme-updater.php` — GitHub release update checker
- **Release workflow:** `.github/workflows/release.yml` — auto-builds release zip on tag push
- **Child theme boilerplate:** `devq-starter-child/` — copy per client site

## Releasing Updates

This theme auto-updates on all sites via a public GitHub repo and `plugin-update-checker`. When a new GitHub release is published, every site running this theme will see the update in WP Admin.

### Release Steps

1. Bump `Version:` in `style.css` (this is the single source of truth)
2. Commit the change
3. Tag and push:
   ```bash
   git tag vX.Y.Z && git push origin master vX.Y.Z
   ```
4. GitHub Actions automatically builds the zip and creates the release — done

### Version Format

Use semver: `MAJOR.MINOR.PATCH`
- **Patch** (1.0.1) — bug fixes, copy changes
- **Minor** (1.1.0) — new blocks, new features
- **Major** (2.0.0) — breaking changes to child themes or block structure

### Do NOT

- Manually create releases on GitHub (the Actions workflow handles this)
- Edit anything in the `plugin-update-checker/` directory (third-party library)

### Child Themes

Per-site customizations (colors, fonts, extra blocks, templates) belong in child themes, not in this repo. Copy `devq-starter-child/` as a starting point for each client.

## Creating a New Block

### Step 1: Register the Block

Add the human-readable name to the `$basefunctions` array in `functions/blocks.php`:

```php
$basefunctions = array(
    "Image",
    "Wysiwyg",
    "Your New Block",  // Add here
);
```

The `devq_filtername()` function processes the name:
- Converts to lowercase
- Removes spaces and hyphens
- Result becomes the folder name and ACF identifier
- Example: `"Your New Block"` → folder `yournewblock`, ACF block `acf/yournewblock`

### Step 2: Create the Block Folder and code.php

Create `blocks/[filteredname]/code.php`. Use this exact template:

```php
<?php
/**
 * [Block Name] Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$field1 = get_field('field1');

// Options Tab Fields (ALWAYS include these)
$margin_top = get_field('margin_top') ?: '';
$margin_bottom = get_field('margin_bottom') ?: '';
$margin_top_other = get_field('margin_top_other') ?: 0;
$margin_bottom_other = get_field('margin_bottom_other') ?: 0;
$custom_class = get_field('custom_class');
$custom_id = get_field('custom_id');

// Animation Tab Fields (ALWAYS include these)
$animation_type = get_field('animation_type') ?: 'fade-up';
$animation_duration = get_field('animation_duration') ?: 800;
$disable_animation = get_field('disable_animation');

// Generate unique block ID
$unique_block_id = generate_unique_block_id('blockname');

// Build dynamic attributes
$block_classes = 'container-fluid blockname-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Check required fields
if (!$field1) {
    echo 'Please fill out all required fields for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?>>
    <div class="container">
        <!-- Block content here -->
    </div>
</div>

<?php
// Output responsive spacing CSS using unique block ID
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
.blockname-block {
    /* Base styles */
}

/* Tablet - 1199px and below */
@media (max-width: 1199px) {
    .blockname-block {
        /* Tablet styles */
    }
}

/* Mobile - 767px and below */
@media (max-width: 767px) {
    .blockname-block {
        /* Mobile styles */
    }
}
</style>
```

### Step 3: Create the ACF JSON

Create `acfjson/group_[blockname]_block.json`. Every block MUST have 3 tabs:

1. **Content** — Block-specific fields
2. **Options** — Margin Top, Margin Top Other, Margin Bottom, Margin Bottom Other, Custom Class, Custom ID
3. **Animation** — Animation Type (select), Animation Duration (number), Disable Animation (true/false)

Use `blocks/image/code.php` and `acfjson/group_image_block.json` as the reference implementation.

#### ACF JSON Key Naming Convention

All field keys must be prefixed with the block name to avoid collisions:
- `field_[blockname]_content_tab`
- `field_[blockname]_[fieldname]`
- `field_[blockname]_options_tab`
- `field_[blockname]_margin_top`
- `field_[blockname]_animation_tab`
- `field_[blockname]_animation_type`

#### Options Tab Fields (copy exactly)

| Field | Type | Width | Choices | Conditional |
|-------|------|-------|---------|------------|
| Margin Top | select | 50% | none/small/medium/large/other | — |
| Margin Top Other | number | 50% | append: "px", min: 0 | margin_top == other |
| Margin Bottom | select | 50% | none/small/medium/large/other | — |
| Margin Bottom Other | number | 50% | append: "px", min: 0 | margin_bottom == other |
| Custom Class | text | 50% | prepend: "." | — |
| Custom ID | text | 50% | prepend: "#" | — |

#### Animation Tab Fields (copy exactly)

| Field | Type | Width | Default |
|-------|------|-------|---------|
| Animation Type | select | 50% | fade-up |
| Animation Duration | number | 25% | 800, append: "ms", min: 300, max: 3000 |
| Disable Animation | true_false | 25% | 0 |

Animation Type choices: fade-up, fade-down, fade-left, fade-right, fade-up-right, fade-up-left, fade-down-right, fade-down-left, flip-up, flip-down, flip-left, flip-right, slide-up, slide-down, slide-left, slide-right, zoom-in, zoom-in-up, zoom-in-down, zoom-in-left, zoom-in-right, zoom-out

## CSS Rules

### CSS Variables (set dynamically from Theme Settings)

```css
--primary          /* Primary brand color */
--secondary        /* Secondary brand color */
--tertiary         /* Accent color */
--font1            /* Heading font family */
--font2            /* Body font family */
--heading-weight   /* Heading font weight */
--body-weight      /* Body font weight */
--body-size        /* Body font size */
--button-radius    /* Button border radius */
--button-padding   /* Button padding */
--spacing-small    /* Small spacing value */
--spacing-medium   /* Medium spacing value */
--spacing-large    /* Large spacing value */
--section-padding-top     /* Section top padding */
--section-padding-bottom  /* Section bottom padding */
--transition-default      /* Standard transition: all 0.3s ease-in-out */
--transition-fast         /* Fast transition: all 0.1s ease-in-out */
```

### Class Naming

- All CSS classes MUST be unique to the block: `.blockname-block`, `.blockname-content`, etc.
- Outer wrapper: `container-fluid blockname-block`
- Inner wrapper: `container`
- NEVER set font-size on h1-h6, p, ul, ol, li (globally controlled)

### Breakpoints

- **Tablet:** `@media (max-width: 1199px)`
- **Mobile:** `@media (max-width: 767px)`
- Only use these two breakpoints. Do NOT use 991px.

## Escaping Rules

- Text content: `esc_html()`
- URLs: `esc_url()`
- HTML attributes: `esc_attr()`
- Rich text / WYSIWYG: `wp_kses_post()`
- CSS in style tags: `wp_strip_all_tags()`

## Available JS Libraries

Always loaded:
- **jQuery** (WordPress bundled)
- **Slick** — Carousel/slider
- **AOS** — Scroll animations (initialized in footer)
- **Mmenu** — Mobile menu
- **BeefUp** — Accordion (used by FAQ block, initialized in `custom.js`)

Available but commented out in `functions/scripts.php` (uncomment when needed):
- **Magnific Popup** — Lightbox/modal
- **jQuery Validate** — Form validation

## Repeater Field Pattern

```php
<?php if (have_rows('items')) :
    while (have_rows('items')) : the_row();
        $title = get_sub_field('title');
        $content = get_sub_field('content');
        ?>
        <div class="blockname-item">
            <h3><?php echo esc_html($title); ?></h3>
            <?php echo wp_kses_post($content); ?>
        </div>
        <?php
    endwhile;
endif; ?>
```

## Testing Checklist

After creating a block:
1. All 3 tabs appear (Content, Options, Animation)
2. Margin options work (None/Small/Medium/Large/Other)
3. Custom class and ID applied correctly
4. AOS animation works and can be disabled
5. Responsive design correct at 1199px and 767px
6. No console JS errors
7. No PHP errors
8. All output properly escaped

## Block Category

All blocks register under the `devq` category. The block slug is `acf/[filteredname]`.

## Spacing System

The spacing system is centralized in `functions/spacing.php`:
- `generate_unique_block_id($type)` — Creates a unique ID for each block instance
- `output_block_spacing_css($top, $bottom, $top_other, $bottom_other, $id)` — Outputs responsive `<style>` tag
- Desktop values: Small (20px), Medium (40px), Large (80px) — configurable in Theme Settings
- Mobile values: Small (15px), Medium (25px), Large (40px) — auto-applied at 767px

## Available Blocks

| Block | Slug | Fields | Description |
|-------|------|--------|-------------|
| Image | `acf/image` | image, fluid, custom_mobile_image, mobile_image | Full/contained image with mobile variant |
| WYSIWYG | `acf/wysiwyg` | wysiwyg | Rich text content |
| Hero | `acf/hero` | heading, subheading, button, background_image, overlay_opacity | Full-width hero with background image and overlay |
| Text Image | `acf/textimage` | heading, content, image, button, image_position | Two-column text + image layout |
| Cards | `acf/cards` | heading, subheading, columns, cards (repeater: icon, title, description, link) | Grid of cards with 2/3/4 column options |
| CTA | `acf/cta` | heading, content, button, background_color | Call-to-action banner |
| FAQ | `acf/faq` | heading, items (repeater: question, answer) | Accordion FAQ using BeefUp |

## New Site Setup

When asked to set up a new client site, follow this two-phase sequence:

### Phase 1 — Bootstrap (before theme is active)

1. **Read config:** `~/.devq/config.json` — contains plugin zip paths, license keys, and default page list.

2. **Install plugins:**
   ```bash
   wp plugin install "{acf_zip_path}" --activate
   wp plugin install "{gf_zip_path}" --activate
   wp plugin install wordpress-seo --activate
   ```

3. **Activate licenses:**
   ```bash
   # ACF Pro
   wp eval 'update_option("acf_pro_license", "{acf_license_key}");'

   # Gravity Forms
   wp eval 'GFFormsModel::save_key("{gf_license_key}");'
   ```

4. **Bootstrap theme + child theme:**
   ```bash
   wp eval-file "wp-content/themes/devq-starter/scripts/bootstrap.php" "Client Name"
   ```
   This copies `devq-starter-child/` → `clientname-child/`, replaces "Client Name" in `style.css`, and activates the child theme.

### Phase 2 — Content scaffold (requires active theme)

5. **Scaffold content:**
   ```bash
   wp eval-file "wp-content/themes/devq-starter/scripts/setup-site.php"
   ```
   This creates pages from presets, sets Home as front page, builds the Primary Menu, deletes default content (Sample Page, Hello world!), and sets permalinks to `/%postname%/`.

   To use custom pages: `wp eval-file "...setup-site.php" home about services contact landing`

### Verification

6. **Verify everything worked:**
   ```bash
   wp theme status
   wp plugin list
   wp post list --post_type=page --fields=ID,post_title,post_status
   wp option get page_on_front
   wp menu list
   ```

### Important Notes

- `~/.devq/config.json` is machine-level config (secrets stay out of git)
- `scripts/bootstrap.php` is standalone — no theme dependency
- `scripts/setup-site.php` requires the theme to be active (uses `devq_create_page()`)
- Available presets: `home`, `about`, `contact`, `services`, `landing`

## Programmatic Page Creation

### Creating a Page with Blocks

Use `devq_create_page()` to create pages programmatically:

```php
$post_id = devq_create_page(array(
    'title' => 'About Us',
    'slug' => 'about',
    'status' => 'publish',
    'blocks' => array(
        array(
            'name' => 'Hero',
            'fields' => array(
                'heading' => 'About Our Company',
                'subheading' => 'Learn more about what we do',
                'overlay_opacity' => 60,
            ),
        ),
        array(
            'name' => 'Wysiwyg',
            'fields' => array(
                'wysiwyg' => '<p>Company description here.</p>',
            ),
        ),
    ),
));
```

### Using Presets

Presets define common page layouts with empty placeholder fields:

```php
// Get all presets
$presets = devq_get_page_presets();

// Create a page from a preset
$post_id = devq_create_page(array(
    'title' => 'Home',
    'status' => 'publish',
    'blocks' => $presets['home'],
));
```

Available presets: `home`, `about`, `contact`, `services`, `landing`

### WP-CLI Commands

```bash
# Create a single page with preset
wp devq create-page --title="About" --preset=about --status=draft

# Bulk create from JSON file
wp devq bulk-create --file=pages.json

# List available presets
wp devq list-presets

# List registered blocks
wp devq list-blocks
```

### REST API (fallback when WP-CLI unavailable)

```bash
curl -X POST http://localhost/wp-json/devq/v1/create-page \
  -H "Content-Type: application/json" \
  -u "admin:password" \
  -d '{"title":"About","preset":"about","status":"draft"}'
```

### Bulk Page Creation Workflow

1. Create pages from presets: `wp devq create-page --title="Home" --preset=home --status=publish`
2. Or run the setup script: `wp eval-file "wp-content/themes/devq-starter/scripts/setup-site.php"`
3. Edit pages in WP admin to fill in real content
4. See the "New Site Setup" section above for the full orchestration workflow
