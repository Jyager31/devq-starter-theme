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

// Layout Tab Fields
$content_alignment = get_field('content_alignment') ?: 'center';
$content_width = get_field('content_width') ?: 'default';
$height = get_field('height') ?: 'large';
$vertical_position = get_field('vertical_position') ?: 'center';
$show_scroll_indicator = get_field('show_scroll_indicator');

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
$block_classes .= ' hero-align-' . esc_attr($content_alignment);
$block_classes .= ' hero-width-' . esc_attr($content_width);
$block_classes .= ' hero-height-' . esc_attr($height);
$block_classes .= ' hero-vpos-' . esc_attr($vertical_position);
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
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn" <?php echo !empty($primary_button['target']) ? 'target="' . esc_attr($primary_button['target']) . '"' : ''; ?>><?php echo esc_html($primary_button['title']); ?></a>
                    <?php endif; ?>

                    <?php if ($secondary_button) : ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn <?php echo $is_dark_bg ? 'btn-outline-white' : 'btn-outline'; ?>" <?php echo !empty($secondary_button['target']) ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>><?php echo esc_html($secondary_button['title']); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($show_scroll_indicator) : ?>
        <div class="hero-scroll-indicator">
            <span class="hero-scroll-chevron"></span>
        </div>
    <?php endif; ?>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .hero-block {
        position: relative;
        display: flex;
        overflow: hidden;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    /* Height variants */
    .hero-block.hero-height-full { min-height: 100vh; }
    .hero-block.hero-height-large { min-height: 85vh; }
    .hero-block.hero-height-medium { min-height: 65vh; }
    .hero-block.hero-height-auto { min-height: 0; }

    /* Vertical position */
    .hero-block.hero-vpos-center { align-items: center; }
    .hero-block.hero-vpos-top { align-items: flex-start; padding-top: 120px; }
    .hero-block.hero-vpos-bottom { align-items: flex-end; padding-bottom: 120px; }

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
        width: 100%;
    }

    .hero-block .hero-content {
        max-width: 800px;
    }

    /* Content width variants */
    .hero-block.hero-width-narrow .hero-content { max-width: 600px; }
    .hero-block.hero-width-default .hero-content { max-width: 800px; }
    .hero-block.hero-width-wide .hero-content { max-width: 1000px; }

    /* Content alignment variants */
    .hero-block.hero-align-center .hero-content {
        text-align: center;
        margin: 0 auto;
    }
    .hero-block.hero-align-center .hero-buttons { justify-content: center; }
    .hero-block.hero-align-center .hero-subheading { margin-left: auto; margin-right: auto; }

    .hero-block.hero-align-left .hero-content {
        text-align: left;
        margin: 0;
    }
    .hero-block.hero-align-left .hero-buttons { justify-content: flex-start; }
    .hero-block.hero-align-left .hero-subheading { margin-left: 0; margin-right: 0; }

    .hero-block.hero-align-right .hero-content {
        text-align: right;
        margin: 0 0 0 auto;
    }
    .hero-block.hero-align-right .hero-buttons { justify-content: flex-end; }
    .hero-block.hero-align-right .hero-subheading { margin-left: auto; margin-right: 0; }

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
        line-height: 1.6;
    }

    .hero-block .hero-buttons {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Scroll indicator */
    .hero-scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 4;
    }

    .hero-scroll-chevron {
        display: block;
        width: 30px;
        height: 30px;
        border-right: 2px solid rgba(255, 255, 255, 0.7);
        border-bottom: 2px solid rgba(255, 255, 255, 0.7);
        transform: rotate(45deg);
        animation: hero-scroll-bounce 2s infinite;
    }

    .hero-block.hero-style-solid .hero-scroll-chevron {
        border-color: rgba(0, 0, 0, 0.3);
    }

    @keyframes hero-scroll-bounce {
        0%, 20%, 50%, 80%, 100% { transform: rotate(45deg) translateY(0); }
        40% { transform: rotate(45deg) translateY(10px); }
        60% { transform: rotate(45deg) translateY(5px); }
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .hero-block.hero-height-full { min-height: 85vh; }
        .hero-block.hero-height-large { min-height: 70vh; }
        .hero-block.hero-height-medium { min-height: 55vh; }
        .hero-block.hero-vpos-top { padding-top: 80px; }
        .hero-block.hero-vpos-bottom { padding-bottom: 80px; }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .hero-block.hero-height-full { min-height: 75vh; }
        .hero-block.hero-height-large { min-height: 60vh; }
        .hero-block.hero-height-medium { min-height: 50vh; }
        .hero-block.hero-vpos-top { padding-top: 60px; }
        .hero-block.hero-vpos-bottom { padding-bottom: 60px; }

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

        /* Force center on mobile for better readability */
        .hero-block.hero-align-right .hero-content {
            text-align: center;
            margin: 0 auto;
        }
        .hero-block.hero-align-right .hero-buttons { justify-content: center; }
    }
</style>
