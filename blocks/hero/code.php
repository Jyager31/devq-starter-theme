<?php

/**
 * Hero Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$style = get_field('style') ?: 'image';
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$subheading = get_field('subheading');
$primary_button = get_field('primary_button');
$secondary_button = get_field('secondary_button');
$background_image = devq_get_image_or_placeholder('background_image', 1920, 1080, 'hero-bg');
$overlay_color = get_field('overlay_color') ?: '#000000';
$overlay_opacity = get_field('overlay_opacity') ?: 50;
$gradient_start = get_field('gradient_start') ?: '#0a0a0a';
$gradient_end = get_field('gradient_end') ?: '#1a1a2e';
$background_color = get_field('background_color') ?: '#0a0a0a';

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
$unique_block_id = generate_unique_block_id('hero');

// Build dynamic attributes
$block_classes = 'container-fluid hero-block hero-style-' . esc_attr($style);
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
    echo 'Please add a heading for the Hero block.';
    return;
}

// Calculate overlay opacity as decimal
$overlay_opacity_decimal = intval($overlay_opacity) / 100;

// Determine if this is a dark background style (for button contrast)
$is_dark_bg = ($style === 'image' || $style === 'gradient');

// Build inline background styles based on style selection
$bg_style = '';
if ($style === 'image' && $background_image) {
    $bg_style = 'background-image: url(\'' . esc_url($background_image['url']) . '\');';
} elseif ($style === 'gradient') {
    $bg_style = 'background: linear-gradient(135deg, ' . esc_attr($gradient_start) . ' 0%, ' . esc_attr($gradient_end) . ' 100%);';
} elseif ($style === 'solid') {
    $bg_style = 'background-color: ' . esc_attr($background_color) . ';';
}

// Determine text color based on background style
$text_class = $is_dark_bg ? 'hero-text-light' : 'hero-text-dark';

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="heroes">

    <?php if ($style === 'image' && $background_image) : ?>
        <div class="hero-background" style="<?php echo $bg_style; ?>">
            <div class="hero-overlay" style="background-color: <?php echo esc_attr($overlay_color); ?>; opacity: <?php echo esc_attr($overlay_opacity_decimal); ?>;"></div>
        </div>
    <?php elseif ($style === 'gradient') : ?>
        <div class="hero-background" style="<?php echo $bg_style; ?>"></div>
    <?php elseif ($style === 'solid') : ?>
        <div class="hero-background" style="<?php echo $bg_style; ?>"></div>
    <?php endif; ?>

    <div class="container">
        <div class="hero-content <?php echo esc_attr($text_class); ?>">
            <?php if ($eyebrow) : ?>
                <span class="cs-topper hero-eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>

            <h1 class="hero-heading"><?php echo esc_html($heading); ?></h1>

            <?php if ($subheading) : ?>
                <p class="hero-subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($primary_button || $secondary_button) : ?>
                <div class="hero-buttons">
                    <?php if ($primary_button) : ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn-inline btn-primary" <?php echo !empty($primary_button['target']) ? 'target="' . esc_attr($primary_button['target']) . '"' : ''; ?>><?php echo esc_html($primary_button['title']); ?></a>
                    <?php endif; ?>

                    <?php if ($secondary_button) : ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn-inline <?php echo $is_dark_bg ? 'btn-outline-white' : 'btn-outline'; ?>" <?php echo !empty($secondary_button['target']) ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>><?php echo esc_html($secondary_button['title']); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .hero-block {
        position: relative;
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .hero-block .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1;
    }

    .hero-block .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    .hero-block .container {
        position: relative;
        z-index: 3;
    }

    .hero-block .hero-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Light text for dark backgrounds (image / gradient) */
    .hero-block .hero-text-light {
        color: #fff;
    }

    .hero-block .hero-text-light .cs-topper {
        color: rgba(255, 255, 255, 0.85);
    }

    .hero-block .hero-text-light .hero-heading {
        color: #fff;
    }

    .hero-block .hero-text-light .hero-subheading {
        color: rgba(255, 255, 255, 0.85);
    }

    /* Dark text for solid / light backgrounds */
    .hero-block .hero-text-dark .cs-topper {
        color: var(--secondary);
    }

    .hero-block .hero-text-dark .hero-heading {
        color: var(--primary);
    }

    .hero-block .hero-text-dark .hero-subheading {
        color: #555;
    }

    .hero-block .hero-eyebrow {
        display: block;
        margin-bottom: 16px;
    }

    .hero-block .hero-heading {
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .hero-block .hero-subheading {
        margin-bottom: 32px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .hero-block .hero-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .hero-block {
            min-height: 70vh;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .hero-block {
            min-height: 60vh;
        }

        .hero-block .hero-content {
            padding: 0 15px;
        }

        .hero-block .hero-subheading {
            margin-bottom: 24px;
        }

        .hero-block .hero-buttons {
            flex-direction: column;
            gap: 12px;
        }
    }
</style>
