<?php
/**
 * Header Style - Standard
 * Logo left, navigation right. Refined dropdown with smooth animation.
 */

$logo = get_field('branding_logo', 'option');
$cta = get_field('branding_header_cta', 'option');
$layout_mobile_menu_style = get_field('layout_mobile_menu_style', 'option') ?: 'fullscreen';
?>

<header class="devq-header-wrap devq-header-standard">
  <div class="container">
    <div class="devq-header">
      <div class="devq-header-logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img class="mainLogo" src="<?php echo isset($logo) && $logo ? esc_url($logo['url']) : ''; ?>" alt="<?php echo isset($logo) && $logo ? esc_attr($logo['alt']) : ''; ?>">
        </a>
      </div>

      <nav class="devq-header-nav desktopOnly" aria-label="Primary navigation">
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

      <div class="devq-header-actions">
        <?php if (isset($cta) && $cta) : ?>
          <a href="<?php echo esc_url($cta['url']); ?>" class="btn devq-header-cta desktopOnly" <?php echo !empty($cta['target']) ? 'target="' . esc_attr($cta['target']) . '"' : ''; ?>>
            <?php echo esc_html($cta['title']); ?>
          </a>
        <?php endif; ?>

        <div class="mobileOnly">
          <?php get_template_part('template-parts/mobile-menu/style', $layout_mobile_menu_style); ?>
        </div>
      </div>
    </div>
  </div>
</header>

<style>
  .devq-header-standard {
    position: relative;
    background: #fff;
    z-index: 100;
  }

  .devq-header-standard .devq-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    gap: 30px;
  }

  .devq-header-standard .devq-header-logo img {
    display: block;
    width: 200px;
    height: auto;
  }

  .devq-header-standard .devq-header-nav {
    flex: 1;
    display: flex;
    justify-content: flex-end;
  }

  .devq-header-standard .devq-desktop-nav {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
  }

  .devq-header-standard .devq-desktop-nav > li > a {
    text-decoration: none;
    padding: 10px 16px;
    font-weight: 500;
    color: #333;
    font-size: 16px;
    transition: color 0.2s;
    display: flex;
    align-items: center;
  }

  .devq-header-standard .devq-desktop-nav > li > a:hover {
    color: var(--primary);
  }

  .devq-header-standard .devq-desktop-nav > li > a i.fa-caret-down {
    margin-left: 5px;
    font-size: 12px;
    transition: transform 0.2s;
  }

  .devq-header-standard .devq-desktop-nav > li:hover > a i.fa-caret-down {
    transform: rotate(180deg);
  }

  /* Dropdown */
  .devq-header-standard .dropdown-menu {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 240px;
    background: #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    border-radius: var(--button-radius, 4px);
    opacity: 0;
    visibility: hidden;
    transform: translateY(8px);
    transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
    padding: 8px 0;
    z-index: var(--z-index-dropdown);
    list-style: none;
    overflow: visible;
  }

  .devq-header-standard .dropdown:hover > .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }

  .devq-header-standard .dropdown-menu li a {
    display: block;
    padding: 10px 20px;
    color: #444;
    text-decoration: none;
    font-size: 15px;
    transition: background 0.15s, color 0.15s;
    background: none;
    border-bottom: none;
  }

  .devq-header-standard .dropdown-menu li a:hover {
    background: #f5f5f5;
    color: var(--primary);
  }

  .devq-header-standard .menu-item-has-children,
  .devq-header-standard .dropdown {
    position: relative;
  }

  /* Header actions */
  .devq-header-standard .devq-header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .devq-header-standard .devq-header-cta {
    white-space: nowrap;
    font-size: 14px;
    padding: 10px 24px;
  }

  @media (max-width: 1199px) {
    .devq-header-standard .devq-header {
      justify-content: space-between;
    }

    .devq-header-standard .devq-header-logo {
      flex: 1;
      text-align: center;
    }

    .devq-header-standard .devq-header-logo img {
      margin: 0 auto;
    }
  }
</style>
