# WordPress ACF Block Creation Guidelines

**This document MUST be read and followed for every block creation task. No exceptions.**

---

## Overview

This document outlines the strict guidelines and requirements for creating WordPress ACF blocks for this project. All AI tools and developers must follow these rules to ensure consistency, functionality, and maintainability.

## Project Structure

- **Theme**: Custom WordPress theme with ACF integration
- **Block System**: Custom ACF blocks registered via `functions/blocks.php`
- **Organization**: Each block has its own folder with `code.php` and optional `style.css`/`script.js`
- **ACF JSON**: Field definitions stored in `acfjson/` for auto-sync

---

## Block Creation Requirements

### 1. File Structure

Each block must include:

- **code.php** - Main block file with embedded CSS/JS (required)
- **ACF JSON** - Field configuration placed in `acfjson/group_[blockname]_block.json` (required)

### 2. Block Registration

Blocks are automatically registered in `functions/blocks.php` using the `$basefunctions` array. Block names are processed through the `devq_filtername()` function which:

- Converts to lowercase
- Removes spaces and hyphens
- Creates the folder name and ACF identifier

### 3. Code Structure Standards

#### PHP File Template (code.php)

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

// ACF Fields - Get all fields first
$field1 = get_field('field1');
$field2 = get_field('field2');

// Options Tab Fields (always include these)
$margin_top = get_field('margin_top') ?: '';
$margin_bottom = get_field('margin_bottom') ?: '';
$margin_top_other = get_field('margin_top_other') ?: 0;
$margin_bottom_other = get_field('margin_bottom_other') ?: 0;
$custom_class = get_field('custom_class');
$custom_id = get_field('custom_id');

// Animation Tab Fields (always include these)
$animation_type = get_field('animation_type') ?: 'fade-up';
$animation_duration = get_field('animation_duration') ?: 800;
$disable_animation = get_field('disable_animation');

// Generate unique block ID
$unique_block_id = generate_unique_block_id('block-name-here');

// Build dynamic attributes
$block_classes = 'container-fluid block-name-here';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

// Use custom ID if provided, otherwise use unique ID
$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
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
/* Block-specific styles */
.block-name-here {
    /* Base styles */
}

/* Tablet Styles - 1199px and below */
@media (max-width: 1199px) {
    /* Tablet responsive styles */
}

/* Mobile Styles - 767px and below */
@media (max-width: 767px) {
    /* Mobile responsive styles */
}
</style>
```

#### Repeater Field Pattern

```php
<?php if (have_rows('repeater_field_name')) :
    while (have_rows('repeater_field_name')) : the_row();
        $sub_field1 = get_sub_field('sub_field1');
        $sub_field2 = get_sub_field('sub_field2');
        ?>
        <div class="repeater-item">
            <?php echo esc_html($sub_field1); ?>
            <?php echo wp_kses_post($sub_field2); ?>
        </div>
        <?php
    endwhile;
endif; ?>
```

---

## 4. ACF Field Configuration

### Required Tab Structure

All ACF fields must be organized using tabs (left-aligned):

1. **Content Tab** - Main content fields
2. **Options Tab** - Universal spacing and customization options
3. **Animation Tab** - AOS animation settings

### Options Tab Requirements

The Options tab must always include these fields:

- **Margin Top** - Select field with choices: None, Small, Medium, Large, Other (width: 50%)
- **Margin Top Other** - Number field (conditional, shows when "Other" selected, append: "px", width: 50%)
- **Margin Bottom** - Select field with choices: None, Small, Medium, Large, Other (width: 50%)
- **Margin Bottom Other** - Number field (conditional, shows when "Other" selected, append: "px", width: 50%)
- **Custom Class** - Text field (prepend: ".", width: 50%)
- **Custom ID** - Text field (prepend: "#", width: 50%)

### Animation Tab Requirements

The Animation tab must always include these fields for AOS integration:

- **Animation Type** - Select field with AOS animation choices (default: fade-up, width: 50%)
- **Animation Duration** - Number field (default: 800, append: "ms", min: 300, max: 3000, width: 25%)
- **Disable Animation** - True/False field (width: 25%)

**Theme Settings Integration:**

- Small, Medium, Large spacing values are defined in Theme Settings
- Default values: Small (20px), Medium (40px), Large (80px)
- Mobile values applied automatically at 767px: Small (15px), Medium (25px), Large (40px)

### Field Types to AVOID

- Groups - Use tabs instead
- Flexible Content - Use repeaters or separate blocks
- URL fields - Use Link fields with array return format

### Preferred Field Types

- Link fields - Always set return format to "Array"
- Image fields - Return format "Array" for full image data
- Repeater fields - For multiple items
- Text/Textarea/WYSIWYG - For content
- Select/Radio/Checkbox - For options

---

## 5. Styling Guidelines

### CSS Requirements

- All classes must be unique to the block to prevent conflicts
- Use block-specific prefixes (e.g., `.video-modal-block`, `.faq-block`)
- Structure: `.container-fluid` (outer wrapper with spacing) > `.container` (global width container)
- Include responsive breakpoints:
  - **Tablet**: `@media (max-width: 1199px)`
  - **Mobile**: `@media (max-width: 767px)`

### Font Size Restriction

**NEVER** set font-sizes on these elements as they are handled globally:
- `h1, h2, h3, h4, h5, h6`
- `p`
- `ul, ol, li`

### Available Libraries

The theme includes these pre-loaded libraries:

- jQuery (WordPress bundled)
- Slick Slider
- AOS (Animate on Scroll)
- Mmenu (Mobile Menu)
- Reflex Grid

Conditionally available (uncomment in `functions/scripts.php` when needed):
- Magnific Popup
- jQuery Validation
- Beefup (Accordion)

---

## 6. Block Naming Convention

When adding a new block:

1. Add the human-readable name to `$basefunctions` array in `functions/blocks.php`
2. The system automatically creates:
   - **Folder name**: `devq_filtername()` processed version
   - **ACF identifier**: Same as folder name
   - **Block slug**: `acf/[foldername]`

**Example:**

- Input: "Hero Banner"
- Folder: `herobanner`
- ACF Block: `acf/herobanner`

---

## 7. Error Handling

Always include proper error handling:

```php
// Check ACF is active
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// Check required fields
if (!$required_field) {
    echo 'Please fill out all required fields for this block.';
    return;
}
```

---

## 8. Security Best Practices

Always escape output:

- `esc_html()` - For text content
- `esc_url()` - For URLs
- `esc_attr()` - For HTML attributes
- `wp_kses_post()` - For rich text content

---

## 9. Testing Checklist

Before delivery, ensure:

- Options tab implemented correctly with all 6 fields
- Animation tab implemented with all 3 fields
- Responsive design tested at 1199px and 767px
- Mobile spacing values automatically applied at 767px and below
- No font-size overrides on global elements
- Unique CSS classes used
- Centralized spacing functions used correctly
- All output properly escaped

---

## Example Block Reference

See the **Image block** (`blocks/image/` folder and `acfjson/group_image_block.json`) as the reference implementation that follows all these guidelines correctly.

---

_Last Updated: March 2026_
_Version: 2.0_
