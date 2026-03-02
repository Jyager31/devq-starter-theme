<?php
/**
 * Blog Posts Block
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
$posts_per_page = get_field('posts_per_page') ?: 6;
$columns = get_field('columns') ?: '3';
$show_date = get_field('show_date');
$show_excerpt = get_field('show_excerpt');
$category = get_field('category');
$button = get_field('button');

// Handle default true_false values (ACF returns empty string on new blocks)
if ($show_date === '' || $show_date === null) {
    $show_date = 1;
}
if ($show_excerpt === '' || $show_excerpt === null) {
    $show_excerpt = 1;
}

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
$unique_block_id = generate_unique_block_id('blogposts');

// Build dynamic attributes
$block_classes = 'container-fluid blogposts-block blogposts-cols-' . esc_attr($columns);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes (for header only; cards get individual AOS)
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Build WP_Query args
$args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
);

if (!empty($category)) {
    $cat_ids = array();
    foreach ($category as $cat) {
        $cat_ids[] = $cat->term_id;
    }
    $args['category__in'] = $cat_ids;
}

$query = new WP_Query($args);

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="content">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="blogposts-header" <?php echo $aos_attributes; ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper blogposts-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="blogposts-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="blogposts-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($query->have_posts()) : $card_index = 0; ?>
            <div class="blogposts-grid">
                <?php while ($query->have_posts()) : $query->the_post();
                    $post_id = get_the_ID();
                    $post_thumbnail = get_the_post_thumbnail_url($post_id, 'large');
                    if (!$post_thumbnail) {
                        $post_thumbnail = devq_placeholder_image(600, 400, 'post-' . $post_id)['url'];
                    }
                    $post_categories = get_the_category($post_id);
                    $delay = $card_index * 100;
                    ?>
                    <div class="blogposts-card" <?php if (!$disable_animation) : ?>data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                        <div class="blogposts-card-image">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <img src="<?php echo esc_url($post_thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                            </a>
                            <?php if (!empty($post_categories)) : ?>
                                <span class="blogposts-card-category"><?php echo esc_html($post_categories[0]->name); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="blogposts-card-body">
                            <h3 class="blogposts-card-title">
                                <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
                            </h3>
                            <?php if ($show_date) : ?>
                                <span class="blogposts-card-date"><?php echo esc_html(get_the_date()); ?></span>
                            <?php endif; ?>
                            <?php if ($show_excerpt) : ?>
                                <p class="blogposts-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?></p>
                            <?php endif; ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="blogposts-card-readmore">Read More &rarr;</a>
                        </div>
                    </div>
                <?php $card_index++; endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p class="blogposts-no-posts">No posts found.</p>
        <?php endif; ?>

        <?php if ($button) : ?>
            <div class="blogposts-button-wrap">
                <a href="<?php echo esc_url($button['url']); ?>" class="cs-button" <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>><?php echo esc_html($button['title']); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .blogposts-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .blogposts-block .blogposts-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .blogposts-block .blogposts-heading {
        margin-bottom: 15px;
    }

    .blogposts-block .blogposts-subheading {
        color: #666;
        line-height: 1.6;
    }

    .blogposts-block .blogposts-grid {
        display: grid;
        gap: 30px;
    }

    .blogposts-block.blogposts-cols-2 .blogposts-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .blogposts-block.blogposts-cols-3 .blogposts-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .blogposts-block.blogposts-cols-4 .blogposts-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .blogposts-block .blogposts-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: var(--transition-default);
    }

    .blogposts-block .blogposts-card:hover {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .blogposts-block .blogposts-card-image {
        position: relative;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
    }

    .blogposts-block .blogposts-card-image img {
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        display: block;
        transition: var(--transition-default);
    }

    .blogposts-block .blogposts-card:hover .blogposts-card-image img {
        transform: scale(1.05);
    }

    .blogposts-block .blogposts-card-category {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--primary);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        font-family: var(--font2);
        padding: 4px 12px;
        border-radius: 20px;
        line-height: 1.4;
    }

    .blogposts-block .blogposts-card-body {
        padding: 25px;
    }

    .blogposts-block .blogposts-card-title {
        margin-bottom: 8px;
    }

    .blogposts-block .blogposts-card-title a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition-default);
    }

    .blogposts-block .blogposts-card-title a:hover {
        color: var(--primary);
    }

    .blogposts-block .blogposts-card-date {
        display: block;
        font-size: 13px;
        color: #999;
        font-family: var(--font2);
        margin-bottom: 12px;
    }

    .blogposts-block .blogposts-card-excerpt {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .blogposts-block .blogposts-card-readmore {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition-default);
    }

    .blogposts-block .blogposts-card-readmore:hover {
        opacity: 0.8;
    }

    .blogposts-block .blogposts-no-posts {
        text-align: center;
        color: #999;
        padding: 40px 0;
    }

    .blogposts-block .blogposts-button-wrap {
        text-align: center;
        margin-top: 50px;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .blogposts-block.blogposts-cols-3 .blogposts-grid,
        .blogposts-block.blogposts-cols-4 .blogposts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .blogposts-block .blogposts-grid {
            grid-template-columns: 1fr !important;
        }

        .blogposts-block .blogposts-header {
            margin-bottom: 40px;
        }

        .blogposts-block .blogposts-button-wrap {
            margin-top: 30px;
        }
    }
</style>
