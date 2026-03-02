<?php
/**
 * Banner Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$text = get_field('text');
$link = get_field('link');
$background = get_field('background') ?: 'primary';
$custom_background_color = get_field('custom_background_color') ?: '';
$dismissible = get_field('dismissible');

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
$unique_block_id = generate_unique_block_id('banner');

// Build dynamic attributes
$block_classes = 'container-fluid banner-block banner-bg-' . esc_attr($background);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes
$aos_attributes = '';
if (!$disable_animation) {
    if ($is_recommended) {
        $aos_attributes = devq_aos('fade-down', 0, $animation_duration);
    } else {
        $aos_attributes = 'data-aos="' . esc_attr($animation_type) . '"';
        if ($animation_duration != 800) {
            $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
        }
    }
}

// Check required fields
if (!$text) {
    echo 'Please add text for the Banner block.';
    return;
}

// Build background style for custom color
$bg_style = '';
if ($background === 'custom' && $custom_background_color) {
    $bg_style = 'background-color: ' . wp_strip_all_tags($custom_background_color) . ';';
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> <?php echo $bg_style ? 'style="' . esc_attr($bg_style) . '"' : ''; ?> data-block-category="conversion">
    <div class="container">
        <div class="banner-inner">
            <div class="banner-content">
                <span class="banner-text"><?php echo esc_html($text); ?></span>
                <?php if ($link) : ?>
                    <a href="<?php echo esc_url($link['url']); ?>" class="banner-link" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>><?php echo esc_html($link['title']); ?> &rarr;</a>
                <?php endif; ?>
            </div>
            <?php if ($dismissible) : ?>
                <button class="banner-dismiss" aria-label="Dismiss banner" onclick="this.closest('.banner-block').style.display='none'; sessionStorage.setItem('banner_dismissed_<?php echo esc_attr($block_id); ?>', '1');">&times;</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($dismissible) : ?>
<script>
(function() {
    var bannerId = '<?php echo esc_js($block_id); ?>';
    if (sessionStorage.getItem('banner_dismissed_' + bannerId) === '1') {
        var el = document.getElementById(bannerId);
        if (el) el.style.display = 'none';
    }
})();
</script>
<?php endif; ?>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .banner-block {
        padding: 12px 0;
    }

    .banner-block.banner-bg-primary {
        background-color: var(--primary);
    }

    .banner-block.banner-bg-secondary {
        background-color: var(--secondary);
    }

    .banner-block.banner-bg-dark {
        background-color: #1a1a2e;
    }

    .banner-block .banner-inner {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .banner-block .banner-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .banner-block .banner-text {
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        font-family: var(--font2);
        line-height: 1.4;
    }

    .banner-block .banner-link {
        color: #fff;
        text-decoration: underline;
        font-weight: 600;
        font-size: 15px;
        font-family: var(--font2);
        transition: var(--transition-default);
        white-space: nowrap;
    }

    .banner-block .banner-link:hover {
        opacity: 0.85;
    }

    .banner-block .banner-dismiss {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        padding: 5px 10px;
        transition: var(--transition-default);
    }

    .banner-block .banner-dismiss:hover {
        color: #fff;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .banner-block .banner-content {
            padding-right: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .banner-block {
            padding: 10px 0;
        }

        .banner-block .banner-text {
            font-size: 13px;
        }

        .banner-block .banner-link {
            font-size: 13px;
        }

        .banner-block .banner-content {
            flex-direction: column;
            gap: 5px;
            padding-right: 30px;
        }
    }
</style>
