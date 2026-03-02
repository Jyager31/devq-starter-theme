<?php

/**
 * Hero Split Block
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
$primary_button = get_field('primary_button');
$secondary_button = get_field('secondary_button');
$image = devq_get_image_or_placeholder('image', 800, 900, 'herosplit-img');
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
$unique_block_id = generate_unique_block_id('herosplit');

// Build dynamic attributes
$block_classes = 'container-fluid herosplit-block';
if ($image_position === 'left') {
    $block_classes .= ' herosplit-image-left';
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
if (!$heading && !$image) {
    echo 'Please add a heading or image for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="heroes">
    <div class="herosplit-grid">
        <div class="herosplit-text">
            <?php if ($eyebrow) : ?>
                <span class="cs-topper"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h1 class="herosplit-heading"><?php echo esc_html($heading); ?></h1>
            <?php endif; ?>
            <?php if ($content) : ?>
                <p class="herosplit-content"><?php echo esc_html($content); ?></p>
            <?php endif; ?>
            <?php if ($primary_button || $secondary_button) : ?>
                <div class="herosplit-buttons">
                    <?php if ($primary_button) : ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn" <?php echo $primary_button['target'] ? 'target="' . esc_attr($primary_button['target']) . '"' : ''; ?>><?php echo esc_html($primary_button['title']); ?></a>
                    <?php endif; ?>
                    <?php if ($secondary_button) : ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn btn-outline" <?php echo $secondary_button['target'] ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>><?php echo esc_html($secondary_button['title']); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="herosplit-image">
            <?php if ($image) : ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .herosplit-block {
        background-color: #f8f7f4;
        min-height: 85vh;
        display: flex;
        align-items: center;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .herosplit-block .herosplit-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .herosplit-block.herosplit-image-left .herosplit-grid {
        direction: rtl;
    }

    .herosplit-block.herosplit-image-left .herosplit-grid > * {
        direction: ltr;
    }

    .herosplit-block .herosplit-text .cs-topper {
        display: block;
        margin-bottom: 15px;
    }

    .herosplit-block .herosplit-heading {
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .herosplit-block .herosplit-content {
        margin-bottom: 30px;
        color: #555;
        line-height: 1.7;
    }

    .herosplit-block .herosplit-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    .herosplit-block .herosplit-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 12px;
        min-height: 500px;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .herosplit-block {
            min-height: auto;
        }

        .herosplit-block .herosplit-grid {
            gap: 40px;
            padding: 0 30px;
        }

        .herosplit-block .herosplit-image img {
            min-height: 400px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .herosplit-block .herosplit-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 15px;
        }

        .herosplit-block.herosplit-image-left .herosplit-grid {
            direction: ltr;
        }

        .herosplit-block .herosplit-image {
            order: -1;
        }

        .herosplit-block .herosplit-image img {
            min-height: 300px;
        }
    }
</style>
