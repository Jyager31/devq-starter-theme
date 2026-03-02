<?php
/**
 * Features List Block
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
$columns = get_field('columns') ?: '2';

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
$unique_block_id = generate_unique_block_id('featureslist');

// Build dynamic attributes
$block_classes = 'container-fluid featureslist-block featureslist-cols-' . esc_attr($columns);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes (block-level for header only; features get individual AOS)
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Check required fields
if (!$heading && !have_rows('features')) {
    echo 'Please add a heading or features for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="lists">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="featureslist-header" <?php echo $aos_attributes; ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper featureslist-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="featureslist-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="featureslist-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('features')) : $feat_index = 0; ?>
            <div class="featureslist-grid">
                <?php while (have_rows('features')) : the_row();
                    $icon_class = get_sub_field('icon_class');
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    $delay = $feat_index * 80;
                    ?>
                    <div class="featureslist-item" <?php if (!$disable_animation) : ?>data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                        <?php if ($icon_class) : ?>
                            <div class="featureslist-icon">
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            </div>
                        <?php endif; ?>
                        <div class="featureslist-content">
                            <?php if ($title) : ?>
                                <h3 class="featureslist-title"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>
                            <?php if ($description) : ?>
                                <p class="featureslist-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $feat_index++; endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .featureslist-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .featureslist-block .featureslist-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .featureslist-block .featureslist-heading {
        margin-bottom: 15px;
    }

    .featureslist-block .featureslist-subheading {
        color: #666;
        line-height: 1.6;
    }

    .featureslist-block .featureslist-grid {
        display: grid;
        gap: 40px 50px;
    }

    .featureslist-block.featureslist-cols-1 .featureslist-grid {
        grid-template-columns: 1fr;
        max-width: 700px;
        margin: 0 auto;
    }

    .featureslist-block.featureslist-cols-2 .featureslist-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .featureslist-block .featureslist-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .featureslist-block .featureslist-icon {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 12px;
        background: #f0f4ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .featureslist-block .featureslist-icon i {
        font-size: 1.25rem;
        color: var(--primary);
    }

    .featureslist-block .featureslist-content {
        flex: 1;
    }

    .featureslist-block .featureslist-title {
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .featureslist-block .featureslist-description {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .featureslist-block .featureslist-header {
            margin-bottom: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .featureslist-block .featureslist-grid {
            grid-template-columns: 1fr !important;
        }

        .featureslist-block .featureslist-header {
            margin-bottom: 30px;
        }
    }
</style>
