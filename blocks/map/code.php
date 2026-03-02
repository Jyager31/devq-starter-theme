<?php
/**
 * Map Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$content = get_field('content');
$map_embed = get_field('map_embed');
$map_height = get_field('map_height') ?: 450;
$style = get_field('style') ?: 'contained';

// Options Tab Fields (always include these)
$margin_top = get_field('margin_top') ?: '';
$margin_bottom = get_field('margin_bottom') ?: '';
$margin_top_other = get_field('margin_top_other') ?: 0;
$margin_bottom_other = get_field('margin_bottom_other') ?: 0;
$custom_class = get_field('custom_class');
$custom_id = get_field('custom_id');

// Animation Tab Fields
$animation_type = get_field('animation_type') ?: 'recommended';
$animation_duration = get_field('animation_duration') ?: 800;
$disable_animation = get_field('disable_animation');
$is_recommended = ($animation_type === 'recommended');

// Generate unique block ID
$unique_block_id = generate_unique_block_id('map');

// Build dynamic attributes
$block_classes = 'container-fluid map-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation) {
    if ($is_recommended) {
        $aos_attributes = devq_aos('fade-up', 0, $animation_duration);
    } else {
        $aos_attributes = 'data-aos="' . esc_attr($animation_type) . '"';
        if ($animation_duration != 800) {
            $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
        }
    }
}

// Check required fields
if (!$map_embed) {
    echo 'Please add a map embed code for this block.';
    return;
}

// Sanitize the map embed - allow iframe tags with common attributes
$allowed_tags = array(
    'iframe' => array(
        'src'             => true,
        'width'           => true,
        'height'          => true,
        'style'           => true,
        'frameborder'     => true,
        'allowfullscreen' => true,
        'loading'         => true,
        'referrerpolicy'  => true,
        'allow'           => true,
        'title'           => true,
        'class'           => true,
        'id'              => true,
    ),
);

$has_header = $eyebrow || $heading || $content;

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="media">
    <?php if ($has_header) : ?>
        <div class="container">
            <div class="map-header">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper map-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="map-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($content) : ?>
                    <p class="map-content"><?php echo esc_html($content); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($style === 'full-width') : ?>
        <div class="map-wrapper map-fullwidth" style="height: <?php echo esc_attr($map_height); ?>px;">
            <?php echo wp_kses($map_embed, $allowed_tags); ?>
        </div>
    <?php else : ?>
        <div class="container">
            <div class="map-wrapper map-contained" style="height: <?php echo esc_attr($map_height); ?>px;">
                <?php echo wp_kses($map_embed, $allowed_tags); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .map-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .map-block.map-no-header {
        padding-top: 0;
    }

    .map-block .map-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 40px;
    }

    .map-block .map-heading {
        margin-bottom: 0;
    }

    .map-block .map-content {
        color: #666;
        margin-top: 15px;
        line-height: 1.6;
    }

    .map-block .map-wrapper {
        overflow: hidden;
    }

    .map-block .map-contained {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .map-block .map-wrapper iframe {
        width: 100% !important;
        height: 100%;
        display: block;
        border: none;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .map-block .map-header {
            margin-bottom: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .map-block .map-wrapper {
            height: 350px !important;
        }

        .map-block .map-header {
            margin-bottom: 25px;
        }
    }
</style>
