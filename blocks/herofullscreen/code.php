<?php
/**
 * Hero Fullscreen Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$subheading = get_field('subheading');
$primary_button = get_field('primary_button');
$secondary_button = get_field('secondary_button');
$background_image = devq_get_image_or_placeholder('background_image', 1920, 1080, 'hero-fullscreen');
$overlay_color = get_field('overlay_color') ?: '#000000';
$overlay_opacity = get_field('overlay_opacity') ?: 50;

// Layout Tab Fields
$content_alignment = get_field('content_alignment') ?: 'center';
$content_width = get_field('content_width') ?: 'default';
$vertical_position = get_field('vertical_position') ?: 'center';
$show_scroll_indicator = get_field('show_scroll_indicator');
if ($show_scroll_indicator === null) $show_scroll_indicator = true;

// Options Tab Fields
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
$unique_block_id = generate_unique_block_id('herofullscreen');

// Build dynamic attributes
$block_classes = 'container-fluid herofullscreen-block';
$block_classes .= ' herofullscreen-align-' . esc_attr($content_alignment);
$block_classes .= ' herofullscreen-width-' . esc_attr($content_width);
$block_classes .= ' herofullscreen-vpos-' . esc_attr($vertical_position);
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
    echo 'Please add a heading for the Hero Fullscreen block.';
    return;
}

// Calculate overlay opacity
$overlay_opacity_decimal = intval($overlay_opacity) / 100;

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="heroes">

    <!-- Background -->
    <?php if ($background_image) : ?>
        <div class="herofullscreen-background" style="background-image: url('<?php echo esc_url($background_image['url']); ?>');">
            <div class="herofullscreen-overlay" style="background-color: <?php echo esc_attr($overlay_color); ?>; opacity: <?php echo esc_attr($overlay_opacity_decimal); ?>;"></div>
        </div>
    <?php endif; ?>

    <!-- Bottom gradient for text readability -->
    <div class="herofullscreen-gradient"></div>

    <!-- Content -->
    <div class="container">
        <div class="herofullscreen-content">
            <?php if ($eyebrow) : ?>
                <span class="cs-topper herofullscreen-eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>

            <h1 class="herofullscreen-heading"><?php echo esc_html($heading); ?></h1>

            <?php if ($subheading) : ?>
                <p class="herofullscreen-subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($primary_button || $secondary_button) : ?>
                <div class="herofullscreen-buttons">
                    <?php if ($primary_button) : ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn-inline btn-primary" <?php echo !empty($primary_button['target']) ? 'target="' . esc_attr($primary_button['target']) . '"' : ''; ?>><?php echo esc_html($primary_button['title']); ?></a>
                    <?php endif; ?>
                    <?php if ($secondary_button) : ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn-inline btn-outline-white" <?php echo !empty($secondary_button['target']) ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>><?php echo esc_html($secondary_button['title']); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($show_scroll_indicator) : ?>
        <div class="herofullscreen-scroll-indicator">
            <div class="herofullscreen-scroll-line">
                <span class="herofullscreen-scroll-text">Scroll</span>
                <span class="herofullscreen-scroll-bar"></span>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .herofullscreen-block {
        position: relative;
        min-height: 100vh;
        display: flex;
        overflow: hidden;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    /* Vertical position */
    .herofullscreen-block.herofullscreen-vpos-center { align-items: center; }
    .herofullscreen-block.herofullscreen-vpos-top { align-items: flex-start; padding-top: 120px; }
    .herofullscreen-block.herofullscreen-vpos-bottom { align-items: flex-end; padding-bottom: 120px; }

    /* Background */
    .herofullscreen-background {
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

    .herofullscreen-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    /* Subtle bottom gradient for readability */
    .herofullscreen-gradient {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.3) 0%, transparent 100%);
        z-index: 2;
        pointer-events: none;
    }

    /* Content */
    .herofullscreen-block .container {
        position: relative;
        z-index: 3;
        width: 100%;
    }

    .herofullscreen-content {
        color: #fff;
        max-width: 800px;
    }

    /* Content width */
    .herofullscreen-block.herofullscreen-width-narrow .herofullscreen-content { max-width: 600px; }
    .herofullscreen-block.herofullscreen-width-default .herofullscreen-content { max-width: 800px; }
    .herofullscreen-block.herofullscreen-width-wide .herofullscreen-content { max-width: 1000px; }

    /* Alignment */
    .herofullscreen-block.herofullscreen-align-center .herofullscreen-content {
        text-align: center;
        margin: 0 auto;
    }
    .herofullscreen-block.herofullscreen-align-center .herofullscreen-buttons { justify-content: center; }
    .herofullscreen-block.herofullscreen-align-center .herofullscreen-subheading { margin-left: auto; margin-right: auto; }

    .herofullscreen-block.herofullscreen-align-left .herofullscreen-content {
        text-align: left;
        margin: 0;
    }
    .herofullscreen-block.herofullscreen-align-left .herofullscreen-buttons { justify-content: flex-start; }

    .herofullscreen-block.herofullscreen-align-right .herofullscreen-content {
        text-align: right;
        margin: 0 0 0 auto;
    }
    .herofullscreen-block.herofullscreen-align-right .herofullscreen-buttons { justify-content: flex-end; }

    .herofullscreen-eyebrow {
        display: block;
        margin-bottom: 16px;
        color: rgba(255, 255, 255, 0.85);
    }

    .herofullscreen-heading {
        color: #fff;
        margin-bottom: 20px;
        line-height: 1.05;
    }

    .herofullscreen-subheading {
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 36px;
        max-width: 600px;
        line-height: 1.6;
    }

    .herofullscreen-buttons {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Scroll indicator — elegant line style */
    .herofullscreen-scroll-indicator {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 4;
    }

    .herofullscreen-scroll-line {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .herofullscreen-scroll-text {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: rgba(255, 255, 255, 0.6);
        font-family: var(--font2);
        font-weight: 600;
    }

    .herofullscreen-scroll-bar {
        display: block;
        width: 1px;
        height: 40px;
        background: rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .herofullscreen-scroll-bar::after {
        content: '';
        position: absolute;
        top: -100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        animation: herofullscreen-scroll-line 2s infinite;
    }

    @keyframes herofullscreen-scroll-line {
        0% { top: -100%; }
        50% { top: 0; }
        100% { top: 100%; }
    }

    /* Tablet */
    @media (max-width: 1199px) {
        .herofullscreen-block {
            min-height: 90vh;
        }
        .herofullscreen-block.herofullscreen-vpos-top { padding-top: 80px; }
        .herofullscreen-block.herofullscreen-vpos-bottom { padding-bottom: 80px; }
    }

    /* Mobile */
    @media (max-width: 767px) {
        .herofullscreen-block {
            min-height: 85vh;
        }
        .herofullscreen-block.herofullscreen-vpos-top { padding-top: 60px; }
        .herofullscreen-block.herofullscreen-vpos-bottom { padding-bottom: 60px; }

        .herofullscreen-content {
            padding: 0 15px;
        }

        .herofullscreen-subheading {
            margin-bottom: 24px;
        }

        .herofullscreen-buttons {
            flex-direction: column;
            gap: 12px;
        }

        .herofullscreen-block.herofullscreen-align-right .herofullscreen-content {
            text-align: center;
            margin: 0 auto;
        }
        .herofullscreen-block.herofullscreen-align-right .herofullscreen-buttons { justify-content: center; }

        .herofullscreen-scroll-indicator {
            bottom: 25px;
        }
    }
</style>
