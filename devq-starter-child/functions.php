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
