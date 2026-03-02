<?php

/**
 * About Block
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
$image = devq_get_image_or_placeholder('image', 700, 800, 'about-img');
$button = get_field('button');
$show_stats = get_field('show_stats');

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
$unique_block_id = generate_unique_block_id('about');

// Build dynamic attributes
$block_classes = 'container-fluid about-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation && !$is_recommended) {
    $aos_attributes = 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}
$animate = (!$disable_animation && $is_recommended);

// Check required fields
if (!$heading) {
    echo 'Please add a heading for the About block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="content">
    <div class="container">
        <div class="about-grid">
            <div class="about-image-col" <?php if ($animate) echo devq_aos('fade-right', 0, $animation_duration); ?>>
                <?php if ($image) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="about-image">
                <?php endif; ?>
            </div>
            <div class="about-text-col">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper about-eyebrow" <?php if ($animate) echo devq_aos('fade-left', 0, $animation_duration); ?>><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>

                <h2 class="about-heading" <?php if ($animate) echo devq_aos('fade-left', 100, $animation_duration); ?>><?php echo esc_html($heading); ?></h2>

                <?php if ($content) : ?>
                    <div class="about-content" <?php if ($animate) echo devq_aos('fade-left', 200, $animation_duration); ?>>
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>

                <?php if ($button) : ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="btn" <?php if ($animate) echo devq_aos('fade-left', 300, $animation_duration); ?> <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
                <?php endif; ?>

                <?php if ($show_stats && have_rows('stats')) : ?>
                    <div class="about-stats" <?php if ($animate) echo devq_aos('fade-up', 400, $animation_duration); ?>>
                        <?php while (have_rows('stats')) : the_row();
                            $number = get_sub_field('number');
                            $label = get_sub_field('label');
                            ?>
                            <div class="about-stat">
                                <?php if ($number) : ?>
                                    <div class="about-stat-number"><?php echo esc_html($number); ?></div>
                                <?php endif; ?>
                                <?php if ($label) : ?>
                                    <div class="about-stat-label"><?php echo esc_html($label); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .about-block {
        background-color: #fff;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .about-block .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .about-block .about-image {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 12px;
    }

    .about-block .about-eyebrow {
        display: block;
        margin-bottom: 15px;
    }

    .about-block .about-heading {
        margin-bottom: 20px;
    }

    .about-block .about-content {
        margin-bottom: 25px;
        color: #555;
        line-height: 1.7;
    }

    .about-block .about-stats {
        display: flex;
        gap: 40px;
        margin-top: 40px;
        border-top: 1px solid #e0e0e0;
        padding-top: 30px;
    }

    .about-block .about-stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        font-family: var(--font1);
        line-height: 1.2;
    }

    .about-block .about-stat-label {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .about-block .about-grid {
            gap: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .about-block .about-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .about-block .about-image-col {
            order: -1;
        }

        .about-block .about-stats {
            flex-wrap: wrap;
            gap: 25px;
        }

        .about-block .about-stat-number {
            font-size: 2rem;
        }
    }
</style>
