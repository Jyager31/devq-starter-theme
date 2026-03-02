<?php
/**
 * Header Style - Transparent Overlay
 * Sits on top of hero content with transparent bg, becomes solid on scroll.
 *
 * Logo behavior:
 *   - Transparent state: alt logo if provided, otherwise main logo with white filter
 *   - Scrolled state (white bg): always the main logo, no filter
 */

$logo = get_field('branding_logo', 'option');
$alt_logo = get_field('branding_alt_logo', 'option');
$cta = get_field('branding_header_cta', 'option');
$layout_mobile_menu_style = get_field('layout_mobile_menu_style', 'option') ?: 'fullscreen';

$header_classes = 'devq-header-wrap devq-header-transparent';
if ($alt_logo) {
    $header_classes .= ' has-alt-logo';
}
?>

<header class="<?php echo esc_attr($header_classes); ?>" id="devq-header-transparent">
  <div class="container">
    <div class="devq-header">
      <div class="devq-header-logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img class="mainLogo" src="<?php echo isset($logo) && $logo ? esc_url($logo['url']) : ''; ?>" alt="<?php echo isset($logo) && $logo ? esc_attr($logo['alt']) : ''; ?>">
          <?php if ($alt_logo) : ?>
            <img class="altLogo" src="<?php echo esc_url($alt_logo['url']); ?>" alt="<?php echo esc_attr($alt_logo['alt']); ?>">
          <?php endif; ?>
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
          <a href="<?php echo esc_url($cta['url']); ?>" class="btn btn-outline-white devq-header-cta desktopOnly" <?php echo !empty($cta['target']) ? 'target="' . esc_attr($cta['target']) . '"' : ''; ?>>
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

<script>
  (function() {
    var header = document.getElementById('devq-header-transparent');
    if (!header) return;

    var scrollThreshold = 80;

    function onScroll() {
      if (window.scrollY > scrollThreshold) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  })();
</script>

<style>
  .devq-header-transparent {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 100;
    background: transparent;
    transition: background 0.35s ease, box-shadow 0.35s ease;
  }

  .devq-header-transparent.is-scrolled {
    position: fixed;
    background: #fff;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
  }

  .devq-header-transparent .devq-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 0;
    transition: padding 0.3s ease;
    gap: 30px;
  }

  .devq-header-transparent.is-scrolled .devq-header {
    padding: 12px 0;
  }

  /* Logo — shared */
  .devq-header-transparent .devq-header-logo img {
    display: block;
    width: 200px;
    height: auto;
    transition: opacity 0.3s, filter 0.3s;
  }

  /* ── No alt logo: white-filter the main logo in transparent state ── */
  .devq-header-transparent .mainLogo {
    filter: brightness(0) invert(1);
  }

  .devq-header-transparent.is-scrolled .mainLogo {
    filter: none;
  }

  /* ── Alt logo present: swap logos between states ── */

  /* Transparent state: hide main, show alt */
  .devq-header-transparent.has-alt-logo .mainLogo {
    display: none;
    filter: none;
  }

  .devq-header-transparent .altLogo {
    display: block;
  }

  /* Scrolled state: show main, hide alt */
  .devq-header-transparent.has-alt-logo.is-scrolled .mainLogo {
    display: block;
  }

  .devq-header-transparent.is-scrolled .altLogo {
    display: none;
  }

  /* Nav */
  .devq-header-transparent .devq-header-nav {
    flex: 1;
    display: flex;
    justify-content: flex-end;
  }

  .devq-header-transparent .devq-desktop-nav {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
  }

  .devq-header-transparent .devq-desktop-nav > li > a {
    text-decoration: none;
    padding: 10px 16px;
    font-weight: 500;
    color: #fff;
    font-size: 16px;
    transition: color 0.2s, opacity 0.2s;
    display: flex;
    align-items: center;
  }

  .devq-header-transparent .devq-desktop-nav > li > a:hover {
    opacity: 0.75;
  }

  .devq-header-transparent.is-scrolled .devq-desktop-nav > li > a {
    color: #333;
  }

  .devq-header-transparent.is-scrolled .devq-desktop-nav > li > a:hover {
    color: var(--primary);
    opacity: 1;
  }

  .devq-header-transparent .devq-desktop-nav > li > a i.fa-caret-down {
    margin-left: 5px;
    font-size: 12px;
  }

  /* Dropdown */
  .devq-header-transparent .dropdown-menu {
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
  }

  .devq-header-transparent .dropdown:hover > .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }

  .devq-header-transparent .dropdown-menu li a {
    display: block;
    padding: 10px 20px;
    color: #444;
    text-decoration: none;
    font-size: 15px;
    transition: background 0.15s, color 0.15s;
    background: none;
    border-bottom: none;
  }

  .devq-header-transparent .dropdown-menu li a:hover {
    background: #f5f5f5;
    color: var(--primary);
  }

  .devq-header-transparent .dropdown {
    position: relative;
  }

  /* CTA Button */
  .devq-header-transparent .devq-header-cta {
    white-space: nowrap;
    font-size: 14px;
    padding: 10px 24px;
  }

  .devq-header-transparent.is-scrolled .devq-header-cta {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  .devq-header-transparent .devq-header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  /* Hamburger color override for transparent */
  .devq-header-transparent .devq-hamburger .devq-hamburger-bar {
    background: #fff;
  }

  .devq-header-transparent.is-scrolled .devq-hamburger .devq-hamburger-bar {
    background: #333;
  }

  /* Body padding for transparent header — hero needs to account for it */
  body.has-transparent-header {
    padding-top: 0;
  }

  @media (max-width: 1199px) {
    .devq-header-transparent .devq-header {
      justify-content: space-between;
    }

    .devq-header-transparent .devq-header-logo {
      flex: 1;
      text-align: center;
    }

    .devq-header-transparent .devq-header-logo img {
      margin: 0 auto;
    }
  }
</style>
