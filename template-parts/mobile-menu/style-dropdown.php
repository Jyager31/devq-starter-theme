<?php
/**
 * Mobile Menu - Dropdown Reveal
 * Slides down from header, pushing content down.
 */

$contact_phone = get_field('contact_phone', 'option');
$email = get_field('contact_email', 'option');
?>

<!-- Hamburger Toggle -->
<button class="devq-hamburger" id="devq-menu-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="devq-mobile-menu">
  <span class="devq-hamburger-box">
    <span class="devq-hamburger-bar"></span>
    <span class="devq-hamburger-bar"></span>
    <span class="devq-hamburger-bar"></span>
  </span>
</button>

<!-- Dropdown Menu -->
<div class="devq-mobile-menu devq-mobile-dropdown" id="devq-mobile-menu" data-style="dropdown" aria-hidden="true">
  <div class="container">
    <nav aria-label="Mobile navigation">
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

    <div class="devq-dropdown-extras">
      <?php if (!empty($contact_phone)) : ?>
        <a href="tel:<?php echo esc_attr($contact_phone); ?>" class="devq-dropdown-link">
          <i class="fas fa-phone"></i> <?php echo esc_html($contact_phone); ?>
        </a>
      <?php endif; ?>
      <?php if (!empty($email)) : ?>
        <a href="mailto:<?php echo esc_attr($email); ?>" class="devq-dropdown-link">
          <i class="fas fa-envelope"></i> <?php echo esc_html($email); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<style>
  /* Dropdown Reveal */
  .devq-mobile-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #fff;
    z-index: 9999;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border-top: 3px solid var(--primary);
  }

  .devq-mobile-dropdown.is-active {
    max-height: 80vh;
    overflow-y: auto;
  }

  .devq-mobile-dropdown .devq-mobile-nav {
    list-style: none;
    padding: 20px 0 10px;
    margin: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
  }

  .devq-mobile-dropdown .devq-mobile-nav > li {
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  .devq-mobile-dropdown .devq-mobile-nav > li.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  .devq-mobile-dropdown .devq-mobile-nav > li > a {
    display: block;
    padding: 14px 15px;
    color: #333;
    text-decoration: none;
    font-family: var(--font1);
    font-size: 1rem;
    font-weight: 600;
    transition: color 0.2s, background 0.2s;
    border-bottom: 1px solid #f0f0f0;
  }

  .devq-mobile-dropdown .devq-mobile-nav > li > a:hover {
    color: var(--primary);
    background: #fafafa;
  }

  /* Sub-menu */
  .devq-mobile-dropdown .devq-submenu-toggle {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 8px 10px;
    font-size: 0.7rem;
    transition: transform 0.3s;
  }

  .devq-mobile-dropdown .menu-item-has-children {
    position: relative;
  }

  .devq-mobile-dropdown .submenu-open > .devq-submenu-toggle {
    transform: translateY(-50%) rotate(180deg);
  }

  .devq-mobile-dropdown .sub-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #f8f8f8;
  }

  .devq-mobile-dropdown .sub-menu a {
    display: block;
    padding: 10px 15px 10px 30px;
    color: #555;
    text-decoration: none;
    font-size: 0.9rem;
    border-bottom: 1px solid #eee;
    transition: color 0.2s;
  }

  .devq-mobile-dropdown .sub-menu a:hover {
    color: var(--primary);
  }

  /* Extras */
  .devq-dropdown-extras {
    display: flex;
    gap: 20px;
    padding: 15px 0 20px;
    border-top: 1px solid #eee;
  }

  .devq-dropdown-link {
    color: #555;
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.2s;
  }

  .devq-dropdown-link:hover {
    color: var(--primary);
  }

  .devq-dropdown-link i {
    margin-right: 6px;
    color: var(--primary);
  }

  @media (max-width: 767px) {
    .devq-mobile-dropdown .devq-mobile-nav {
      grid-template-columns: 1fr;
    }

    .devq-dropdown-extras {
      flex-direction: column;
      gap: 8px;
    }
  }
</style>
