<?php
/**
 * Tabs Block
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
$style = get_field('style') ?: 'horizontal';

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
$unique_block_id = generate_unique_block_id('tabs');

// Build dynamic attributes
$block_classes = 'container-fluid tabs-block tabs-style-' . esc_attr($style);
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
if (!have_rows('tabs')) {
    echo 'Please add tab items for this block.';
    return;
}

// Collect tabs data
$tabs_data = array();
while (have_rows('tabs')) {
    the_row();
    $tabs_data[] = array(
        'title'      => get_sub_field('title'),
        'icon_class' => get_sub_field('icon_class'),
        'content'    => get_sub_field('content'),
    );
}

if (count($tabs_data) < 2) {
    echo 'Please add at least 2 tabs for this block.';
    return;
}

?>

<div class="<?php echo esc_attr($block_classes); ?>" <?php echo $block_id ? 'id="' . esc_attr($block_id) . '"' : ''; ?> <?php echo $aos_attributes; ?> data-block-category="content">
    <div class="container">
        <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="tabs-header" <?php if ($animate) echo devq_aos('fade-up', 0, $animation_duration); ?>>
                <?php if ($eyebrow) : ?>
                    <span class="cs-topper tabs-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="tabs-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="tabs-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="tabs-wrapper" <?php if ($animate) echo devq_aos('fade-up', 200, $animation_duration); ?>>
            <!-- Tab Buttons -->
            <div class="tabs-nav" role="tablist">
                <?php foreach ($tabs_data as $index => $tab) : ?>
                    <button class="tabs-button<?php echo $index === 0 ? ' tabs-button-active' : ''; ?>"
                            role="tab"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            aria-controls="<?php echo esc_attr($block_id); ?>-panel-<?php echo $index; ?>"
                            data-tab-index="<?php echo $index; ?>">
                        <?php if ($tab['icon_class']) : ?>
                            <i class="<?php echo esc_attr($tab['icon_class']); ?> tabs-button-icon"></i>
                        <?php endif; ?>
                        <span><?php echo esc_html($tab['title']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Tab Panels -->
            <div class="tabs-panels">
                <?php foreach ($tabs_data as $index => $tab) : ?>
                    <div class="tabs-panel<?php echo $index === 0 ? ' tabs-panel-active' : ''; ?>"
                         id="<?php echo esc_attr($block_id); ?>-panel-<?php echo $index; ?>"
                         role="tabpanel"
                         data-tab-index="<?php echo $index; ?>">
                        <?php echo wp_kses_post($tab['content']); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Mobile Accordion -->
            <div class="tabs-accordion">
                <?php foreach ($tabs_data as $index => $tab) : ?>
                    <div class="tabs-accordion-item<?php echo $index === 0 ? ' tabs-accordion-item-active' : ''; ?>" data-tab-index="<?php echo $index; ?>">
                        <button class="tabs-accordion-header" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                            <?php if ($tab['icon_class']) : ?>
                                <i class="<?php echo esc_attr($tab['icon_class']); ?> tabs-accordion-icon"></i>
                            <?php endif; ?>
                            <span><?php echo esc_html($tab['title']); ?></span>
                            <span class="tabs-accordion-indicator"></span>
                        </button>
                        <div class="tabs-accordion-content">
                            <div class="tabs-accordion-content-inner">
                                <?php echo wp_kses_post($tab['content']); ?>
                            </div>
                        </div>
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
    .tabs-block {
        padding: var(--section-padding-top) 0 var(--section-padding-bottom) 0;
    }

    .tabs-block .tabs-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 50px;
    }

    .tabs-block .tabs-heading {
        margin-bottom: 0;
    }

    .tabs-block .tabs-subheading {
        color: #666;
        margin-top: 15px;
        line-height: 1.6;
    }

    /* Hide accordion on desktop, show tabs */
    .tabs-block .tabs-accordion {
        display: none;
    }

    .tabs-block .tabs-wrapper {
        display: block;
    }

    .tabs-block .tabs-nav {
        display: flex;
    }

    .tabs-block .tabs-panels {
        display: block;
    }

    /* ---- Horizontal Style ---- */
    .tabs-block.tabs-style-horizontal .tabs-nav {
        flex-direction: row;
        border-bottom: 2px solid #e0e0e0;
        gap: 0;
    }

    .tabs-block.tabs-style-horizontal .tabs-button {
        padding: 16px 32px;
        font-weight: 600;
        font-size: 15px;
        font-family: var(--font2);
        color: #666;
        cursor: pointer;
        border: none;
        background: none;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: var(--transition-default);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .tabs-block.tabs-style-horizontal .tabs-button:hover {
        color: var(--primary);
        background: #f8f7f4;
    }

    .tabs-block.tabs-style-horizontal .tabs-button.tabs-button-active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .tabs-block.tabs-style-horizontal .tabs-panels {
        background: #f8f7f4;
        border-radius: 0 0 12px 12px;
        border: 1px solid #e8e8e8;
        border-top: none;
    }

    .tabs-block.tabs-style-horizontal .tabs-panel {
        display: none;
        padding: 40px;
    }

    .tabs-block.tabs-style-horizontal .tabs-panel.tabs-panel-active {
        display: block;
    }

    .tabs-block.tabs-style-horizontal .tabs-panel > *:first-child {
        margin-top: 0;
    }

    .tabs-block.tabs-style-horizontal .tabs-panel > *:last-child {
        margin-bottom: 0;
    }

    /* ---- Vertical Style ---- */
    .tabs-block.tabs-style-vertical .tabs-wrapper {
        display: flex;
        flex-direction: row;
    }

    .tabs-block.tabs-style-vertical .tabs-nav {
        flex-direction: column;
        min-width: 250px;
        border-right: 2px solid #e0e0e0;
    }

    .tabs-block.tabs-style-vertical .tabs-button {
        padding: 15px 25px;
        font-weight: 600;
        font-family: var(--font2);
        color: #666;
        cursor: pointer;
        border: none;
        background: none;
        border-right: 3px solid transparent;
        margin-right: -2px;
        text-align: left;
        transition: var(--transition-default);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tabs-block.tabs-style-vertical .tabs-button:hover {
        color: var(--primary);
    }

    .tabs-block.tabs-style-vertical .tabs-button:hover {
        background: #f8f7f4;
    }

    .tabs-block.tabs-style-vertical .tabs-button.tabs-button-active {
        color: var(--primary);
        border-right-color: var(--primary);
        background: #f8f7f4;
    }

    .tabs-block.tabs-style-vertical .tabs-panels {
        flex: 1;
        background: #f8f7f4;
        border-radius: 0 12px 12px 0;
        border: 1px solid #e8e8e8;
        border-left: none;
    }

    .tabs-block.tabs-style-vertical .tabs-panel {
        display: none;
        padding: 35px 40px;
    }

    .tabs-block.tabs-style-vertical .tabs-panel > *:first-child {
        margin-top: 0;
    }

    .tabs-block.tabs-style-vertical .tabs-panel > *:last-child {
        margin-bottom: 0;
    }

    .tabs-block.tabs-style-vertical .tabs-panel.tabs-panel-active {
        display: block;
    }

    /* ---- Shared icon style ---- */
    .tabs-block .tabs-button-icon {
        color: inherit;
    }

    /* ---- Accordion styles (mobile) ---- */
    .tabs-block .tabs-accordion-header {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 18px 0;
        background: none;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        cursor: pointer;
        font-weight: 600;
        font-family: var(--font2);
        color: #333;
        transition: var(--transition-default);
    }

    .tabs-block .tabs-accordion-item:first-child .tabs-accordion-header {
        border-top: 1px solid #e0e0e0;
    }

    .tabs-block .tabs-accordion-header:hover {
        color: var(--primary);
    }

    .tabs-block .tabs-accordion-item.tabs-accordion-item-active .tabs-accordion-header {
        color: var(--primary);
    }

    .tabs-block .tabs-accordion-indicator {
        margin-left: auto;
        position: relative;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    .tabs-block .tabs-accordion-indicator::before,
    .tabs-block .tabs-accordion-indicator::after {
        content: '';
        position: absolute;
        background: currentColor;
        transition: var(--transition-default);
    }

    .tabs-block .tabs-accordion-indicator::before {
        top: 50%;
        left: 2px;
        right: 2px;
        height: 2px;
        transform: translateY(-50%);
    }

    .tabs-block .tabs-accordion-indicator::after {
        left: 50%;
        top: 2px;
        bottom: 2px;
        width: 2px;
        transform: translateX(-50%);
    }

    .tabs-block .tabs-accordion-item.tabs-accordion-item-active .tabs-accordion-indicator::after {
        transform: translateX(-50%) rotate(90deg);
        opacity: 0;
    }

    .tabs-block .tabs-accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
    }

    .tabs-block .tabs-accordion-item.tabs-accordion-item-active .tabs-accordion-content {
        max-height: 2000px;
    }

    .tabs-block .tabs-accordion-content-inner {
        padding: 20px 0;
    }

    /* Tablet - 1199px and below */
    @media (max-width: 1199px) {
        .tabs-block .tabs-header {
            margin-bottom: 40px;
        }

        .tabs-block.tabs-style-vertical .tabs-nav {
            min-width: 200px;
        }

        .tabs-block.tabs-style-vertical .tabs-panels {
            padding-left: 30px;
        }
    }

    /* Mobile - 767px and below */
    @media (max-width: 767px) {
        .tabs-block .tabs-nav {
            display: none;
        }

        .tabs-block .tabs-panels {
            display: none;
        }

        .tabs-block .tabs-accordion {
            display: block;
        }

        .tabs-block.tabs-style-vertical .tabs-wrapper {
            display: block;
        }
    }
</style>

<script>
(function() {
    var block = document.getElementById('<?php echo esc_js($block_id); ?>');
    if (!block) return;

    // Desktop tab click
    var tabButtons = block.querySelectorAll('.tabs-button');
    var tabPanels = block.querySelectorAll('.tabs-panel');

    tabButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var index = this.getAttribute('data-tab-index');

            // Deactivate all
            tabButtons.forEach(function(btn) {
                btn.classList.remove('tabs-button-active');
                btn.setAttribute('aria-selected', 'false');
            });
            tabPanels.forEach(function(panel) {
                panel.classList.remove('tabs-panel-active');
            });

            // Activate clicked
            this.classList.add('tabs-button-active');
            this.setAttribute('aria-selected', 'true');
            var targetPanel = block.querySelector('.tabs-panel[data-tab-index="' + index + '"]');
            if (targetPanel) {
                targetPanel.classList.add('tabs-panel-active');
            }
        });
    });

    // Mobile accordion click
    var accordionHeaders = block.querySelectorAll('.tabs-accordion-header');

    accordionHeaders.forEach(function(header) {
        header.addEventListener('click', function() {
            var item = this.closest('.tabs-accordion-item');
            var isActive = item.classList.contains('tabs-accordion-item-active');

            // Close all
            block.querySelectorAll('.tabs-accordion-item').forEach(function(accItem) {
                accItem.classList.remove('tabs-accordion-item-active');
                accItem.querySelector('.tabs-accordion-header').setAttribute('aria-expanded', 'false');
            });

            // Toggle clicked
            if (!isActive) {
                item.classList.add('tabs-accordion-item-active');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });
})();
</script>
