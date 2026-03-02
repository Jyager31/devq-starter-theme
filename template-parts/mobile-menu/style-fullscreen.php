<?php
/**
 * Mobile Menu - Full-Screen Overlay
 * Covers entire viewport with centered links and staggered fade-in.
 */

$logo = get_field('branding_logo', 'option');
$contact_phone = get_field('contact_phone', 'option');
?>

<!-- Hamburger Toggle -->
<button class="devq-hamburger" id="devq-menu-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="devq-mobile-menu">
  <span class="devq-hamburger-box">
    <span class="devq-hamburger-bar"></span>
    <span class="devq-hamburger-bar"></span>
    <span class="devq-hamburger-bar"></span>
  </span>
</button>

<!-- Full-Screen Menu -->
<div class="devq-mobile-menu devq-mobile-fullscreen" id="devq-mobile-menu" data-style="fullscreen" aria-hidden="true" role="dialog" aria-label="Mobile navigation">
  <button class="devq-menu-close" id="devq-menu-close" aria-label="Close menu">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>

  <?php if (isset($logo) && $logo) : ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="devq-mobile-logo">
      <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
    </a>
  <?php endif; ?>

  <nav aria-label="Mobile navigation">
    <?php
    wp_nav_menu(array(
      'menu' => 'Desktop',
      'theme_location' => 'primary',
      'menu_class' => 'devq-mobile-nav',
      'container' => false,
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'link_before' => '',
      'link_after' => '',
      'walker' => new DevQ_Mobile_Nav_Walker()
    ));
    ?>
  </nav>

  <?php if (!empty($contact_phone)) : ?>
    <div class="devq-mobile-contact">
      <a href="tel:<?php echo esc_attr($contact_phone); ?>">
        <i class="fas fa-phone"></i> <?php echo esc_html($contact_phone); ?>
      </a>
    </div>
  <?php endif; ?>
</div>

<style>
  /* Full-Screen Overlay */
  .devq-mobile-fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.4s;
  }

  .devq-mobile-fullscreen.is-active {
    opacity: 1;
    visibility: visible;
  }

  .devq-mobile-fullscreen .devq-menu-close {
    position: absolute;
    top: 25px;
    right: 25px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 10px;
    z-index: 10;
    opacity: 0.7;
    transition: opacity 0.2s, transform 0.2s;
  }

  .devq-mobile-fullscreen .devq-menu-close:hover {
    opacity: 1;
    transform: rotate(90deg);
  }

  .devq-mobile-fullscreen .devq-mobile-logo {
    margin-bottom: var(--spacing-large);
  }

  .devq-mobile-fullscreen .devq-mobile-logo img {
    max-width: 180px;
    height: auto;
    filter: brightness(0) invert(1);
  }

  .devq-mobile-fullscreen .devq-mobile-nav {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
  }

  .devq-mobile-fullscreen .devq-mobile-nav > li {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
  }

  .devq-mobile-fullscreen .devq-mobile-nav > li.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  .devq-mobile-fullscreen .devq-mobile-nav > li > a {
    display: inline-block;
    color: white;
    text-decoration: none;
    font-family: var(--font1);
    font-size: 2rem;
    font-weight: 600;
    padding: 12px 0;
    position: relative;
    transition: opacity 0.2s;
  }

  .devq-mobile-fullscreen .devq-mobile-nav > li > a:hover {
    opacity: 0.7;
  }

  .devq-mobile-fullscreen .devq-mobile-nav > li > a::after {
    content: '';
    position: absolute;
    bottom: 8px;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--tertiary);
    transition: width 0.3s ease, left 0.3s ease;
  }

  .devq-mobile-fullscreen .devq-mobile-nav > li > a:hover::after {
    width: 100%;
    left: 0;
  }

  /* Sub-menu styling */
  .devq-mobile-fullscreen .devq-submenu-toggle {
    background: none;
    border: none;
    color: rgba(255,255,255,0.6);
    cursor: pointer;
    padding: 5px 10px;
    font-size: 0.9rem;
    vertical-align: middle;
  }

  .devq-mobile-fullscreen .sub-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease;
  }

  .devq-mobile-fullscreen .submenu-open > .sub-menu {
    margin-top: 5px;
  }

  .devq-mobile-fullscreen .sub-menu a {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    font-size: 1.2rem;
    padding: 8px 0;
    display: inline-block;
    transition: color 0.2s;
  }

  .devq-mobile-fullscreen .sub-menu a:hover {
    color: var(--tertiary);
  }

  .devq-mobile-fullscreen .devq-mobile-contact {
    margin-top: var(--spacing-large);
  }

  .devq-mobile-fullscreen .devq-mobile-contact a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.2s;
  }

  .devq-mobile-fullscreen .devq-mobile-contact a:hover {
    color: var(--tertiary);
  }

  @media (max-width: 767px) {
    .devq-mobile-fullscreen .devq-mobile-nav > li > a {
      font-size: 1.6rem;
      padding: 10px 0;
    }

    .devq-mobile-fullscreen .devq-mobile-logo img {
      max-width: 140px;
    }
  }
</style>
