<?php
/**
 * Before/After Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$before_image = devq_get_image_or_placeholder('before_image', 1200, 800, 'before', true);
$after_image = devq_get_image_or_placeholder('after_image', 1200, 800, 'after', true);
$before_label = get_field('before_label') ?: 'Before';
$after_label = get_field('after_label') ?: 'After';
$default_position = get_field('default_position') ?: 50;

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
$unique_block_id = generate_unique_block_id('beforeafter');

// Build dynamic attributes
$block_classes = 'container-fluid beforeafter-block';
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
if (!$before_image || !$after_image) {
    echo 'Please select both a before and after image for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="media">
    <div class="container">
        <?php if ($eyebrow || $heading) : ?>
            <div class="beforeafter-header" <?php if ($animate) echo devq_aos('fade-up', 0, $animation_duration); ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper beforeafter-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="beforeafter-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="beforeafter-container" <?php if ($animate) echo devq_aos('fade-up', 200, $animation_duration); ?> data-position="<?php echo esc_attr($default_position); ?>">
            <div class="beforeafter-after">
                <img src="<?php echo esc_url($after_image['url']); ?>" alt="<?php echo esc_attr($after_image['alt']); ?>" draggable="false">
            </div>
            <div class="beforeafter-before" style="width: <?php echo esc_attr($default_position); ?>%;">
                <img src="<?php echo esc_url($before_image['url']); ?>" alt="<?php echo esc_attr($before_image['alt']); ?>" draggable="false">
            </div>
            <div class="beforeafter-divider" style="left: <?php echo esc_attr($default_position); ?>%;">
                <div class="beforeafter-handle">
                    <i class="fa-solid fa-arrows-left-right"></i>
                </div>
            </div>
            <span class="beforeafter-label beforeafter-label-before"><?php echo esc_html($before_label); ?></span>
            <span class="beforeafter-label beforeafter-label-after"><?php echo esc_html($after_label); ?></span>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .beforeafter-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .beforeafter-block .beforeafter-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 40px;
    }

    .beforeafter-block .beforeafter-heading {
        margin-bottom: 15px;
    }

    .beforeafter-block .beforeafter-container {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        cursor: col-resize;
        user-select: none;
        -webkit-user-select: none;
    }

    .beforeafter-block .beforeafter-after {
        display: block;
        width: 100%;
    }

    .beforeafter-block .beforeafter-after img {
        display: block;
        width: 100%;
        height: auto;
    }

    .beforeafter-block .beforeafter-before {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        overflow: hidden;
    }

    .beforeafter-block .beforeafter-before img {
        display: block;
        width: auto;
        height: 100%;
        max-width: none;
    }

    .beforeafter-block .beforeafter-divider {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #fff;
        transform: translateX(-50%);
        z-index: 3;
        pointer-events: none;
    }

    .beforeafter-block .beforeafter-handle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 44px;
        height: 44px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: auto;
        cursor: col-resize;
        z-index: 4;
        transition: box-shadow 0.2s ease;
    }

    .beforeafter-block .beforeafter-handle:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
    }

    .beforeafter-block .beforeafter-handle i {
        color: #333;
        font-size: 16px;
    }

    .beforeafter-block .beforeafter-label {
        position: absolute;
        top: 16px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
        pointer-events: none;
    }

    .beforeafter-block .beforeafter-label-before {
        left: 16px;
    }

    .beforeafter-block .beforeafter-label-after {
        right: 16px;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .beforeafter-block .beforeafter-header {
            margin-bottom: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .beforeafter-block .beforeafter-header {
            margin-bottom: 25px;
        }

        .beforeafter-block .beforeafter-label {
            padding: 6px 12px;
            font-size: 11px;
            top: 12px;
        }

        .beforeafter-block .beforeafter-label-before {
            left: 12px;
        }

        .beforeafter-block .beforeafter-label-after {
            right: 12px;
        }
    }
</style>

<script>
(function() {
    document.querySelectorAll('.beforeafter-container').forEach(function(container) {
        var divider = container.querySelector('.beforeafter-divider');
        var before = container.querySelector('.beforeafter-before');
        var handle = container.querySelector('.beforeafter-handle');
        var isDragging = false;

        function updatePosition(x) {
            var rect = container.getBoundingClientRect();
            var percent = Math.max(5, Math.min(95, ((x - rect.left) / rect.width) * 100));
            before.style.width = percent + '%';
            divider.style.left = percent + '%';
        }

        // Match before image width to container width for proper clipping
        function syncImageWidth() {
            var beforeImg = before.querySelector('img');
            if (beforeImg) {
                beforeImg.style.width = container.offsetWidth + 'px';
            }
        }

        // Mouse events
        handle.addEventListener('mousedown', function(e) {
            isDragging = true;
            e.preventDefault();
        });

        document.addEventListener('mousemove', function(e) {
            if (isDragging) {
                updatePosition(e.clientX);
            }
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
        });

        // Touch events
        handle.addEventListener('touchstart', function(e) {
            isDragging = true;
        });

        container.addEventListener('touchmove', function(e) {
            if (isDragging) {
                updatePosition(e.touches[0].clientX);
                e.preventDefault();
            }
        }, { passive: false });

        document.addEventListener('touchend', function() {
            isDragging = false;
        });

        // Also allow clicking anywhere on the container to move the slider
        container.addEventListener('mousedown', function(e) {
            if (e.target === handle || handle.contains(e.target)) return;
            isDragging = true;
            updatePosition(e.clientX);
        });

        // Sync image width on load and resize
        syncImageWidth();
        window.addEventListener('resize', syncImageWidth);
    });
})();
</script>
