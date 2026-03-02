<?php
/**
 * Team Block
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
$columns = get_field('columns') ?: '3';

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
$unique_block_id = generate_unique_block_id('team');

// Build dynamic attributes
$block_classes = 'container-fluid team-block team-cols-' . esc_attr($columns);
if ($custom_class) {
    $block_classes .= ' ' . $custom_class;
}

$block_id = $custom_id ? $custom_id : $unique_block_id;

// Build AOS attributes (block-level for header only; members get individual AOS)
$aos_attributes = '';
if (!$disable_animation) {
    $aos_attributes .= 'data-aos="' . esc_attr($animation_type) . '"';
    if ($animation_duration != 800) {
        $aos_attributes .= ' data-aos-duration="' . esc_attr($animation_duration) . '"';
    }
}

// Social platform icon map
$social_icons = array(
    'facebook'  => 'fa-brands fa-facebook-f',
    'twitter'   => 'fa-brands fa-twitter',
    'instagram' => 'fa-brands fa-instagram',
    'linkedin'  => 'fa-brands fa-linkedin-in',
    'youtube'   => 'fa-brands fa-youtube',
    'tiktok'    => 'fa-brands fa-tiktok',
    'github'    => 'fa-brands fa-github',
    'website'   => 'fa-solid fa-globe',
);

// Check required fields
if (!$heading && !have_rows('members')) {
    echo 'Please add a heading or team members for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> data-block-category="cards">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="team-header" <?php echo $aos_attributes; ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper team-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="team-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="team-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('members')) : $member_index = 0; ?>
            <div class="team-grid">
                <?php while (have_rows('members')) : the_row();
                    $photo = devq_get_image_or_placeholder('photo', 400, 400, 'team-' . $member_index, true);
                    $name = get_sub_field('name');
                    $role = get_sub_field('role');
                    $bio = get_sub_field('bio');
                    $delay = $member_index * 100;
                    ?>
                    <div class="team-card" <?php if (!$disable_animation) : ?>data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>"<?php endif; ?>>
                        <?php if ($photo) : ?>
                            <div class="team-card-photo">
                                <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt'] ?: $name); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="team-card-body">
                            <?php if ($name) : ?>
                                <h3 class="team-card-name"><?php echo esc_html($name); ?></h3>
                            <?php endif; ?>
                            <?php if ($role) : ?>
                                <p class="team-card-role"><?php echo esc_html($role); ?></p>
                            <?php endif; ?>
                            <?php if ($bio) : ?>
                                <p class="team-card-bio"><?php echo esc_html($bio); ?></p>
                            <?php endif; ?>
                            <?php if (have_rows('social_links')) : ?>
                                <div class="team-card-social">
                                    <?php while (have_rows('social_links')) : the_row();
                                        $platform = get_sub_field('platform');
                                        $url = get_sub_field('url');
                                        if ($platform && $url) :
                                            $icon = isset($social_icons[$platform]) ? $social_icons[$platform] : 'fa-solid fa-link';
                                            ?>
                                            <a href="<?php echo esc_url($url); ?>" class="team-card-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                                                <i class="<?php echo esc_attr($icon); ?>"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $member_index++; endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .team-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .team-block .team-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .team-block .team-heading {
        margin-bottom: 15px;
    }

    .team-block .team-subheading {
        color: #666;
        line-height: 1.6;
    }

    .team-block .team-grid {
        display: grid;
        gap: 30px;
    }

    .team-block.team-cols-2 .team-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .team-block.team-cols-3 .team-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .team-block.team-cols-4 .team-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .team-block .team-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        transition: var(--transition-default);
    }

    .team-block .team-card:hover {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .team-block .team-card-photo img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        display: block;
    }

    .team-block .team-card-body {
        padding: 25px 20px;
        text-align: center;
    }

    .team-block .team-card-name {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .team-block .team-card-role {
        color: var(--secondary);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .team-block .team-card-bio {
        color: #666;
        font-size: 15px;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .team-block .team-card-social {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .team-block .team-card-social-link {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: var(--transition-default);
        text-decoration: none;
    }

    .team-block .team-card-social-link:hover {
        background: var(--tertiary);
        color: #000;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .team-block.team-cols-4 .team-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .team-block .team-grid {
            grid-template-columns: 1fr !important;
        }

        .team-block .team-card {
            max-width: 400px;
            margin: 0 auto;
        }

        .team-block .team-header {
            margin-bottom: 40px;
        }
    }
</style>
