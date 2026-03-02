<?php
/**
 * Comparison Table Block
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
$columns = get_field('columns');
$features = get_field('features');

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
$unique_block_id = generate_unique_block_id('comparisontable');

// Build dynamic attributes
$block_classes = 'container-fluid comparisontable-block';
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

// Count columns
$col_count = 0;
if ($columns && is_array($columns)) {
    $col_count = count($columns);
}

// Check required fields
if ($col_count < 2 || !$features) {
    echo 'Please add at least 2 columns and 1 feature for this block.';
    return;
}

/**
 * Helper: render a cell value with check/cross icon support
 */
function comparisontable_render_value($value) {
    $value = trim($value);
    $lower = strtolower($value);
    if ($value === '&#10003;' || $value === "\xE2\x9C\x93" || mb_strpos($value, "\xE2\x9C\x93") !== false || $lower === 'yes' || $lower === 'true') {
        return '<i class="fa-solid fa-check comparisontable-check"></i>';
    }
    if ($value === '&#10007;' || $value === "\xE2\x9C\x97" || mb_strpos($value, "\xE2\x9C\x97") !== false || $lower === 'no' || $lower === 'false') {
        return '<i class="fa-solid fa-xmark comparisontable-xmark"></i>';
    }
    return esc_html($value);
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="cards">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="comparisontable-header">
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper comparisontable-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="comparisontable-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="comparisontable-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="comparisontable-wrapper">
            <div class="comparisontable-scroll-hint"></div>
            <div class="comparisontable-grid" style="grid-template-columns: minmax(180px, 1.5fr) repeat(<?php echo esc_attr($col_count); ?>, 1fr);">

                <?php // Header row: empty cell + column names ?>
                <div class="comparisontable-cell comparisontable-corner"></div>
                <?php foreach ($columns as $col_index => $column) :
                    $is_highlighted = !empty($column['is_highlighted']);
                    $cell_class = 'comparisontable-cell comparisontable-col-header';
                    if ($is_highlighted) {
                        $cell_class .= ' comparisontable-highlighted';
                    }
                    ?>
                    <div class="<?php echo esc_attr($cell_class); ?>">
                        <?php echo esc_html($column['name']); ?>
                    </div>
                <?php endforeach; ?>

                <?php // Feature rows
                foreach ($features as $row_index => $feature) :
                    $row_class = ($row_index % 2 === 0) ? 'comparisontable-row-even' : 'comparisontable-row-odd';
                    ?>
                    <div class="comparisontable-cell comparisontable-feature-name <?php echo esc_attr($row_class); ?>">
                        <?php echo esc_html($feature['feature_name']); ?>
                    </div>
                    <?php for ($i = 0; $i < $col_count; $i++) :
                        $col_key = 'col_' . ($i + 1);
                        $value = isset($feature[$col_key]) ? $feature[$col_key] : '';
                        $is_highlighted = !empty($columns[$i]['is_highlighted']);
                        $cell_class = 'comparisontable-cell comparisontable-value ' . $row_class;
                        if ($is_highlighted) {
                            $cell_class .= ' comparisontable-highlighted';
                        }
                        ?>
                        <div class="<?php echo esc_attr($cell_class); ?>">
                            <?php echo comparisontable_render_value($value); ?>
                        </div>
                    <?php endfor; ?>
                <?php endforeach; ?>

                <?php // Button row ?>
                <div class="comparisontable-cell comparisontable-btn-spacer"></div>
                <?php foreach ($columns as $col_index => $column) :
                    $is_highlighted = !empty($column['is_highlighted']);
                    $button = $column['button'];
                    $cell_class = 'comparisontable-cell comparisontable-btn-cell';
                    if ($is_highlighted) {
                        $cell_class .= ' comparisontable-highlighted';
                    }
                    ?>
                    <div class="<?php echo esc_attr($cell_class); ?>">
                        <?php if ($button) : ?>
                            <a href="<?php echo esc_url($button['url']); ?>" class="comparisontable-btn <?php echo $is_highlighted ? 'comparisontable-btn-primary' : 'comparisontable-btn-outline'; ?>" <?php echo !empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                                <?php echo esc_html($button['title'] ?: 'Get Started'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

<?php
output_block_spacing_css($margin_top, $margin_bottom, $margin_top_other, $margin_bottom_other, $block_id);
?>

<style>
    .comparisontable-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .comparisontable-block .comparisontable-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 50px;
    }

    .comparisontable-block .comparisontable-heading {
        margin-bottom: 15px;
    }

    .comparisontable-block .comparisontable-subheading {
        color: #666;
        line-height: 1.6;
    }

    .comparisontable-block .comparisontable-wrapper {
        position: relative;
    }

    .comparisontable-block .comparisontable-grid {
        display: grid;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
    }

    /* Corner cell (top-left) */
    .comparisontable-block .comparisontable-corner {
        background: #f8f7f4;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    /* Column header cells */
    .comparisontable-block .comparisontable-col-header {
        background: #f8f7f4;
        padding: 20px;
        font-weight: 700;
        font-size: 1.1rem;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    .comparisontable-block .comparisontable-col-header.comparisontable-highlighted {
        background: var(--primary);
        color: #fff;
    }

    /* Feature name cells */
    .comparisontable-block .comparisontable-feature-name {
        padding: 15px 20px;
        font-weight: 600;
        text-align: left;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }

    /* Value cells */
    .comparisontable-block .comparisontable-value {
        padding: 15px 20px;
        text-align: center;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Alternating row backgrounds */
    .comparisontable-block .comparisontable-row-even {
        background: #fff;
    }

    .comparisontable-block .comparisontable-row-odd {
        background: #fafafa;
    }

    /* Highlighted column tint */
    .comparisontable-block .comparisontable-value.comparisontable-highlighted {
        background: rgba(59, 191, 173, 0.05);
    }

    .comparisontable-block .comparisontable-row-odd.comparisontable-highlighted {
        background: rgba(59, 191, 173, 0.08);
    }

    /* Check / X icons */
    .comparisontable-block .comparisontable-check {
        color: #22c55e;
        font-size: 1.2rem;
    }

    .comparisontable-block .comparisontable-xmark {
        color: #ef4444;
        font-size: 1.2rem;
    }

    /* Button row */
    .comparisontable-block .comparisontable-btn-spacer {
        padding: 20px;
        background: #fff;
    }

    .comparisontable-block .comparisontable-btn-cell {
        padding: 20px;
        text-align: center;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .comparisontable-block .comparisontable-btn-cell.comparisontable-highlighted {
        background: rgba(59, 191, 173, 0.05);
    }

    .comparisontable-block .comparisontable-btn {
        display: inline-block;
        padding: var(--button-padding, 12px 28px);
        border-radius: var(--button-radius, 6px);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-default);
        white-space: nowrap;
    }

    .comparisontable-block .comparisontable-btn-primary {
        background: var(--primary);
        color: #fff;
        border: 2px solid var(--primary);
    }

    .comparisontable-block .comparisontable-btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .comparisontable-block .comparisontable-btn-outline {
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .comparisontable-block .comparisontable-btn-outline:hover {
        background: var(--primary);
        color: #fff;
    }

    /* Scroll hint (mobile only, shown via JS/media query) */
    .comparisontable-block .comparisontable-scroll-hint {
        display: none;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .comparisontable-block .comparisontable-header {
            margin-bottom: 40px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .comparisontable-block .comparisontable-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -15px;
            padding: 0 15px;
        }

        .comparisontable-block .comparisontable-grid {
            min-width: max-content;
        }

        .comparisontable-block .comparisontable-feature-name,
        .comparisontable-block .comparisontable-corner,
        .comparisontable-block .comparisontable-btn-spacer {
            position: sticky;
            left: 0;
            z-index: 2;
            min-width: 140px;
        }

        .comparisontable-block .comparisontable-col-header,
        .comparisontable-block .comparisontable-value,
        .comparisontable-block .comparisontable-btn-cell {
            min-width: 150px;
        }

        .comparisontable-block .comparisontable-feature-name.comparisontable-row-even,
        .comparisontable-block .comparisontable-btn-spacer {
            background: #fff;
        }

        .comparisontable-block .comparisontable-feature-name.comparisontable-row-odd {
            background: #fafafa;
        }

        .comparisontable-block .comparisontable-corner {
            background: #f8f7f4;
        }

        .comparisontable-block .comparisontable-scroll-hint {
            display: block;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 30px;
            background: linear-gradient(to right, rgba(255,255,255,0), rgba(0,0,0,0.06));
            pointer-events: none;
            z-index: 3;
        }

        .comparisontable-block .comparisontable-header {
            margin-bottom: 30px;
        }

        .comparisontable-block .comparisontable-btn {
            padding: 10px 18px;
            font-size: 0.9rem;
        }
    }
</style>
