<?php

/**
 * Text + Image Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$heading = get_field('heading');
$content = get_field('content');
$image = get_field('image');
$button = get_field('button');
$image_position = get_field('image_position') ?: 'right';

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
$unique_block_id = generate_unique_block_id('textimage');

// Build dynamic attributes
$block_classes = 'container-fluid textimage-block';
if ($image_position === 'left') {
    $block_classes .= ' textimage-image-left';
}
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
if (!$heading && !$content && !$image) {
    echo 'Please add content for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?>>
    <div class="container">
        <div class="textimage-grid">
            <div class="textimage-text">
                <?php if ($heading) : ?>
                    <h2 class="textimage-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($content) : ?>
                    <div class="textimage-content">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>
                <?php if ($button) : ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="textimage-button" <?php echo $button['target'] ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
                <?php endif; ?>
            </div>
            <div class="textimage-image">
                <?php if ($image) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .textimage-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .textimage-block .textimage-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .textimage-block.textimage-image-left .textimage-grid {
        direction: rtl;
    }

    .textimage-block.textimage-image-left .textimage-grid > * {
        direction: ltr;
    }

    .textimage-block .textimage-heading {
        margin-bottom: 20px;
    }

    .textimage-block .textimage-content {
        margin-bottom: 25px;
    }

    .textimage-block .textimage-button {
        display: inline-block;
        padding: var(--button-padding);
        background-color: var(--primary);
        color: #fff;
        text-decoration: none;
        border-radius: var(--button-radius);
        transition: var(--transition-default);
    }

    .textimage-block .textimage-button:hover {
        opacity: 0.9;
        color: #fff;
    }

    .textimage-block .textimage-image img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 4px;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .textimage-block .textimage-grid {
            gap: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .textimage-block .textimage-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .textimage-block.textimage-image-left .textimage-grid {
            direction: ltr;
        }

        .textimage-block .textimage-image {
            order: -1;
        }
    }
</style>
