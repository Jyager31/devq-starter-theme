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
$heading = get_field('heading');
$subheading = get_field('subheading');
$button = get_field('button');
$background_image = get_field('background_image');
$overlay_opacity = get_field('overlay_opacity') ?: 50;

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
$block_classes = 'container-fluid hero-block';
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
if (!$heading && !$background_image) {
    echo 'Please add a heading or background image for this block.';
    return;
}

// Calculate overlay opacity as decimal
$overlay_opacity_decimal = intval($overlay_opacity) / 100;

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?>>
    <?php if ($background_image) : ?>
        <div class="hero-background" style="background-image: url('<?php echo esc_url($background_image['url']); ?>');">
            <div class="hero-overlay" style="opacity: <?php echo esc_attr($overlay_opacity_decimal); ?>;"></div>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="hero-content">
            <?php if ($heading) : ?>
                <h1 class="hero-heading"><?php echo esc_html($heading); ?></h1>
            <?php endif; ?>
            <?php if ($subheading) : ?>
                <p class="hero-subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>
            <?php if ($button) : ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="hero-button" <?php echo $button['target'] ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
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
        min-height: 100vh;
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
        background-color: #000;
        z-index: 2;
    }

    .hero-block .container {
        position: relative;
        z-index: 3;
    }

    .hero-block .hero-content {
        text-align: center;
        color: #fff;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-block .hero-heading {
        color: #fff;
        margin-bottom: 20px;
    }

    .hero-block .hero-subheading {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-block .hero-button {
        display: inline-block;
        padding: var(--button-padding);
        background-color: var(--primary);
        color: #fff;
        text-decoration: none;
        border-radius: var(--button-radius);
        transition: var(--transition-default);
    }

    .hero-block .hero-button:hover {
        opacity: 0.9;
        color: #fff;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .hero-block {
            min-height: 80vh;
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
    }
</style>
