<?php
/**
 * Video Block
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
$video_url = get_field('video_url');
$thumbnail = devq_get_image_or_placeholder('thumbnail', 900, 506, 'video-thumb');
$aspect_ratio = get_field('aspect_ratio') ?: '16:9';

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
$unique_block_id = generate_unique_block_id('video');

// Build dynamic attributes
$block_classes = 'container-fluid video-block';
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
if (!$video_url) {
    echo 'Please add a video URL for this block.';
    return;
}

// Map aspect ratio to CSS value
$aspect_map = array(
    '16:9' => '16/9',
    '4:3'  => '4/3',
    '1:1'  => '1/1',
);
$css_aspect = isset($aspect_map[$aspect_ratio]) ? $aspect_map[$aspect_ratio] : '16/9';

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="media">
    <div class="container">
        <?php if ($eyebrow || $heading || $content) : ?>
            <div class="video-header">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper video-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="video-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($content) : ?>
                    <p class="video-content"><?php echo esc_html($content); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="video-wrapper">
            <?php if ($thumbnail) : ?>
                <div class="video-thumbnail-wrapper">
                    <img src="<?php echo esc_url($thumbnail['url']); ?>" alt="<?php echo esc_attr($thumbnail['alt']); ?>" style="aspect-ratio: <?php echo esc_attr($css_aspect); ?>;">
                    <button class="video-play-btn" aria-label="Play video">
                        <i class="fa-solid fa-play"></i>
                    </button>
                </div>
                <div class="video-embed" data-video-url="<?php echo esc_url($video_url); ?>" style="aspect-ratio: <?php echo esc_attr($css_aspect); ?>;"></div>
            <?php else : ?>
                <div class="video-embed video-embed-visible" data-video-url="<?php echo esc_url($video_url); ?>" style="aspect-ratio: <?php echo esc_attr($css_aspect); ?>;"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .video-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .video-block .video-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 50px;
    }

    .video-block .video-heading {
        margin-bottom: 15px;
    }

    .video-block .video-content {
        color: #666;
        line-height: 1.6;
    }

    .video-block .video-wrapper {
        max-width: 900px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }

    .video-block .video-thumbnail-wrapper {
        position: relative;
        cursor: pointer;
    }

    .video-block .video-thumbnail-wrapper img {
        width: 100%;
        display: block;
        object-fit: cover;
    }

    .video-block .video-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-default);
        cursor: pointer;
        border: none;
    }

    .video-block .video-play-btn i {
        font-size: 24px;
        color: var(--primary);
        margin-left: 5px;
    }

    .video-block .video-play-btn:hover {
        background: #fff;
        transform: translate(-50%, -50%) scale(1.1);
    }

    .video-block .video-embed {
        display: none;
        width: 100%;
    }

    .video-block .video-embed-visible {
        display: block;
    }

    .video-block .video-embed iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .video-block .video-wrapper {
            /* Tablet responsive styles */
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .video-block .video-wrapper {
            max-width: 100%;
        }

        .video-block .video-header {
            margin-bottom: 30px;
        }
    }
</style>