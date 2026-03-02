<?php
/**
 * Contact Split Block
 */

// Error handling
if (!function_exists('get_field')) {
    echo 'ACF plugin is not active. This block requires ACF to function properly.';
    return;
}

// ACF Fields - Content Tab
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$show_phone = get_field('show_phone');
$show_email = get_field('show_email');
$show_address = get_field('show_address');
$show_hours = get_field('show_hours');
$hours = get_field('hours');
$show_map = get_field('show_map');
$map_embed = get_field('map_embed');
$form_shortcode = get_field('form_shortcode');

// Pull contact info from theme settings (ACF options)
$phone = get_field('contact_phone', 'option');
$email = get_field('contact_email', 'option');
$address = get_field('contact_address', 'option');

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
$unique_block_id = generate_unique_block_id('contactsplit');

// Build dynamic attributes
$block_classes = 'container-fluid contactsplit-block';
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes for info column
$info_aos = '';
if (!$disable_animation) {
    if ($is_recommended) {
        $info_aos = devq_aos('fade-right', 0, $animation_duration);
    } else {
        $info_aos = 'data-aos="' . esc_attr($animation_type) . '"';
        if ($animation_duration != 800) {
            $info_aos .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
        }
    }
}

// Build AOS attributes for form column
$form_aos = '';
if (!$disable_animation) {
    if ($is_recommended) {
        $form_aos = devq_aos('fade-left', 200, $animation_duration);
    } else {
        $form_aos = 'data-aos="fade-up" data-aos-delay="100"';
    }
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="conversion">
    <div class="container">
        <div class="contactsplit-grid">
            <div class="contactsplit-info" <?php echo $info_aos; ?>>
                <?php if ($eyebrow || $heading) : ?>
                    <div class="contactsplit-header">
                        <?php if ($eyebrow) : ?>
                            <span class="cs-topper contactsplit-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                        <?php endif; ?>
                        <?php if ($heading) : ?>
                            <h2 class="contactsplit-heading"><?php echo esc_html($heading); ?></h2>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="contactsplit-details">
                    <?php if ($show_phone && $phone) : ?>
                        <div class="contactsplit-item">
                            <div class="contactsplit-item-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="contactsplit-item-text">
                                <div class="contactsplit-item-label">Phone</div>
                                <div class="contactsplit-item-value">
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_email && $email) : ?>
                        <div class="contactsplit-item">
                            <div class="contactsplit-item-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="contactsplit-item-text">
                                <div class="contactsplit-item-label">Email</div>
                                <div class="contactsplit-item-value">
                                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_address && $address) : ?>
                        <div class="contactsplit-item">
                            <div class="contactsplit-item-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="contactsplit-item-text">
                                <div class="contactsplit-item-label">Address</div>
                                <div class="contactsplit-item-value"><?php echo esc_html($address); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_hours && $hours) : ?>
                        <div class="contactsplit-item">
                            <div class="contactsplit-item-icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div class="contactsplit-item-text">
                                <div class="contactsplit-item-label">Hours</div>
                                <div class="contactsplit-item-value"><?php echo nl2br(esc_html($hours)); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($show_map && $map_embed) : ?>
                    <div class="contactsplit-map">
                        <?php echo wp_kses($map_embed, array(
                            'iframe' => array(
                                'src' => true,
                                'width' => true,
                                'height' => true,
                                'style' => true,
                                'frameborder' => true,
                                'allowfullscreen' => true,
                                'loading' => true,
                                'referrerpolicy' => true,
                            ),
                        )); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($form_shortcode) : ?>
                <div class="contactsplit-form" <?php echo $form_aos; ?>>
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .contactsplit-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
        background: #f8f7f4;
    }

    .contactsplit-block .contactsplit-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    .contactsplit-block .contactsplit-header {
        margin-bottom: 30px;
    }

    .contactsplit-block .contactsplit-heading {
        margin-bottom: 10px;
    }

    .contactsplit-block .contactsplit-details {
        /* Contact items container */
    }

    .contactsplit-block .contactsplit-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }

    .contactsplit-block .contactsplit-item:last-child {
        margin-bottom: 0;
    }

    .contactsplit-block .contactsplit-item-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .contactsplit-block .contactsplit-item-text {
        flex: 1;
    }

    .contactsplit-block .contactsplit-item-label {
        font-weight: 700;
        margin-bottom: 3px;
        font-size: 15px;
    }

    .contactsplit-block .contactsplit-item-value {
        color: #666;
    }

    .contactsplit-block .contactsplit-item-value a {
        color: #666;
        text-decoration: none;
        transition: var(--transition-default);
    }

    .contactsplit-block .contactsplit-item-value a:hover {
        color: var(--primary);
    }

    .contactsplit-block .contactsplit-map {
        margin-top: 20px;
        border-radius: 12px;
        overflow: hidden;
    }

    .contactsplit-block .contactsplit-map iframe {
        width: 100%;
        display: block;
    }

    .contactsplit-block .contactsplit-form {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .contactsplit-block .contactsplit-grid {
            gap: 40px;
        }

        .contactsplit-block .contactsplit-form {
            padding: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .contactsplit-block .contactsplit-grid {
            grid-template-columns: 1fr;
        }

        .contactsplit-block .contactsplit-form {
            padding: 25px;
        }
    }
</style>
