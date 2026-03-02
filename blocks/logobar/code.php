<?php
/**
 * Logo Bar Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$heading = get_field('heading');
$grayscale = get_field('grayscale');

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

// Generate unique block ID
$unique_block_id = generate_unique_block_id('logobar');

// Build dynamic attributes
$block_classes = 'container-fluid logobar-block';
if ($grayscale) {
    $block_classes .= ' logobar-grayscale';
}
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$is_recommended = ($animation_type === 'recommended');
$aos_attributes = '';
if (!$disable_animation && !$is_recommended) {
    $aos_attributes = 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}
$label_aos = (!$disable_animation && $is_recommended) ? devq_aos('fade-up', 0, $animation_duration) : '';
$stagger = (!$disable_animation && $is_recommended);

// Check required fields
if (!have_rows('logos')) {
    echo 'Please add at least one logo for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="socialproof">
    <div class="container">
        <?php if ($heading) : ?>
            <p class="logobar-label" <?php echo $label_aos; ?>><?php echo esc_html($heading); ?></p>
        <?php endif; ?>

        <?php if (have_rows('logos')) : ?>
            <div class="logobar-logos">
                <?php $logo_index = 0; while (have_rows('logos')) : the_row();
                    $logo = devq_get_image_or_placeholder('logo', 200, 80, 'logo-' . $logo_index, true);
                    $link = get_sub_field('link');
                    $logo_delay = $logo_index * 80;
                    ?>
                    <div class="logobar-item" <?php if ($stagger) echo devq_aos('fade-up', $logo_delay, $animation_duration); ?>>
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link); ?>" class="logobar-logo-link" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" class="logobar-logo">
                            </a>
                        <?php else : ?>
                            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" class="logobar-logo">
                        <?php endif; ?>
                    </div>
                <?php $logo_index++; endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .logobar-block {
        padding: 60px 0;
    }

    .logobar-block .logobar-label {
        text-align: center;
        margin-bottom: 40px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #999;
        font-weight: 600;
    }

    .logobar-block .logobar-logos {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 50px;
    }

    .logobar-block .logobar-logo {
        max-height: 50px;
        width: auto;
        max-width: 150px;
        object-fit: contain;
    }

    .logobar-block .logobar-item {
        display: inline-flex;
        align-items: center;
    }

    .logobar-block .logobar-logo-link {
        display: inline-flex;
        align-items: center;
    }

    .logobar-block.logobar-grayscale .logobar-logo {
        filter: grayscale(100%);
        opacity: 0.6;
        transition: var(--transition-default);
    }

    .logobar-block.logobar-grayscale .logobar-logo:hover,
    .logobar-block.logobar-grayscale .logobar-logo-link:hover .logobar-logo {
        filter: grayscale(0%);
        opacity: 1;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .logobar-block .logobar-logos {
            gap: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .logobar-block .logobar-logos {
            gap: 30px;
            justify-content: center;
        }

        .logobar-block .logobar-logo {
            max-height: 40px;
        }
    }
</style>
