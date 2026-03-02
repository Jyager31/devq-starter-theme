<?php
/**
 * Marquee Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$style = get_field('style') ?: 'text';
$speed = get_field('speed') ?: 'medium';
$direction = get_field('direction') ?: 'left';
$pause_on_hover = get_field('pause_on_hover');
$separator = get_field('separator') ?: '•';

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
$unique_block_id = generate_unique_block_id('marquee');

// Build dynamic attributes
$block_classes = 'container-fluid marquee-block marquee-style-' . esc_attr($style);
if ($pause_on_hover) {
    $block_classes .= ' marquee-pause-on-hover';
}
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
    echo 'Please add items for this block.';
    return;
}

// Calculate animation duration based on speed
$speed_map = array(
    'slow'   => '40s',
    'medium' => '25s',
    'fast'   => '15s',
);
$anim_duration = isset($speed_map[$speed]) ? $speed_map[$speed] : '25s';

// Animation direction
$anim_direction = ($direction === 'right') ? 'reverse' : 'normal';

// Collect items data
$items_data = array();
while (have_rows('items')) {
    the_row();
    $items_data[] = array(
        'text' => get_sub_field('text'),
        'logo' => get_sub_field('logo'),
        'link' => get_sub_field('link'),
    );
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="socialproof">
    <div class="marquee-track" style="animation-duration: <?php echo esc_attr($anim_duration); ?>; animation-direction: <?php echo esc_attr($anim_direction); ?>;">
        <?php for ($dup = 0; $dup < 2; $dup++) : ?>
            <div class="marquee-content" <?php echo $dup === 1 ? 'aria-hidden="true"' : ''; ?>>
                <?php foreach ($items_data as $index => $item) : ?>
                    <?php if ($style === 'text' && $item['text']) : ?>
                        <?php if ($index > 0 || $dup > 0) : ?>
                            <span class="marquee-separator"><?php echo esc_html($separator); ?></span>
                        <?php endif; ?>
                        <?php if ($item['link']) : ?>
                            <a href="<?php echo esc_url($item['link']); ?>" class="marquee-text-item"><?php echo esc_html($item['text']); ?></a>
                        <?php else : ?>
                            <span class="marquee-text-item"><?php echo esc_html($item['text']); ?></span>
                        <?php endif; ?>
                    <?php elseif ($style === 'logos' && $item['logo']) : ?>
                        <?php if ($item['link']) : ?>
                            <a href="<?php echo esc_url($item['link']); ?>" class="marquee-logo-link">
                                <img src="<?php echo esc_url($item['logo']['url']); ?>" alt="<?php echo esc_attr($item['logo']['alt']); ?>" class="marquee-logo-img">
                            </a>
                        <?php else : ?>
                            <img src="<?php echo esc_url($item['logo']['url']); ?>" alt="<?php echo esc_attr($item['logo']['alt']); ?>" class="marquee-logo-img">
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    @keyframes marquee-scroll {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50%);
        }
    }

    .marquee-block {
        overflow: hidden;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
        padding: 0;
    }

    .marquee-block .marquee-track {
        display: inline-flex;
        white-space: nowrap;
        animation: marquee-scroll 25s linear infinite;
    }

    .marquee-block.marquee-pause-on-hover .marquee-track:hover {
        animation-play-state: paused;
    }

    .marquee-block .marquee-content {
        display: inline-flex;
        align-items: center;
    }

    /* ---- Text Mode ---- */
    .marquee-block.marquee-style-text {
        padding: 20px 0;
    }

    .marquee-block.marquee-style-text .marquee-text-item {
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-family: var(--font1);
        color: #1a1a2e;
        text-decoration: none;
        white-space: nowrap;
    }

    .marquee-block.marquee-style-text a.marquee-text-item:hover {
        color: var(--primary);
    }

    .marquee-block .marquee-separator {
        opacity: 0.4;
        margin: 0 30px;
        font-size: 1.5rem;
        color: #1a1a2e;
    }

    /* ---- Logo Mode ---- */
    .marquee-block.marquee-style-logos {
        padding: 25px 0;
    }

    .marquee-block.marquee-style-logos .marquee-content {
        gap: 60px;
    }

    .marquee-block .marquee-logo-img {
        max-height: 45px;
        width: auto;
        filter: grayscale(100%);
        opacity: 0.6;
        transition: var(--transition-default);
    }

    .marquee-block.marquee-pause-on-hover .marquee-logo-img:hover {
        filter: grayscale(0%);
        opacity: 1;
    }

    .marquee-block.marquee-pause-on-hover .marquee-logo-link:hover .marquee-logo-img {
        filter: grayscale(0%);
        opacity: 1;
    }

    .marquee-block .marquee-logo-link {
        display: inline-flex;
        align-items: center;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .marquee-block.marquee-style-logos .marquee-content {
            gap: 45px;
        }

        .marquee-block .marquee-logo-img {
            max-height: 38px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .marquee-block.marquee-style-text .marquee-text-item {
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .marquee-block .marquee-separator {
            margin: 0 20px;
            font-size: 1.2rem;
        }

        .marquee-block.marquee-style-logos .marquee-content {
            gap: 35px;
        }

        .marquee-block .marquee-logo-img {
            max-height: 32px;
        }
    }
</style>
