<?php
/**
 * Timeline Block
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
$unique_block_id = generate_unique_block_id('timeline');

// Build dynamic attributes
$block_classes = 'container-fluid timeline-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes for the overall block
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Check required fields
if (!have_rows('items')) {
    echo 'Please add timeline items for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="lists">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="timeline-header">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper timeline-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="timeline-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="timeline-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="timeline-track">
            <div class="timeline-line"></div>
            <?php
            $index = 0;
            while (have_rows('items')) : the_row();
                $date = get_sub_field('date');
                $icon_class = get_sub_field('icon_class');
                $title = get_sub_field('title');
                $description = get_sub_field('description');

                // Alternate left/right
                $side_class = ($index % 2 === 0) ? 'timeline-left' : 'timeline-right';

                // Staggered animation delay
                $item_aos = '';
                if (!$disable_animation) {
                    $delay = $index * 150;
                    $item_aos = 'data-aos="fade-up" data-aos-delay="' . esc_attr($delay) . '"';
                }
                ?>
                <div class="timeline-item <?php echo esc_attr($side_class); ?>" <?php echo $item_aos; ?>>
                    <div class="timeline-dot">
                        <?php if ($icon_class) : ?>
                            <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        <?php endif; ?>
                    </div>
                    <div class="timeline-content">
                        <?php if ($date) : ?>
                            <span class="timeline-date"><?php echo esc_html($date); ?></span>
                        <?php endif; ?>
                        <?php if ($title) : ?>
                            <h3 class="timeline-title"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                        <?php if ($description) : ?>
                            <p class="timeline-description"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                $index++;
            endwhile;
            ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .timeline-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .timeline-block .timeline-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .timeline-block .timeline-heading {
        margin-bottom: 0;
    }

    .timeline-block .timeline-subheading {
        color: #666;
        margin-top: 15px;
        line-height: 1.6;
    }

    .timeline-block .timeline-track {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-block .timeline-line {
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
        transform: translateX(-50%);
    }

    .timeline-block .timeline-item {
        position: relative;
        width: 50%;
        padding: 0 40px 40px;
        box-sizing: border-box;
    }

    .timeline-block .timeline-left {
        text-align: right;
        padding-right: 40px;
        padding-left: 0;
    }

    .timeline-block .timeline-right {
        margin-left: 50%;
        padding-left: 40px;
        padding-right: 0;
    }

    .timeline-block .timeline-dot {
        position: absolute;
        top: 5px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        box-shadow: 0 0 0 3px #fff, 0 0 0 5px var(--primary);
    }

    .timeline-block .timeline-left .timeline-dot {
        right: -20px;
    }

    .timeline-block .timeline-right .timeline-dot {
        left: -20px;
    }

    .timeline-block .timeline-content {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
    }

    .timeline-block .timeline-date {
        display: inline-block;
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
        font-family: var(--font2);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .timeline-block .timeline-title {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .timeline-block .timeline-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .timeline-block .timeline-header {
            margin-bottom: 40px;
        }

        .timeline-block .timeline-content {
            padding: 25px;
        }

        .timeline-block .timeline-item {
            padding-bottom: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .timeline-block .timeline-line {
            left: 20px;
            transform: none;
        }

        .timeline-block .timeline-item {
            width: 100%;
            padding-left: 0;
            padding-right: 0;
            margin-left: 0;
            text-align: left;
        }

        .timeline-block .timeline-left,
        .timeline-block .timeline-right {
            margin-left: 50px;
            padding-left: 20px;
            padding-right: 0;
            text-align: left;
        }

        .timeline-block .timeline-left .timeline-dot,
        .timeline-block .timeline-right .timeline-dot {
            left: -50px;
            right: auto;
        }

        .timeline-block .timeline-content {
            padding: 20px;
        }

        .timeline-block .timeline-header {
            margin-bottom: 30px;
        }
    }
</style>
