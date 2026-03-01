<?php

/**
 * CTA Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$heading = get_field('heading');
$content = get_field('content');
$button = get_field('button');
$background_color = get_field('background_color') ?: '';

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
$unique_block_id = generate_unique_block_id('cta');

// Build dynamic attributes
$block_classes = 'container-fluid cta-block';
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
if (!$heading && !$content) {
    echo 'Please add a heading or content for this block.';
    return;
}

// Build background color style
$bg_style = '';
if ($background_color) {
    $bg_style = 'background-color: ' . wp_strip_all_tags($background_color) . ';';
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> <?php echo $bg_style ? 'style="' . esc_attr($bg_style) . '"' : ''; ?>>
    <div class="container">
        <div class="cta-content">
            <?php if ($heading) : ?>
                <h2 class="cta-heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ($content) : ?>
                <p class="cta-text"><?php echo esc_html($content); ?></p>
            <?php endif; ?>
            <?php if ($button) : ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="cta-button" <?php echo $button['target'] ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .cta-block {
        background-color: var(--primary);
        padding: 80px 0;
    }

    .cta-block .cta-content {
        text-align: center;
        max-width: 700px;
        margin: 0 auto;
    }

    .cta-block .cta-heading {
        color: #fff;
        margin-bottom: 15px;
    }

    .cta-block .cta-text {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
    }

    .cta-block .cta-button {
        display: inline-block;
        padding: var(--button-padding);
        background-color: #fff;
        color: var(--primary);
        text-decoration: none;
        border-radius: var(--button-radius);
        font-weight: 600;
        transition: var(--transition-default);
    }

    .cta-block .cta-button:hover {
        opacity: 0.9;
        color: var(--primary);
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .cta-block {
            padding: 60px 0;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .cta-block {
            padding: 50px 0;
        }

        .cta-block .cta-content {
            padding: 0 15px;
        }
    }
</style>
