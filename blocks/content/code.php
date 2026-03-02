<?php
/**
 * Content Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$content = get_field('content');
$max_width = get_field('max_width') ?: 'default';

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
$unique_block_id = generate_unique_block_id('content');

// Build dynamic attributes
$block_classes = 'container-fluid content-block';
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

// Build max width class
$width_class = 'content-' . esc_attr($max_width);

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="content">
    <div class="container">
        <div class="content-inner <?php echo esc_attr($width_class); ?>">
            <?php if ($content) : ?>
                <?php echo wp_kses_post($content); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .content-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    /* Max width options */
    .content-block .content-narrow {
        max-width: 680px;
        margin: 0 auto;
    }

    .content-block .content-default {
        max-width: 900px;
        margin: 0 auto;
    }

    .content-block .content-wide {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Typography spacing within content area */
    .content-block .content-inner > *:first-child {
        margin-top: 0;
    }

    .content-block .content-inner > *:last-child {
        margin-bottom: 0;
    }

    .content-block .content-inner p {
        margin-bottom: 1.2em;
    }

    .content-block .content-inner ul,
    .content-block .content-inner ol {
        margin-bottom: 1.2em;
        padding-left: 1.5em;
    }

    .content-block .content-inner li {
        margin-bottom: 0.4em;
    }

    .content-block .content-inner blockquote {
        margin: 1.5em 0;
        padding-left: 1.2em;
        border-left: 3px solid var(--primary);
    }

    .content-block .content-inner img {
        max-width: 100%;
        height: auto;
    }
</style>