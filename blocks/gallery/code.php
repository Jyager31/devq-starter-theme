<?php
/**
 * Gallery Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$heading = get_field('heading');
$show_filters = get_field('show_filters');

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
$unique_block_id = generate_unique_block_id('gallery');

// Build dynamic attributes
$block_classes = 'container-fluid gallery-block';
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

// Collect all gallery items and unique categories in a single pass
$gallery_items = array();
$categories = array();
$gallery_index = 0;
if (have_rows('images')) :
    while (have_rows('images')) : the_row();
        $item = array(
            'image' => devq_get_image_or_placeholder('image', 600, 600, 'gallery-' . $gallery_index, true),
            'category' => get_sub_field('category'),
            'caption' => get_sub_field('caption'),
        );
        $gallery_index++;
        $gallery_items[] = $item;
        if ($item['category'] && !in_array($item['category'], $categories)) {
            $categories[] = $item['category'];
        }
    endwhile;
endif;

// Check required fields
if (empty($gallery_items)) {
    echo 'Please add images to the gallery.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="media">
    <div class="container">
        <?php if ($heading) : ?>
            <h2 class="gallery-heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($show_filters && !empty($categories)) : ?>
            <div class="gallery-filters">
                <button class="gallery-filter-btn active" data-filter="all">All</button>
                <?php foreach ($categories as $category) : ?>
                    <button class="gallery-filter-btn" data-filter="<?php echo esc_attr($category); ?>"><?php echo esc_html($category); ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="gallery-grid">
            <?php foreach ($gallery_items as $item) :
                $image = $item['image'];
                $category = $item['category'];
                $caption = $item['caption'];
                if (!$image) continue;
                ?>
                <div class="gallery-item" <?php echo $category ? 'data-category="' . esc_attr($category) . '"' : ''; ?>>
                    <a href="<?php echo esc_url($image['url']); ?>" class="gallery-lightbox" <?php echo $caption ? 'data-caption="' . esc_attr($caption) . '"' : ''; ?>>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        <?php if ($caption) : ?>
                            <div class="gallery-caption"><?php echo esc_html($caption); ?></div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .gallery-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .gallery-block .gallery-heading {
        text-align: center;
        margin-bottom: 20px;
    }

    .gallery-block .gallery-filters {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .gallery-block .gallery-filter-btn {
        padding: 8px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 30px;
        background: transparent;
        color: #666;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition-default);
    }

    .gallery-block .gallery-filter-btn:hover,
    .gallery-block .gallery-filter-btn.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .gallery-block .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .gallery-block .gallery-item {
        overflow: hidden;
        border-radius: 8px;
        position: relative;
    }

    .gallery-block .gallery-item img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        display: block;
        transition: var(--transition-default);
    }

    .gallery-block .gallery-item:hover img {
        transform: scale(1.05);
    }

    .gallery-block .gallery-lightbox {
        display: block;
        position: relative;
    }

    .gallery-block .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        color: #fff;
        font-size: 14px;
        opacity: 0;
        transition: var(--transition-default);
        transform: translateY(10px);
    }

    .gallery-block .gallery-item:hover .gallery-caption {
        opacity: 1;
        transform: translateY(0);
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .gallery-block .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .gallery-block .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }
</style>