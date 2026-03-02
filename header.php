<?php

/**
 * The header for our theme.
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php
// Include theme settings CSS
include(get_template_directory() . '/theme-settings-css.php');

// Get page-specific scripts
$page_head_scripts = get_field('page_head_scripts');
$page_body_scripts = get_field('page_body_scripts');
?>

<head>
  <?php
  // Output scripts
  if ($header_scripts) {
      echo wp_kses_post($header_scripts);
  }
  if ($page_head_scripts) {
      echo wp_kses_post($page_head_scripts);
  }

  // Google Analytics
  if ($google_analytics) : ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($google_analytics); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', '<?php echo esc_attr($google_analytics); ?>');
    </script>
  <?php endif;

  // Google Tag Manager
  if ($google_tag_manager) : ?>
    <!-- Google Tag Manager -->
    <script>
      (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', '<?php echo esc_attr($google_tag_manager); ?>');
    </script>
    <!-- End Google Tag Manager -->
  <?php endif; ?>

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php if (isset($favicon) && $favicon) : ?>
    <link rel="shortcut icon" href="<?php echo esc_url($favicon['url']); ?>" />
  <?php endif; ?>

  <?php wp_head(); ?>
</head>

<body <?php body_class($layout_header_style === 'transparent' ? 'has-transparent-header' : ''); ?>>
  <?php
  // Google Tag Manager (noscript)
  if ($google_tag_manager) : ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($google_tag_manager); ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  <?php endif;

  // Facebook Pixel
  if ($facebook_pixel) : ?>
    <!-- Facebook Pixel Code -->
    <script>
      ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
          n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
      }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '<?php echo esc_attr($facebook_pixel); ?>');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?php echo esc_attr($facebook_pixel); ?>&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->
  <?php endif;

  // Output body scripts
  if ($footer_scripts) {
      echo wp_kses_post($footer_scripts);
  }
  if ($page_body_scripts) {
      echo wp_kses_post($page_body_scripts);
  }
  ?>

  <?php
  // Per-page transparent header override
  if (get_field('page_transparent_header')) {
      $layout_header_style = 'transparent';
  }

  // Load the selected header style
  get_template_part('template-parts/header/style', $layout_header_style);
  ?>

<style>
  /* Shared Hamburger Button Styles */
  .devq-hamburger {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 10;
  }

  .devq-hamburger-box {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 28px;
    height: 20px;
    position: relative;
  }

  .devq-hamburger-bar {
    display: block;
    width: 100%;
    height: 2.5px;
    background: #333;
    border-radius: 2px;
    transition: transform 0.3s ease, opacity 0.3s ease;
    transform-origin: center;
  }

  /* Hamburger → X morph */
  .devq-hamburger.is-active .devq-hamburger-bar:nth-child(1) {
    transform: translateY(7.5px) rotate(45deg);
  }

  .devq-hamburger.is-active .devq-hamburger-bar:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
  }

  .devq-hamburger.is-active .devq-hamburger-bar:nth-child(3) {
    transform: translateY(-7.5px) rotate(-45deg);
  }

  /* Responsive visibility */
  .desktopOnly { display: inherit; }
  .mobileOnly { display: none; }

  @media (max-width: 1199px) {
    .desktopOnly { display: none !important; }
    .mobileOnly { display: block !important; }
    .devq-hamburger { display: block; }
  }
</style>
