<?php
/**
 * Process Block
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
$unique_block_id = generate_unique_block_id('process');

// Build dynamic attributes
$block_classes = 'container-fluid process-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes (block-level for header only; steps get individual AOS)
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Check required fields
if (!have_rows('steps')) {
    echo 'Please add steps for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="lists">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="process-header" <?php echo $aos_attributes; ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper process-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="process-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="process-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('steps')) : $step_index = 1; ?>
            <div class="process-steps">
                <?php while (have_rows('steps')) : the_row();
                    $icon_class = get_sub_field('icon_class');
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    $delay = ($step_index - 1) * 150;
                    ?>
                    <div class="process-step" <?php if (!$disable_animation) : ?>data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                        <div class="process-step-number">
                            <?php if ($icon_class) : ?>
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            <?php else : ?>
                                <?php echo esc_html($step_index); ?>
                            <?php endif; ?>
                        </div>
                        <h3 class="process-step-title"><?php echo esc_html($title); ?></h3>
                        <?php if ($description) : ?>
                            <p class="process-step-description"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                    </div>
                <?php $step_index++; endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .process-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .process-block .process-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 70px;
    }

    .process-block .process-heading {
        margin-bottom: 0;
    }

    .process-block .process-subheading {
        color: #666;
        margin-top: 15px;
        line-height: 1.6;
    }

    .process-block .process-steps {
        display: flex;
        justify-content: center;
        gap: 40px;
        position: relative;
    }

    .process-block .process-steps::before {
        content: '';
        position: absolute;
        top: 45px;
        left: 15%;
        right: 15%;
        height: 2px;
        background: #e0e0e0;
        z-index: 0;
    }

    .process-block .process-step {
        flex: 1;
        max-width: 280px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .process-block .process-step-number {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        font-size: 1.5rem;
        font-weight: 800;
        font-family: var(--font1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        position: relative;
    }

    .process-block .process-step-number i {
        font-size: 1.5rem;
        color: #fff;
    }

    .process-block .process-step-title {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .process-block .process-step-description {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .process-block .process-steps {
            gap: 25px;
        }

        .process-block .process-steps::before {
            left: 10%;
            right: 10%;
        }

        .process-block .process-header {
            margin-bottom: 50px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .process-block .process-steps {
            flex-direction: column;
            align-items: center;
            gap: 40px;
        }

        .process-block .process-steps::before {
            display: none;
        }

        .process-block .process-step {
            max-width: 100%;
        }
    }
</style>
