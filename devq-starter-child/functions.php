<?php
function devq_child_enqueue_styles() {
    wp_enqueue_style(
        'devq-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('devq-style'),
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'devq_child_enqueue_styles', 20);


/**
 * ──────────────────────────────────────────────────────
 * CHILD THEME BLOCK OVERRIDES
 * ──────────────────────────────────────────────────────
 *
 * The parent theme supports three block override methods:
 *
 * 1. ADD NEW BLOCKS
 *    Uncomment the filter below, add your block name to the array,
 *    then create blocks/[name]/code.php and acfjson/group_[name]_block.json
 *    in this child theme.
 *
 * 2. OVERRIDE A BLOCK TEMPLATE
 *    Copy the parent's blocks/[name]/code.php into this child theme
 *    at the same path: blocks/[name]/code.php
 *    ACF's locate_template() picks up the child version automatically.
 *    No filter needed.
 *
 * 3. OVERRIDE BLOCK STYLES/SCRIPTS
 *    Copy the parent's blocks/[name]/style.css (or script.js) into
 *    this child theme at the same path: blocks/[name]/style.css
 *    The parent's asset resolver loads the child version instead.
 *    No filter needed.
 */

// Uncomment to add custom blocks:
// add_filter('devq_blocks', function ($blocks) {
//     $blocks[] = 'My Custom Block';
//     return $blocks;
// });
