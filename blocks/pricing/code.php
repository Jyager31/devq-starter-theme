<?php

/**
 * Pricing Block
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
$unique_block_id = generate_unique_block_id('pricing');

// Build dynamic attributes
$block_classes = 'container-fluid pricing-block';
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
if (!have_rows('plans')) {
    echo 'Please add pricing plans for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="cards">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="pricing-header">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper pricing-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="pricing-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="pricing-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('plans')) : ?>
            <div class="pricing-grid">
                <?php
                $plan_index = 0;
                while (have_rows('plans')) : the_row();
                    $name = get_sub_field('name');
                    $price = get_sub_field('price');
                    $period = get_sub_field('period');
                    $description = get_sub_field('description');
                    $features = get_sub_field('features');
                    $button = get_sub_field('button');
                    $is_featured = get_sub_field('is_featured');

                    $plan_classes = 'pricing-plan';
                    if ($is_featured) {
                        $plan_classes .= ' pricing-plan-featured';
                    }

                    // Staggered animation delay
                    $plan_aos = '';
                    if (!$disable_animation) {
                        $delay = $plan_index * 150;
                        $plan_aos = 'data-aos="fade-up" data-aos-delay="' . esc_attr($delay) . '"';
                    }
                    ?>
                    <div class="<?php echo esc_attr($plan_classes); ?>" <?php echo $plan_aos; ?>>
                        <?php if ($is_featured) : ?>
                            <span class="pricing-badge">Most Popular</span>
                        <?php endif; ?>

                        <?php if ($name) : ?>
                            <div class="pricing-plan-name"><?php echo esc_html($name); ?></div>
                        <?php endif; ?>

                        <?php if ($price) : ?>
                            <div class="pricing-price"><?php echo esc_html($price); ?></div>
                        <?php endif; ?>

                        <?php if ($period) : ?>
                            <span class="pricing-period"><?php echo esc_html($period); ?></span>
                        <?php endif; ?>

                        <?php if ($description) : ?>
                            <p class="pricing-description"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>

                        <?php if ($features) :
                            $feature_lines = explode("\n", $features);
                            ?>
                            <ul class="pricing-features">
                                <?php foreach ($feature_lines as $feature) :
                                    $feature = trim($feature);
                                    if ($feature) : ?>
                                        <li class="pricing-feature"><?php echo esc_html($feature); ?></li>
                                    <?php endif;
                                endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($button) : ?>
                            <a href="<?php echo esc_url($button['url']); ?>" class="btn <?php echo $is_featured ? '' : 'btn-outline'; ?> pricing-button" <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php
                    $plan_index++;
                endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .pricing-block {
        background: #f8f7f4;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .pricing-block .pricing-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .pricing-block .pricing-eyebrow {
        display: block;
        margin-bottom: 16px;
    }

    .pricing-block .pricing-heading {
        margin-bottom: 15px;
    }

    .pricing-block .pricing-subheading {
        color: #666;
    }

    .pricing-block .pricing-grid {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .pricing-block .pricing-plan {
        flex: 1;
        max-width: 380px;
        min-width: 280px;
        background: #fff;
        border-radius: 16px;
        padding: 45px 35px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        transition: var(--transition-default);
        position: relative;
        text-align: center;
    }

    .pricing-block .pricing-plan:hover {
        transform: translateY(-5px);
    }

    .pricing-block .pricing-plan-featured {
        border: 2px solid var(--primary);
        transform: scale(1.05);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
    }

    .pricing-block .pricing-plan-featured:hover {
        transform: scale(1.05) translateY(-5px);
    }

    .pricing-block .pricing-badge {
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--primary);
        color: #fff;
        padding: 5px 20px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .pricing-block .pricing-plan-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--primary);
    }

    .pricing-block .pricing-price {
        font-size: 3.5rem;
        font-weight: 800;
        font-family: var(--font1);
        color: #1a1a2e;
        line-height: 1;
    }

    .pricing-block .pricing-period {
        font-size: 14px;
        color: #999;
        margin-bottom: 20px;
        display: block;
    }

    .pricing-block .pricing-description {
        color: #666;
        margin-bottom: 25px;
        font-size: 15px;
    }

    .pricing-block .pricing-features {
        list-style: none;
        padding: 0;
        margin: 0 0 30px;
        text-align: left;
    }

    .pricing-block .pricing-feature {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        position: relative;
        padding-left: 25px;
    }

    .pricing-block .pricing-feature::before {
        content: "\2713";
        color: var(--primary);
        font-weight: 700;
        position: absolute;
        left: 0;
    }

    .pricing-block .pricing-button {
        width: 100%;
        justify-content: center;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .pricing-block .pricing-grid {
            flex-wrap: wrap;
        }

        .pricing-block .pricing-plan {
            max-width: 350px;
        }

        .pricing-block .pricing-header {
            margin-bottom: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .pricing-block .pricing-grid {
            flex-direction: column;
            align-items: center;
        }

        .pricing-block .pricing-plan {
            max-width: 100%;
            min-width: 0;
            width: 100%;
        }

        .pricing-block .pricing-plan-featured {
            transform: none;
        }

        .pricing-block .pricing-plan-featured:hover {
            transform: translateY(-5px);
        }

        .pricing-block .pricing-header {
            margin-bottom: 30px;
        }
    }
</style>
