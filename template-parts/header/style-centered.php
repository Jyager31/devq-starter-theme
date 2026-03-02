<?php
/**
 * Header Style - Centered
 * Logo centered above navigation. Elegant, symmetrical layout.
 */

$logo = get_field('branding_logo', 'option');
$layout_mobile_menu_style = get_field('layout_mobile_menu_style', 'option') ?: 'fullscreen';
?>

<header class="devq-header-wrap devq-header-centered">
  <div class="container">
    <div class="devq-header-centered-inner">
      <div class="devq-header-logo-row">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="devq-header-logo">
          <img class="mainLogo" src="<?php echo isset($logo) && $logo ? esc_url($logo['url']) : ''; ?>" alt="<?php echo isset($logo) && $logo ? esc_attr($logo['alt']) : ''; ?>">
        </a>
      </div>

      <nav class="devq-header-nav-row desktopOnly" aria-label="Primary navigation">
        <?php
        wp_nav_menu(array(
          'menu' => 'Desktop',
          'theme_location' => 'primary',
          'menu_class' => 'devq-desktop-nav',
          'container' => false,
          'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'walker' => new fluent_themes_custom_walker_nav_menu
        ));
        ?>
      </nav>

      <div class="devq-header-mobile-toggle mobileOnly">
        <?php get_template_part('template-parts/mobile-menu/style', $layout_mobile_menu_style); ?>
      </div>
    </div>
  </div>
</header>

<style>
  .devq-header-centered {
    position: relative;
    background: #fff;
    z-index: 100;
    border-bottom: 1px solid #f0f0f0;
  }

  .devq-header-centered-inner {
    padding: 20px 0 0;
  }

  .devq-header-centered .devq-header-logo-row {
    text-align: center;
    padding-bottom: 15px;
  }

  .devq-header-centered .devq-header-logo img {
    display: inline-block;
    width: 200px;
    height: auto;
  }

  /* Nav Row */
  .devq-header-centered .devq-header-nav-row {
    border-top: 1px solid #f0f0f0;
    display: flex;
    justify-content: center;
  }

  .devq-header-centered .devq-desktop-nav {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    justify-content: center;
  }

  .devq-header-centered .devq-desktop-nav > li > a {
    text-decoration: none;
    padding: 16px 20px;
    font-weight: 500;
    color: #333;
    font-size: 15px;
    transition: color 0.2s;
    display: flex;
    align-items: center;
    position: relative;
  }

  .devq-header-centered .devq-desktop-nav > li > a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 20px;
    right: 20px;
    height: 2px;
    background: var(--primary);
    transform: scaleX(0);
    transition: transform 0.25s ease;
  }

  .devq-header-centered .devq-desktop-nav > li > a:hover::after,
  .devq-header-centered .devq-desktop-nav > li.current-menu-item > a::after {
    transform: scaleX(1);
  }

  .devq-header-centered .devq-desktop-nav > li > a:hover {
    color: var(--primary);
  }

  .devq-header-centered .devq-desktop-nav > li > a i.fa-caret-down {
    margin-left: 5px;
    font-size: 12px;
    transition: transform 0.2s;
  }

  /* Dropdown */
  .devq-header-centered .dropdown-menu {
    display: block;
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(8px);
    min-width: 220px;
    background: #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    border-radius: var(--button-radius, 4px);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
    padding: 8px 0;
    z-index: var(--z-index-dropdown);
    list-style: none;
  }

  .devq-header-centered .dropdown:hover > .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
  }

  .devq-header-centered .dropdown-menu li a {
    display: block;
    padding: 10px 20px;
    color: #444;
    text-decoration: none;
    font-size: 15px;
    transition: background 0.15s, color 0.15s;
    background: none;
    border-bottom: none;
  }

  .devq-header-centered .dropdown-menu li a:hover {
    background: #f5f5f5;
    color: var(--primary);
  }

  .devq-header-centered .dropdown {
    position: relative;
  }

  /* Mobile Toggle */
  .devq-header-centered .devq-header-mobile-toggle {
    position: absolute;
    right: 15px;
    top: 20px;
  }

  @media (max-width: 1199px) {
    .devq-header-centered-inner {
      padding: 15px 0;
      position: relative;
    }

    .devq-header-centered .devq-header-logo-row {
      padding-bottom: 0;
    }
  }
</style>
