<?php
/**
 * Hero Video Block
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
$primary_button = get_field('primary_button');
$secondary_button = get_field('secondary_button');
$video_source = get_field('video_source') ?: 'youtube';
$youtube_url = get_field('youtube_url');
$video_file = get_field('video_file');
$fallback_image = devq_get_image_or_placeholder('fallback_image', 1920, 1080, 'hero-video-fallback');
$overlay_color = get_field('overlay_color') ?: '#000000';
$overlay_opacity = get_field('overlay_opacity') ?: 50;

// Layout Tab Fields
$content_alignment = get_field('content_alignment') ?: 'center';
$content_width = get_field('content_width') ?: 'default';
$height = get_field('height') ?: 'large';
$vertical_position = get_field('vertical_position') ?: 'center';
$show_scroll_indicator = get_field('show_scroll_indicator');

// Options Tab Fields
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
$unique_block_id = generate_unique_block_id('herovideo');

// Build dynamic attributes
$block_classes = 'container-fluid herovideo-block';
$block_classes .= ' herovideo-align-' . esc_attr($content_alignment);
$block_classes .= ' herovideo-width-' . esc_attr($content_width);
$block_classes .= ' herovideo-height-' . esc_attr($height);
$block_classes .= ' herovideo-vpos-' . esc_attr($vertical_position);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation && !$is_recommended) {
    $aos_attributes = 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}
$animate = (!$disable_animation && $is_recommended);

// Check required fields
if (!$heading) {
    echo 'Please add a heading for the Hero Video block.';
    return;
}

// Calculate overlay opacity
$overlay_opacity_decimal = intval($overlay_opacity) / 100;

// Extract YouTube video ID
$youtube_id = '';
if ($video_source === 'youtube' && $youtube_url) {
    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $youtube_url, $matches);
    $youtube_id = !empty($matches[1]) ? $matches[1] : '';
}

// Get video file URL
$video_url = '';
if ($video_source === 'upload' && $video_file) {
    $video_url = is_array($video_file) ? $video_file['url'] : wp_get_attachment_url($video_file);
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="heroes">

    <!-- Video Background -->
    <div class="herovideo-background">
        <?php if ($video_source === 'youtube' && $youtube_id) : ?>
            <div class="herovideo-youtube" data-youtube-id="<?php echo esc_attr($youtube_id); ?>">
                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($youtube_id); ?>&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&enablejsapi=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        <?php elseif ($video_source === 'upload' && $video_url) : ?>
            <video class="herovideo-file" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
            </video>
        <?php endif; ?>

        <!-- Fallback image (shown on mobile / no-video) -->
        <?php if ($fallback_image) : ?>
            <div class="herovideo-fallback" style="background-image: url('<?php echo esc_url($fallback_image['url']); ?>');"></div>
        <?php endif; ?>
    </div>

    <!-- Overlay -->
    <div class="herovideo-overlay" style="background-color: <?php echo esc_attr($overlay_color); ?>; opacity: <?php echo esc_attr($overlay_opacity_decimal); ?>;"></div>

    <!-- Content -->
    <div class="container">
        <div class="herovideo-content">
            <?php if ($eyebrow) : ?>
                <span class="cs-topper herovideo-eyebrow" <?php if ($animate) echo devq_aos('fade-up', 0, $animation_duration); ?>><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>

            <h1 class="herovideo-heading" <?php if ($animate) echo devq_aos('fade-up', 100, $animation_duration); ?>><?php echo esc_html($heading); ?></h1>

            <?php if ($subheading) : ?>
                <p class="herovideo-subheading" <?php if ($animate) echo devq_aos('fade-up', 200, $animation_duration); ?>><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($primary_button || $secondary_button) : ?>
                <div class="herovideo-buttons" <?php if ($animate) echo devq_aos('fade-up', 300, $animation_duration); ?>>
                    <?php if ($primary_button) : ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn" <?php echo !empty($primary_button['target']) ? 'target="' . esc_attr($primary_button['target']) . '"' : ''; ?>><?php echo esc_html($primary_button['title']); ?></a>
                    <?php endif; ?>
                    <?php if ($secondary_button) : ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn btn-outline-white" <?php echo !empty($secondary_button['target']) ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>><?php echo esc_html($secondary_button['title']); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($show_scroll_indicator) : ?>
        <div class="herovideo-scroll-indicator">
            <span class="herovideo-scroll-chevron"></span>
        </div>
    <?php endif; ?>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .herovideo-block {
        position: relative;
        display: flex;
        overflow: hidden;
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    /* Height variants */
    .herovideo-block.herovideo-height-full { min-height: 100vh; }
    .herovideo-block.herovideo-height-large { min-height: 85vh; }
    .herovideo-block.herovideo-height-medium { min-height: 65vh; }
    .herovideo-block.herovideo-height-auto { min-height: 0; }

    /* Vertical position */
    .herovideo-block.herovideo-vpos-center { align-items: center; }
    .herovideo-block.herovideo-vpos-top { align-items: flex-start; padding-top: 120px; }
    .herovideo-block.herovideo-vpos-bottom { align-items: flex-end; padding-bottom: 120px; }

    /* Video background layer */
    .herovideo-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .herovideo-youtube {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100vw;
        height: 56.25vw; /* 16:9 */
        min-height: 100vh;
        min-width: 177.78vh; /* 16:9 */
        transform: translate(-50%, -50%);
    }

    .herovideo-youtube iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .herovideo-file {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        transform: translate(-50%, -50%);
        object-fit: cover;
    }

    .herovideo-fallback {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 0;
    }

    /* Overlay */
    .herovideo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    /* Content */
    .herovideo-block .container {
        position: relative;
        z-index: 3;
        width: 100%;
    }

    .herovideo-content {
        color: #fff;
        max-width: 800px;
    }

    /* Content width */
    .herovideo-block.herovideo-width-narrow .herovideo-content { max-width: 600px; }
    .herovideo-block.herovideo-width-default .herovideo-content { max-width: 800px; }
    .herovideo-block.herovideo-width-wide .herovideo-content { max-width: 1000px; }

    /* Alignment */
    .herovideo-block.herovideo-align-center .herovideo-content {
        text-align: center;
        margin: 0 auto;
    }
    .herovideo-block.herovideo-align-center .herovideo-buttons { justify-content: center; }
    .herovideo-block.herovideo-align-center .herovideo-subheading { margin-left: auto; margin-right: auto; }

    .herovideo-block.herovideo-align-left .herovideo-content {
        text-align: left;
        margin: 0;
    }
    .herovideo-block.herovideo-align-left .herovideo-buttons { justify-content: flex-start; }

    .herovideo-block.herovideo-align-right .herovideo-content {
        text-align: right;
        margin: 0 0 0 auto;
    }
    .herovideo-block.herovideo-align-right .herovideo-buttons { justify-content: flex-end; }

    .herovideo-eyebrow {
        display: block;
        margin-bottom: 16px;
        color: rgba(255, 255, 255, 0.85);
    }

    .herovideo-heading {
        color: #fff;
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .herovideo-subheading {
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 32px;
        max-width: 600px;
        line-height: 1.6;
    }

    .herovideo-buttons {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Scroll indicator */
    .herovideo-scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 4;
    }

    .herovideo-scroll-chevron {
        display: block;
        width: 30px;
        height: 30px;
        border-right: 2px solid rgba(255, 255, 255, 0.7);
        border-bottom: 2px solid rgba(255, 255, 255, 0.7);
        transform: rotate(45deg);
        animation: herovideo-bounce 2s infinite;
    }

    @keyframes herovideo-bounce {
        0%, 20%, 50%, 80%, 100% { transform: rotate(45deg) translateY(0); }
        40% { transform: rotate(45deg) translateY(10px); }
        60% { transform: rotate(45deg) translateY(5px); }
    }

    /* Mobile: hide video, show fallback */
    @media (max-width: 767px) {
        .herovideo-youtube,
        .herovideo-file {
            display: none;
        }

        .herovideo-fallback {
            z-index: 1;
        }

        .herovideo-block.herovideo-height-full { min-height: 75vh; }
        .herovideo-block.herovideo-height-large { min-height: 60vh; }
        .herovideo-block.herovideo-height-medium { min-height: 50vh; }
        .herovideo-block.herovideo-vpos-top { padding-top: 60px; }
        .herovideo-block.herovideo-vpos-bottom { padding-bottom: 60px; }

        .herovideo-content {
            padding: 0 15px;
        }

        .herovideo-subheading {
            margin-bottom: 24px;
        }

        .herovideo-buttons {
            flex-direction: column;
            gap: 12px;
        }

        .herovideo-block.herovideo-align-right .herovideo-content {
            text-align: center;
            margin: 0 auto;
        }
        .herovideo-block.herovideo-align-right .herovideo-buttons { justify-content: center; }
    }

    @media (max-width: 1199px) {
        .herovideo-block.herovideo-height-full { min-height: 85vh; }
        .herovideo-block.herovideo-height-large { min-height: 70vh; }
        .herovideo-block.herovideo-height-medium { min-height: 55vh; }
        .herovideo-block.herovideo-vpos-top { padding-top: 80px; }
        .herovideo-block.herovideo-vpos-bottom { padding-bottom: 80px; }
    }
</style>
