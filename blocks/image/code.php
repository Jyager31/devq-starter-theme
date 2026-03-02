<?php

/**
 * Image Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Get all fields first
$image = devq_get_image_or_placeholder('image', 1200, 600, 'image-block');
$custom_mobile_image = get_field('custom_mobile_image'); // true/false
$mobile_image = devq_get_image_or_placeholder('mobile_image', 600, 800, 'image-mobile');
$fluid = get_field('fluid'); // true/false for container vs container-fluid

// Options Tab Fields (always include these)
$margin_top = get_field('margin_top') ?: '';
$margin_bottom = get_field('margin_bottom') ?: '';
$margin_top_other = get_field('margin_top_other') ?: 0;
$margin_bottom_other = get_field('margin_bottom_other') ?: 0;
$custom_class = get_field('custom_class');
$custom_id = get_field('custom_id');

// Animation Tab Fields
$animation_type = get_field('animation_type') ?: 'recommended';
$animation_duration = get_field('animation_duration') ?: 800;
$disable_animation = get_field('disable_animation');
$is_recommended = ($animation_type === 'recommended');

// Generate unique block ID
$unique_block_id = generate_unique_block_id('image');

// Build dynamic attributes
$block_classes = 'container-fluid image-block';
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
    if ($is_recommended) {
        $aos_attributes = devq_aos('zoom-in', 0, $animation_duration);
    } else {
        $aos_attributes = 'data-aos="' . esc_attr($animation_type) . '"';
        if ($animation_duration != 800) {
            $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
        }
    }
}

// Check required fields
if (!$image) {
    echo 'Please select an image for this block.';
    return;
}

// Determine container class based on the fluid selection
$inner_container_class = $fluid ? 'container' : '';

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $block_style ? 'style="' . esc_attr($block_style) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="media">
    <?php if ($fluid) : ?>
        <div class="container">
            <div class="image-content">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="main-image <?php echo $custom_mobile_image ? 'desktop-only' : ''; ?>">
                <?php if ($custom_mobile_image && $mobile_image) : ?>
                    <img src="<?php echo esc_url($mobile_image['url']); ?>" alt="<?php echo esc_attr($mobile_image['alt']); ?>" class="mobile-image mobile-only">
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="image-content">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="main-image <?php echo $custom_mobile_image ? 'desktop-only' : ''; ?>">
            <?php if ($custom_mobile_image && $mobile_image) : ?>
                <img src="<?php echo esc_url($mobile_image['url']); ?>" alt="<?php echo esc_attr($mobile_image['alt']); ?>" class="mobile-image mobile-only">
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php
// Output responsive spacing CSS using unique block ID
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    /* Block-specific styles */
    .image-block {
        /* Base styles */
    }

    .image-block .image-content {
        position: relative;
    }

    .image-block .main-image {
        width: 100%;
        height: auto;
        display: block;
    }

    .image-block .mobile-image {
        width: 100%;
        height: auto;
        display: none;
    }

    .image-block .desktop-only {
        display: block;
    }

    .image-block .mobile-only {
        display: none;
    }

    /* Tablet Styles - 1199px and below */
    @media (max-width: 1199px) {
        .image-block {
            /* Tablet responsive styles */
        }
    }

    /* Mobile Styles - 767px and below */
    @media (max-width: 767px) {
        .image-block .desktop-only {
            display: none;
        }

        .image-block .mobile-only {
            display: block;
        }
    }
</style>