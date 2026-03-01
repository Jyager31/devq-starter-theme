# Block Creation Quick Reference Template

## Pre-Development Checklist

- [ ] Read the complete README.md file
- [ ] Understand the block requirements
- [ ] Plan the ACF field structure
- [ ] Choose appropriate field types

---

## Block Structure Template

### Folder Structure

```
blocks/
└── [blockname]/
    └── code.php (required)
acfjson/
└── group_[blockname]_block.json (required)
```

### Block Registration

Add to `$basefunctions` array in `functions/blocks.php`:

```php
'Human Readable Name', // Becomes: humanreadablename folder
```

---

## Code Template Checklist

### PHP File (code.php)

- [ ] Block header comment
- [ ] ACF function check
- [ ] Get all ACF fields as variables
- [ ] Include Options tab fields (margin_top, margin_bottom, custom_class, custom_id)
- [ ] Include Animation tab fields (animation_type, animation_duration, disable_animation)
- [ ] Generate unique block ID with `generate_unique_block_id()`
- [ ] Build dynamic classes and AOS attributes
- [ ] Main HTML structure
- [ ] Call `output_block_spacing_css()` for responsive spacing
- [ ] Embedded CSS with responsive breakpoints
- [ ] JavaScript (if needed)

### Required Options Tab Fields

- [ ] **Margin Top** - Select (None, Small, Medium, Large, Other, width: 50%)
- [ ] **Margin Top Other** - Number (conditional, append: "px", width: 50%)
- [ ] **Margin Bottom** - Select (None, Small, Medium, Large, Other, width: 50%)
- [ ] **Margin Bottom Other** - Number (conditional, append: "px", width: 50%)
- [ ] **Custom Class** - Text (prepend: ".", width: 50%)
- [ ] **Custom ID** - Text (prepend: "#", width: 50%)

### Required Animation Tab Fields

- [ ] **Animation Type** - Select (AOS animations, default: fade-up, width: 50%)
- [ ] **Animation Duration** - Number (default: 800, append: "ms", min: 300, max: 3000, width: 25%)
- [ ] **Disable Animation** - True/False (width: 25%)

---

## CSS Guidelines Checklist

- [ ] Unique block-specific class names
- [ ] No font-size overrides on global elements (h1-h6, p, ul, ol, li)
- [ ] Responsive breakpoints included:
  - [ ] Tablet: `@media (max-width: 1199px)`
  - [ ] Mobile: `@media (max-width: 767px)`
- [ ] Proper CSS structure: `.container-fluid` > `.container`

---

## Security & Best Practices

- [ ] All output escaped with appropriate functions:
  - [ ] `esc_html()` for text
  - [ ] `esc_url()` for URLs
  - [ ] `esc_attr()` for attributes
  - [ ] `wp_kses_post()` for rich content
- [ ] Error handling for missing ACF
- [ ] Error handling for required fields

---

## ACF Field Configuration

### Tab Structure (Left-aligned)

- [ ] **Content Tab** - Main fields
- [ ] **Options Tab** - Universal spacing/customization options
- [ ] **Animation Tab** - AOS animation settings

### Preferred Field Types

- [ ] Link fields -> Return format: "Array"
- [ ] Image fields -> Return format: "Array"
- [ ] Use Repeaters instead of Flexible Content
- [ ] Use Tabs instead of Groups

---

## Testing Checklist

- [ ] Block renders correctly
- [ ] All 3 tabs appear (Content, Options, Animation)
- [ ] Options tab fields work (margins, classes, ID)
- [ ] Animation works and can be disabled
- [ ] Responsive design at 1199px breakpoint
- [ ] Responsive design at 767px breakpoint
- [ ] No console errors
- [ ] No PHP errors
- [ ] ACF fields save properly

---

## Common Mistakes to Avoid

- Using Groups instead of Tabs
- Using Flexible Content instead of Repeaters
- Setting font-sizes on global elements
- Not including Options tab
- Not including Animation tab
- Not escaping output
- Missing error handling
- Non-unique CSS classes
- Using 991px breakpoint (use 767px for mobile)

---

## Reference

- **Main Guidelines**: See README.md
- **Example Block**: `blocks/image/` folder
- **ACF JSON Example**: `acfjson/group_image_block.json`
- **CLAUDE.md**: Full AI instructions at theme root

---

_Quick Reference v2.0_
