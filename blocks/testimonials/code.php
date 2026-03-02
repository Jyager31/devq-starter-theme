<?php

/**
 * Testimonials Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$style = get_field('style') ?: 'carousel';

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
$unique_block_id = generate_unique_block_id('testimonials');

// Build dynamic attributes
$block_classes = 'container-fluid testimonials-block';
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
if (!have_rows('testimonials')) {
    echo 'Please add testimonials for this block.';
    return;
}

// Determine wrapper class based on style
$wrapper_class = ($style === 'carousel') ? 'testimonials-carousel' : 'testimonials-grid';

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="socialproof">
    <div class="container">
        <?php if ($eyebrow || $heading) : ?>
            <div class="testimonials-header">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper testimonials-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="testimonials-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('testimonials')) : ?>
            <div class="<?php echo esc_attr($wrapper_class); ?>">
                <?php
                $testimonial_index = 0;
                while (have_rows('testimonials')) : the_row();
                    $quote = get_sub_field('quote');
                    $name = get_sub_field('name');
                    $role = get_sub_field('role');
                    $photo = devq_get_image_or_placeholder('photo', 110, 110, 'testimonial-' . $testimonial_index, true);
                    $rating = get_sub_field('rating') ?: 5;

                    // Staggered animation for grid mode only
                    $card_aos = '';
                    if ($style === 'grid' && !$disable_animation) {
                        $delay = $testimonial_index * 150;
                        $card_aos = 'data-aos="fade-up" data-aos-delay="' . esc_attr($delay) . '"';
                    }
                    ?>
                    <div class="testimonials-card" <?php echo $card_aos; ?>>
                        <?php if ($rating) : ?>
                            <div class="testimonials-stars">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= $rating) : ?>
                                        <i class="fa-solid fa-star"></i>
                                    <?php else : ?>
                                        <i class="fa-regular fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($quote) : ?>
                            <p class="testimonials-quote"><?php echo esc_html($quote); ?></p>
                        <?php endif; ?>

                        <div class="testimonials-author">
                            <?php if ($photo) : ?>
                                <img class="testimonials-photo" src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt'] ?: $name); ?>" width="55" height="55" loading="lazy">
                            <?php endif; ?>
                            <div class="testimonials-author-text">
                                <?php if ($name) : ?>
                                    <span class="testimonials-name"><?php echo esc_html($name); ?></span>
                                <?php endif; ?>
                                <?php if ($role) : ?>
                                    <span class="testimonials-role"><?php echo esc_html($role); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $testimonial_index++;
                endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .testimonials-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .testimonials-block .testimonials-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .testimonials-block .testimonials-eyebrow {
        display: block;
        margin-bottom: 16px;
    }

    .testimonials-block .testimonials-heading {
        margin-bottom: 0;
    }

    .testimonials-block .testimonials-card {
        background: #fff;
        border-radius: 12px;
        padding: 40px 35px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
    }

    .testimonials-block .testimonials-stars {
        display: flex;
        gap: 4px;
        margin-bottom: 20px;
    }

    .testimonials-block .testimonials-stars .fa-solid {
        color: #f4b942;
    }

    .testimonials-block .testimonials-stars .fa-regular {
        color: #ddd;
    }

    .testimonials-block .testimonials-quote {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #333;
        margin-bottom: 25px;
        font-style: italic;
    }

    .testimonials-block .testimonials-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .testimonials-block .testimonials-photo {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
    }

    .testimonials-block .testimonials-author-text {
        display: flex;
        flex-direction: column;
    }

    .testimonials-block .testimonials-name {
        font-weight: 700;
    }

    .testimonials-block .testimonials-role {
        font-size: 14px;
        color: #666;
    }

    /* Grid mode */
    .testimonials-block .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    /* Carousel mode */
    .testimonials-block .testimonials-carousel .testimonials-card {
        margin: 0 15px;
    }

    /* Slick carousel overrides */
    .testimonials-block .slick-list {
        margin: 0 -15px;
    }

    .testimonials-block .slick-slide {
        padding: 15px;
    }

    /* Arrows */
    .testimonials-block .testimonials-carousel {
        position: relative;
    }

    .testimonials-block .slick-prev,
    .testimonials-block .slick-next {
        z-index: 1;
        width: 45px;
        height: 45px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-default);
        top: 50%;
        transform: translateY(-50%);
        position: absolute;
    }

    .testimonials-block .slick-prev:hover,
    .testimonials-block .slick-next:hover {
        background: var(--primary);
        border-color: var(--primary);
    }

    .testimonials-block .slick-prev:hover i,
    .testimonials-block .slick-next:hover i {
        color: #fff;
    }

    .testimonials-block .slick-prev {
        left: -55px;
    }

    .testimonials-block .slick-next {
        right: -55px;
    }

    .testimonials-block .slick-prev:before,
    .testimonials-block .slick-next:before {
        display: none;
    }

    .testimonials-block .slick-prev i,
    .testimonials-block .slick-next i {
        color: #333;
        font-size: 16px;
        line-height: 1;
    }

    /* Dots */
    .testimonials-block .slick-dots {
        bottom: -40px;
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex !important;
        justify-content: center;
        gap: 8px;
    }

    .testimonials-block .slick-dots li {
        width: auto;
        height: auto;
        margin: 0;
    }

    .testimonials-block .slick-dots li button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ddd;
        border: none;
        padding: 0;
        font-size: 0;
        cursor: pointer;
        transition: var(--transition-default);
    }

    .testimonials-block .slick-dots li button:before {
        display: none;
    }

    .testimonials-block .slick-dots li.slick-active button {
        background: var(--primary);
        transform: scale(1.2);
    }

    .testimonials-block .testimonials-carousel {
        margin-bottom: 50px;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .testimonials-block .testimonials-header {
            margin-bottom: 40px;
        }

        .testimonials-block .slick-prev {
            left: -15px;
        }

        .testimonials-block .slick-next {
            right: -15px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .testimonials-block .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .testimonials-block .testimonials-header {
            margin-bottom: 30px;
        }

        .testimonials-block .testimonials-card {
            padding: 30px 25px;
        }

        .testimonials-block .slick-prev,
        .testimonials-block .slick-next {
            display: none !important;
        }
    }
</style>
