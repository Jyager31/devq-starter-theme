<?php
/**
 * Stats Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$background = get_field('background') ?: 'light';

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
$unique_block_id = generate_unique_block_id('stats');

// Build dynamic attributes
$block_classes = 'container-fluid stats-block stats-bg-' . esc_attr($background);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes for header
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Check required fields
if (!have_rows('stats')) {
    echo 'Please add at least one stat for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="socialproof">
    <div class="container">
        <?php if ($eyebrow || $heading) : ?>
            <div class="stats-header" <?php echo $aos_attributes; ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper stats-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="stats-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('stats')) : $stat_index = 0; ?>
            <div class="stats-row">
                <?php while (have_rows('stats')) : the_row();
                    $number = get_sub_field('number');
                    $label = get_sub_field('label');
                    $prefix = get_sub_field('prefix');
                    $suffix = get_sub_field('suffix');
                    $delay = $stat_index * 100;

                    // Parse number to get just digits for data-count
                    $count_value = preg_replace('/[^0-9.]/', '', $number);
                    ?>
                    <div class="stats-item" <?php if (!$disable_animation) : ?>data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                        <div class="stats-number" data-count="<?php echo esc_attr($count_value); ?>" data-prefix="<?php echo esc_attr($prefix); ?>" data-suffix="<?php echo esc_attr($suffix); ?>">
                            <?php echo esc_html($prefix); ?>0<?php echo esc_html($suffix); ?>
                        </div>
                        <?php if ($label) : ?>
                            <div class="stats-label"><?php echo esc_html($label); ?></div>
                        <?php endif; ?>
                    </div>
                <?php $stat_index++; endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .stats-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .stats-block.stats-bg-light {
        background-color: #f8f7f4;
    }

    .stats-block.stats-bg-dark {
        background-color: #1a1a2e;
    }

    .stats-block.stats-bg-primary {
        background-color: var(--primary);
    }

    .stats-block .stats-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .stats-block .stats-heading {
        margin-bottom: 0;
    }

    .stats-block .stats-eyebrow {
        display: block;
        margin-bottom: 15px;
    }

    /* Dark and primary background text colors */
    .stats-block.stats-bg-dark .stats-header,
    .stats-block.stats-bg-primary .stats-header {
        color: #fff;
    }

    .stats-block.stats-bg-dark .stats-heading,
    .stats-block.stats-bg-primary .stats-heading {
        color: #fff;
    }

    .stats-block.stats-bg-dark .stats-eyebrow,
    .stats-block.stats-bg-primary .stats-eyebrow {
        color: var(--tertiary);
    }

    .stats-block .stats-row {
        display: flex;
        justify-content: center;
        gap: 60px;
        flex-wrap: wrap;
    }

    .stats-block .stats-item {
        text-align: center;
        min-width: 150px;
    }

    .stats-block .stats-number {
        font-size: 3.5rem;
        font-weight: 800;
        font-family: var(--font1);
        line-height: 1;
        margin-bottom: 10px;
    }

    .stats-block .stats-label {
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Light background colors */
    .stats-block.stats-bg-light .stats-number {
        color: var(--primary);
    }

    .stats-block.stats-bg-light .stats-label {
        color: #666;
    }

    /* Dark and primary background colors */
    .stats-block.stats-bg-dark .stats-number,
    .stats-block.stats-bg-primary .stats-number {
        color: #fff;
    }

    .stats-block.stats-bg-dark .stats-label,
    .stats-block.stats-bg-primary .stats-label {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .stats-block .stats-row {
            gap: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .stats-block .stats-row {
            gap: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .stats-block .stats-number {
            font-size: 2.5rem;
        }

        .stats-block .stats-header {
            margin-bottom: 40px;
        }
    }
</style>
