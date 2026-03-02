<?php

/**
 * WYSIWYG Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab (field renamed from 'wysiwyg' to 'content' to avoid ACF type collision)
$wysiwyg = get_field('content');

$max_width = get_field('max_width') ?: 'default';

// Options Tab Fields (always include these)
$margin_top = get_field('margin_top') ?: '';
$margin_bottom = get_field('margin_bottom') ?: '';
$margin_top_other = get_field('margin_top_other') ?: 0;
$margin_bottom_other = get_field('margin_bottom_other') ?: 0;
$custom_class = get_field('custom_class');
$custom_id = get_field('custom_id');

// Animation Tab Fields
$animation_type = get_field('animation_type') ?: 'fade-up';
$animation_duration = get_field('animation_duration') ?: 800;
$disable_animation = get_field('disable_animation');

// Generate unique block ID
$unique_block_id = generate_unique_block_id('wysiwyg');

// Build dynamic attributes
$block_classes = 'container-fluid wysiwyg-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

// Use custom ID if provided, otherwise use unique ID
$block_id = $custom_id ? $custom_id : $unique_block_id;

// No inline styles - all spacing handled via CSS
$block_style = '';

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Build max width class
$width_class = 'wysiwyg-' . esc_attr($max_width);

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $block_style ? 'style="' . esc_attr($block_style) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="content">
    <div class="container">
        <div class="wysiwyg-content <?php echo esc_attr($width_class); ?>">
            <?php if ($wysiwyg) : ?>
                <?php echo wp_kses_post($wysiwyg); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Output responsive spacing CSS using unique block ID
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    /* Block-specific styles */
    .wysiwyg-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .wysiwyg-block .wysiwyg-content {
        /* Content wrapper styles */
    }

    /* Max width options */
    .wysiwyg-block .wysiwyg-narrow {
        max-width: 680px;
        margin: 0 auto;
    }

    .wysiwyg-block .wysiwyg-default {
        max-width: 900px;
        margin: 0 auto;
    }

    .wysiwyg-block .wysiwyg-wide {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Typography spacing within content area */
    .wysiwyg-block .wysiwyg-content > *:first-child {
        margin-top: 0;
    }

    .wysiwyg-block .wysiwyg-content > *:last-child {
        margin-bottom: 0;
    }

    .wysiwyg-block .wysiwyg-content p {
        margin-bottom: 1.2em;
    }

    .wysiwyg-block .wysiwyg-content ul,
    .wysiwyg-block .wysiwyg-content ol {
        margin-bottom: 1.2em;
        padding-left: 1.5em;
    }

    .wysiwyg-block .wysiwyg-content li {
        margin-bottom: 0.4em;
    }

    .wysiwyg-block .wysiwyg-content blockquote {
        margin: 1.5em 0;
        padding-left: 1.2em;
        border-left: 3px solid var(--primary);
    }

    .wysiwyg-block .wysiwyg-content img {
        max-width: 100%;
        height: auto;
    }

    /* Tablet Styles - 1199px and below */
    @media (max-width: 1199px) {
        .wysiwyg-block {
            /* Tablet responsive styles */
        }
    }

    /* Mobile Styles - 767px and below */
    @media (max-width: 767px) {
        .wysiwyg-block {
            /* Mobile responsive styles */
        }
    }
</style>