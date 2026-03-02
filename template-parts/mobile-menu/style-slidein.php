<?php
/**
 * Mobile Menu - Slide-In Panel (Right)
 * Panel slides in from right edge with backdrop dimming.
 */

$logo = get_field('branding_logo', 'option');
$contact_phone = get_field('contact_phone', 'option');
$email = get_field('contact_email', 'option');
$facebook = get_field('social_facebook', 'option');
$instagram = get_field('social_instagram', 'option');
$linkedin = get_field('social_linkedin', 'option');
$youtube = get_field('social_youtube', 'option');
?>

<!-- Hamburger Toggle -->
<button class="devq-hamburger" id="devq-menu-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="devq-mobile-menu">
  <span class="devq-hamburger-box">
    <span class="devq-hamburger-bar"></span>
    <span class="devq-hamburger-bar"></span>
    <span class="devq-hamburger-bar"></span>
  </span>
</button>

<!-- Backdrop -->
<div class="devq-menu-backdrop" id="devq-menu-backdrop"></div>

<!-- Slide-In Panel -->
<div class="devq-mobile-menu devq-mobile-slidein" id="devq-mobile-menu" data-style="slidein" aria-hidden="true" role="dialog" aria-label="Mobile navigation">
  <div class="devq-slidein-header">
    <?php if (isset($logo) && $logo) : ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="devq-mobile-logo">
        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
      </a>
    <?php endif; ?>
    <button class="devq-menu-close" id="devq-menu-close" aria-label="Close menu">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>

  <nav class="devq-slidein-nav" aria-label="Mobile navigation">
    <?php
    wp_nav_menu(array(
      'menu' => 'Desktop',
      'theme_location' => 'primary',
      'menu_class' => 'devq-mobile-nav',
      'container' => false,
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'walker' => new DevQ_Mobile_Nav_Walker()
    ));
    ?>
  </nav>

  <div class="devq-slidein-footer">
    <?php if (!empty($contact_phone)) : ?>
      <a href="tel:<?php echo esc_attr($contact_phone); ?>" class="devq-slidein-phone">
        <i class="fas fa-phone"></i> <?php echo esc_html($contact_phone); ?>
      </a>
    <?php endif; ?>

    <?php if (!empty($email)) : ?>
      <a href="mailto:<?php echo esc_attr($email); ?>" class="devq-slidein-email">
        <i class="fas fa-envelope"></i> <?php echo esc_html($email); ?>
      </a>
    <?php endif; ?>

    <div class="devq-slidein-social">
      <?php if (!empty($facebook)) : ?><a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
      <?php if (!empty($instagram)) : ?><a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a><?php endif; ?>
      <?php if (!empty($linkedin)) : ?><a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
      <?php if (!empty($youtube)) : ?><a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a><?php endif; ?>
    </div>
  </div>
</div>

<style>
  /* Backdrop */
  .devq-menu-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.35s ease, visibility 0.35s;
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
  }

  .devq-menu-backdrop.is-active {
    opacity: 1;
    visibility: visible;
  }

  /* Slide-In Panel */
  .devq-mobile-slidein {
    position: fixed;
    top: 0;
    right: 0;
    width: 340px;
    max-width: 85vw;
    height: 100%;
    background: #fff;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: -5px 0 30px rgba(0, 0, 0, 0.15);
  }

  .devq-mobile-slidein.is-active {
    transform: translateX(0);
  }

  .devq-slidein-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 25px;
    border-bottom: 1px solid #f0f0f0;
  }

  .devq-slidein-header .devq-mobile-logo img {
    max-width: 140px;
    height: auto;
  }

  .devq-slidein-header .devq-menu-close {
    background: none;
    border: none;
    color: #333;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: background 0.2s, transform 0.2s;
  }

  .devq-slidein-header .devq-menu-close:hover {
    background: #f5f5f5;
    transform: rotate(90deg);
  }

  /* Nav */
  .devq-slidein-nav {
    flex: 1;
    overflow-y: auto;
    padding: 15px 0;
  }

  .devq-mobile-slidein .devq-mobile-nav {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .devq-mobile-slidein .devq-mobile-nav > li {
    opacity: 0;
    transform: translateX(20px);
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  .devq-mobile-slidein .devq-mobile-nav > li.is-visible {
    opacity: 1;
    transform: translateX(0);
  }

  .devq-mobile-slidein .devq-mobile-nav > li > a {
    display: block;
    padding: 14px 25px;
    color: #333;
    text-decoration: none;
    font-family: var(--font1);
    font-size: 1.05rem;
    font-weight: 600;
    transition: background 0.2s, color 0.2s;
    border-left: 3px solid transparent;
  }

  .devq-mobile-slidein .devq-mobile-nav > li > a:hover {
    background: #f8f8f8;
    color: var(--primary);
    border-left-color: var(--primary);
  }

  /* Sub-menu toggle */
  .devq-mobile-slidein .devq-submenu-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 8px 12px;
    font-size: 0.75rem;
    transition: transform 0.3s, color 0.3s;
  }

  .devq-mobile-slidein .menu-item-has-children {
    position: relative;
  }

  .devq-mobile-slidein .submenu-open > .devq-submenu-toggle {
    transform: translateY(-50%) rotate(180deg);
    color: var(--primary);
  }

  .devq-mobile-slidein .sub-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease;
    background: #f9f9f9;
  }

  .devq-mobile-slidein .sub-menu a {
    display: block;
    padding: 10px 25px 10px 40px;
    color: #555;
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.2s;
  }

  .devq-mobile-slidein .sub-menu a:hover {
    color: var(--primary);
  }

  /* Footer */
  .devq-slidein-footer {
    padding: 20px 25px;
    border-top: 1px solid #f0f0f0;
  }

  .devq-slidein-phone,
  .devq-slidein-email {
    display: block;
    color: #555;
    text-decoration: none;
    font-size: 0.9rem;
    padding: 5px 0;
    transition: color 0.2s;
  }

  .devq-slidein-phone:hover,
  .devq-slidein-email:hover {
    color: var(--primary);
  }

  .devq-slidein-phone i,
  .devq-slidein-email i {
    width: 20px;
    text-align: center;
    margin-right: 8px;
    color: var(--primary);
  }

  .devq-slidein-social {
    display: flex;
    gap: 12px;
    margin-top: 15px;
  }

  .devq-slidein-social a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f0f0f0;
    color: #555;
    text-decoration: none;
    font-size: 0.85rem;
    transition: background 0.2s, color 0.2s;
  }

  .devq-slidein-social a:hover {
    background: var(--primary);
    color: #fff;
  }
</style>
