<?php
/**
 * Hero Slider Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// Layout Tab Fields
$content_alignment = get_field('content_alignment') ?: 'center';
$content_width = get_field('content_width') ?: 'default';
$height = get_field('height') ?: 'large';
$vertical_position = get_field('vertical_position') ?: 'center';
$autoplay = get_field('autoplay');
$autoplay_speed = get_field('autoplay_speed') ?: 5000;
$transition_style = get_field('transition_style') ?: 'fade';
$show_arrows = get_field('show_arrows');
$show_dots = get_field('show_dots');

// Default autoplay/arrows/dots to true if not set
if ($autoplay === null) $autoplay = true;
if ($show_arrows === null) $show_arrows = true;
if ($show_dots === null) $show_dots = true;

// Options Tab Fields
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
$unique_block_id = generate_unique_block_id('heroslider');

// Build dynamic attributes
$block_classes = 'container-fluid heroslider-block';
$block_classes .= ' heroslider-align-' . esc_attr($content_alignment);
$block_classes .= ' heroslider-width-' . esc_attr($content_width);
$block_classes .= ' heroslider-height-' . esc_attr($height);
$block_classes .= ' heroslider-vpos-' . esc_attr($vertical_position);
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
if (!have_rows('slides')) {
    echo 'Please add at least one slide for the Hero Slider block.';
    return;
}

// Collect slides data
$slides_data = array();
while (have_rows('slides')) {
    the_row();
    $slide_image = devq_get_image_or_placeholder('background_image', 1920, 1080, 'hero-slide');
    $slides_data[] = array(
        'eyebrow' => get_sub_field('eyebrow'),
        'heading' => get_sub_field('heading'),
        'subheading' => get_sub_field('subheading'),
        'button' => get_sub_field('button'),
        'background_image' => $slide_image,
        'overlay_color' => get_sub_field('overlay_color') ?: '#000000',
        'overlay_opacity' => get_sub_field('overlay_opacity') ?: 50,
    );
}

if (empty($slides_data)) {
    echo 'Please add at least one slide for the Hero Slider block.';
    return;
}

// Slider data attributes for JS
$slider_config = array(
    'autoplay' => (bool)$autoplay,
    'autoplaySpeed' => intval($autoplay_speed),
    'fade' => ($transition_style === 'fade'),
    'arrows' => (bool)$show_arrows,
    'dots' => (bool)$show_dots,
);

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="heroes">

    <div class="heroslider-carousel" data-slider-config='<?php echo wp_json_encode($slider_config); ?>'>
        <?php foreach ($slides_data as $index => $slide) :
            $overlay_decimal = intval($slide['overlay_opacity']) / 100;
        ?>
            <div class="heroslider-slide">
                <!-- Background -->
                <?php if ($slide['background_image']) : ?>
                    <div class="heroslider-bg" style="background-image: url('<?php echo esc_url($slide['background_image']['url']); ?>');">
                        <div class="heroslider-overlay" style="background-color: <?php echo esc_attr($slide['overlay_color']); ?>; opacity: <?php echo esc_attr($overlay_decimal); ?>;"></div>
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="container">
                    <div class="heroslider-content">
                        <?php if ($slide['eyebrow']) : ?>
                            <span class="cs-topper heroslider-eyebrow"><?php echo esc_html($slide['eyebrow']); ?></span>
                        <?php endif; ?>

                        <?php if ($slide['heading']) : ?>
                            <h2 class="heroslider-heading"><?php echo esc_html($slide['heading']); ?></h2>
                        <?php endif; ?>

                        <?php if ($slide['subheading']) : ?>
                            <p class="heroslider-subheading"><?php echo esc_html($slide['subheading']); ?></p>
                        <?php endif; ?>

                        <?php if ($slide['button']) : ?>
                            <div class="heroslider-buttons">
                                <a href="<?php echo esc_url($slide['button']['url']); ?>" class="btn-inline btn-primary" <?php echo !empty($slide['button']['target']) ? 'target="' . esc_attr($slide['button']['target']) . '"' : ''; ?>><?php echo esc_html($slide['button']['title']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .heroslider-block {
        position: relative;
        overflow: hidden;
    }

    .heroslider-carousel {
        margin: 0;
    }

    .heroslider-slide {
        position: relative;
        display: flex !important;
        overflow: hidden;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    /* Height variants */
    .heroslider-block.heroslider-height-full .heroslider-slide { min-height: 100vh; }
    .heroslider-block.heroslider-height-large .heroslider-slide { min-height: 85vh; }
    .heroslider-block.heroslider-height-medium .heroslider-slide { min-height: 65vh; }
    .heroslider-block.heroslider-height-auto .heroslider-slide { min-height: 0; }

    /* Vertical position */
    .heroslider-block.heroslider-vpos-center .heroslider-slide { align-items: center; }
    .heroslider-block.heroslider-vpos-top .heroslider-slide { align-items: flex-start; padding-top: 120px; }
    .heroslider-block.heroslider-vpos-bottom .heroslider-slide { align-items: flex-end; padding-bottom: 120px; }

    /* Background */
    .heroslider-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1;
    }

    .heroslider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    /* Content */
    .heroslider-slide .container {
        position: relative;
        z-index: 3;
        width: 100%;
    }

    .heroslider-content {
        color: #fff;
        max-width: 800px;
    }

    /* Content width */
    .heroslider-block.heroslider-width-narrow .heroslider-content { max-width: 600px; }
    .heroslider-block.heroslider-width-default .heroslider-content { max-width: 800px; }
    .heroslider-block.heroslider-width-wide .heroslider-content { max-width: 1000px; }

    /* Alignment */
    .heroslider-block.heroslider-align-center .heroslider-content {
        text-align: center;
        margin: 0 auto;
    }
    .heroslider-block.heroslider-align-center .heroslider-buttons { justify-content: center; }
    .heroslider-block.heroslider-align-center .heroslider-subheading { margin-left: auto; margin-right: auto; }

    .heroslider-block.heroslider-align-left .heroslider-content {
        text-align: left;
        margin: 0;
    }
    .heroslider-block.heroslider-align-left .heroslider-buttons { justify-content: flex-start; }

    .heroslider-block.heroslider-align-right .heroslider-content {
        text-align: right;
        margin: 0 0 0 auto;
    }
    .heroslider-block.heroslider-align-right .heroslider-buttons { justify-content: flex-end; }

    .heroslider-eyebrow {
        display: block;
        margin-bottom: 16px;
        color: rgba(255, 255, 255, 0.85);
    }

    .heroslider-heading {
        color: #fff;
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .heroslider-subheading {
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 32px;
        max-width: 600px;
        line-height: 1.6;
    }

    .heroslider-buttons {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Slick arrows */
    .heroslider-block .slick-prev,
    .heroslider-block .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        cursor: pointer;
        font-size: 0;
        line-height: 0;
        transition: var(--transition-default);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .heroslider-block .slick-prev { left: 30px; }
    .heroslider-block .slick-next { right: 30px; }

    .heroslider-block .slick-prev:hover,
    .heroslider-block .slick-next:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .heroslider-block .slick-prev i,
    .heroslider-block .slick-next i {
        font-size: 16px;
        color: #fff;
    }

    /* Slick dots */
    .heroslider-block .slick-dots {
        position: absolute;
        bottom: 30px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
        z-index: 10;
    }

    .heroslider-block .slick-dots li {
        margin: 0;
    }

    .heroslider-block .slick-dots li button {
        font-size: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        border: none;
        cursor: pointer;
        transition: var(--transition-default);
        padding: 0;
    }

    .heroslider-block .slick-dots li.slick-active button {
        background: #fff;
        transform: scale(1.2);
    }

    .heroslider-block .slick-dots li button:hover {
        background: rgba(255, 255, 255, 0.7);
    }

    /* Tablet */
    @media (max-width: 1199px) {
        .heroslider-block.heroslider-height-full .heroslider-slide { min-height: 85vh; }
        .heroslider-block.heroslider-height-large .heroslider-slide { min-height: 70vh; }
        .heroslider-block.heroslider-height-medium .heroslider-slide { min-height: 55vh; }
        .heroslider-block.heroslider-vpos-top .heroslider-slide { padding-top: 80px; }
        .heroslider-block.heroslider-vpos-bottom .heroslider-slide { padding-bottom: 80px; }

        .heroslider-block .slick-prev { left: 15px; }
        .heroslider-block .slick-next { right: 15px; }
    }

    /* Mobile */
    @media (max-width: 767px) {
        .heroslider-block.heroslider-height-full .heroslider-slide { min-height: 75vh; }
        .heroslider-block.heroslider-height-large .heroslider-slide { min-height: 60vh; }
        .heroslider-block.heroslider-height-medium .heroslider-slide { min-height: 50vh; }
        .heroslider-block.heroslider-vpos-top .heroslider-slide { padding-top: 60px; }
        .heroslider-block.heroslider-vpos-bottom .heroslider-slide { padding-bottom: 60px; }

        .heroslider-content {
            padding: 0 15px;
        }

        .heroslider-subheading {
            margin-bottom: 24px;
        }

        .heroslider-buttons {
            flex-direction: column;
            gap: 12px;
        }

        .heroslider-block .slick-prev,
        .heroslider-block .slick-next {
            display: none !important;
        }

        .heroslider-block .slick-dots {
            bottom: 20px;
        }

        .heroslider-block.heroslider-align-right .heroslider-content {
            text-align: center;
            margin: 0 auto;
        }
        .heroslider-block.heroslider-align-right .heroslider-buttons { justify-content: center; }
    }
</style>
