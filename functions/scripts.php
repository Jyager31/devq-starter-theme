<?php

/**
 * Enqueue scripts and styles.
 */
function devqbase_scripts()
{
  $theme_dir = get_template_directory();
  $theme_uri = get_template_directory_uri();

  // --- Always loaded CSS ---

  wp_enqueue_style('slick', $theme_uri . '/assets/css/slick.css');

  // AOS Animation Library
  wp_enqueue_style('aos', $theme_uri . '/assets/css/aos.css');

  // Mobile menu (required)
  wp_enqueue_style('mmenu', $theme_uri . '/assets/css/mmenu.css');
  wp_enqueue_style('mburger', $theme_uri . '/assets/css/mburger.css');

  // Grid system (required)
  wp_enqueue_style('reflex', $theme_uri . '/assets/css/reflex.css');

  // Main theme stylesheet (required)
  wp_enqueue_style('devq-style', $theme_uri . '/style.css', array(), filemtime($theme_dir . '/style.css'));

  // --- Conditionally loaded CSS (uncomment when needed for a project) ---
  // wp_enqueue_style('magnific-popup', $theme_uri . '/assets/css/magnific-popup.css');
  wp_enqueue_style('jquery-beefup', $theme_uri . '/assets/css/jquery.beefup.css');

  // --- Always loaded JS ---

  // Use WordPress bundled jQuery (required)
  wp_enqueue_script('jquery');

  // Mobile menu (required)
  wp_enqueue_script('mmenu', $theme_uri . '/assets/js/mmenu.js', array('jquery'), '', true);

  // Slick slider
  wp_enqueue_script('slick', $theme_uri . '/assets/js/slick.js', array('jquery'), '', true);

  // AOS Animation Library
  wp_enqueue_script('aos', $theme_uri . '/assets/js/aos.js', array('jquery'), '', true);

  // Custom theme JS (required)
  wp_enqueue_script('devq-custom', $theme_uri . '/assets/js/custom.js', array('jquery'), filemtime($theme_dir . '/assets/js/custom.js'), true);

  // --- Conditionally loaded JS (uncomment when needed for a project) ---
  // wp_enqueue_script('magnific-popup', $theme_uri . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '', true);
  // wp_enqueue_script('jquery-validate', $theme_uri . '/assets/js/jquery.validate.min.js', array('jquery'), '', true);
  // wp_enqueue_script('jquery-validate-additional', $theme_uri . '/assets/js/additional-methods.min.js', array('jquery'), '', true);
  wp_enqueue_script('jquery-beefup', $theme_uri . '/assets/js/jquery.beefup.min.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'devqbase_scripts');


function my_login_stylesheet()
{
  wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.css');
}
add_action('login_enqueue_scripts', 'my_login_stylesheet');
