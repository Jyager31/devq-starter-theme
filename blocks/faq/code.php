<?php

/**
 * FAQ Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$heading = get_field('heading');

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
$unique_block_id = generate_unique_block_id('faq');

// Build dynamic attributes
$block_classes = 'container-fluid faq-block';
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
if (!have_rows('items')) {
    echo 'Please add FAQ items for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?>>
    <div class="container">
        <?php if ($heading) : ?>
            <h2 class="faq-heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <div class="faq-accordion">
            <?php while (have_rows('items')) : the_row();
                $question = get_sub_field('question');
                $answer = get_sub_field('answer');
                ?>
                <article class="faq-item">
                    <h3 class="faq-question"><?php echo esc_html($question); ?></h3>
                    <div class="faq-answer">
                        <?php echo wp_kses_post($answer); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .faq-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .faq-block .faq-heading {
        text-align: center;
        margin-bottom: 40px;
    }

    .faq-block .faq-accordion {
        max-width: 800px;
        margin: 0 auto;
    }

    .faq-block .faq-item {
        border-bottom: 1px solid #e0e0e0;
    }

    .faq-block .faq-item:first-child {
        border-top: 1px solid #e0e0e0;
    }

    .faq-block .faq-question {
        padding: 20px 40px 20px 0;
        margin: 0;
        cursor: pointer;
        position: relative;
        transition: var(--transition-default);
    }

    .faq-block .faq-question:hover {
        color: var(--primary);
    }

    .faq-block .faq-question::after {
        content: '+';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5em;
        font-weight: 300;
        line-height: 1;
        transition: var(--transition-default);
    }

    .faq-block .faq-item.is-open .faq-question::after {
        content: '−';
    }

    .faq-block .faq-answer {
        padding: 0 40px 20px 0;
        display: none;
    }

    .faq-block .faq-answer p:last-child {
        margin-bottom: 0;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .faq-block .faq-heading {
            margin-bottom: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .faq-block .faq-question {
            padding: 15px 35px 15px 0;
        }

        .faq-block .faq-answer {
            padding: 0 35px 15px 0;
        }
    }
</style>
