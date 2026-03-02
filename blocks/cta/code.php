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
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$content = get_field('content');
$button = get_field('button');
$background = get_field('background') ?: 'primary';
$custom_background_color = get_field('custom_background_color') ?: '';

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
$block_classes = 'container-fluid cta-block cta-bg-' . esc_attr($background);
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
if (!$heading) {
    echo 'Please add a heading for the CTA block.';
    return;
}

// Build background style for custom color
$bg_style = '';
if ($background === 'custom' && $custom_background_color) {
    $bg_style = 'background-color: ' . wp_strip_all_tags($custom_background_color) . ';';
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> <?php echo $bg_style ? 'style="' . esc_attr($bg_style) . '"' : ''; ?> data-block-category="conversion">
    <div class="container">
        <div class="cta-content">
            <?php if ($eyebrow) : ?>
                <span class="cs-topper cta-eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>

            <h2 class="cta-heading"><?php echo esc_html($heading); ?></h2>

            <?php if ($content) : ?>
                <p class="cta-text"><?php echo esc_html($content); ?></p>
            <?php endif; ?>

            <?php if ($button) : ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="btn-inline btn-white" <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .cta-block {
        padding: 100px 0;
    }

    .cta-block.cta-bg-primary {
        background-color: var(--primary);
    }

    .cta-block.cta-bg-secondary {
        background-color: var(--secondary);
    }

    .cta-block.cta-bg-dark {
        background-color: #1a1a2e;
    }

    .cta-block .cta-content {
        text-align: center;
        max-width: 750px;
        margin: 0 auto;
    }

    .cta-block .cta-eyebrow {
        display: block;
        margin-bottom: 15px;
        color: rgba(255, 255, 255, 0.85);
    }

    .cta-block .cta-heading {
        color: #fff;
        margin-bottom: 15px;
    }

    .cta-block .cta-text {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 35px;
        line-height: 1.7;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .cta-block {
            padding: 70px 0;
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
