<?php
/**
 * Cards Block
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
$columns = get_field('columns') ?: '3';

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
$unique_block_id = generate_unique_block_id('cards');

// Build dynamic attributes
$block_classes = 'container-fluid cards-block cards-cols-' . esc_attr($columns);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes (block-level for header only; cards get individual AOS)
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Check required fields
if (!$heading && !have_rows('cards')) {
    echo 'Please add a heading or cards for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="cards">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="cards-header" <?php echo $aos_attributes; ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper cards-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="cards-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="cards-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('cards')) : $card_index = 0; ?>
            <div class="cards-grid">
                <?php while (have_rows('cards')) : the_row();
                    $icon_type = get_sub_field('icon_type') ?: 'fontawesome';
                    $icon_class = get_sub_field('icon_class');
                    $icon_image = ($icon_type === 'image') ? devq_get_image_or_placeholder('icon_image', 60, 60, 'card-icon-' . $card_index, true) : get_sub_field('icon_image');
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    $link = get_sub_field('link');
                    $delay = $card_index * 100;
                    ?>
                    <div class="cards-card" <?php if (!$disable_animation) : ?>data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                        <?php if ($icon_type === 'fontawesome' && $icon_class) : ?>
                            <div class="cards-card-icon">
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            </div>
                        <?php elseif ($icon_type === 'image' && $icon_image) : ?>
                            <div class="cards-card-icon">
                                <img src="<?php echo esc_url($icon_image['url']); ?>" alt="<?php echo esc_attr($icon_image['alt']); ?>">
                            </div>
                        <?php endif; ?>
                        <?php if ($title) : ?>
                            <h3 class="cards-card-title"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                        <?php if ($description) : ?>
                            <p class="cards-card-description"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link['url']); ?>" class="cards-card-link" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>><?php echo esc_html($link['title'] ?: 'Learn More'); ?> &rarr;</a>
                        <?php endif; ?>
                    </div>
                <?php $card_index++; endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .cards-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .cards-block .cards-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .cards-block .cards-heading {
        margin-bottom: 15px;
    }

    .cards-block .cards-subheading {
        color: #666;
        line-height: 1.6;
    }

    .cards-block .cards-grid {
        display: grid;
        gap: 30px;
    }

    .cards-block.cards-cols-2 .cards-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .cards-block.cards-cols-3 .cards-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .cards-block.cards-cols-4 .cards-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .cards-block .cards-card {
        background: #fff;
        border-radius: 12px;
        padding: 40px 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        transition: var(--transition-default);
    }

    .cards-block .cards-card:hover {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .cards-block .cards-card-icon {
        margin-bottom: 20px;
    }

    .cards-block .cards-card-icon i {
        font-size: 2.5rem;
        color: var(--primary);
    }

    .cards-block .cards-card-icon img {
        width: 60px;
        height: 60px;
        object-fit: contain;
    }

    .cards-block .cards-card-title {
        margin-bottom: 12px;
    }

    .cards-block .cards-card-description {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .cards-block .cards-card-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-default);
    }

    .cards-block .cards-card-link:hover {
        opacity: 0.8;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .cards-block.cards-cols-4 .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .cards-block .cards-grid {
            grid-template-columns: 1fr !important;
        }

        .cards-block .cards-header {
            margin-bottom: 40px;
        }
    }
</style>
