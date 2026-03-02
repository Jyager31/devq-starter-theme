<?php
/**
 * Footer Style - CTA + Columns
 * Call-to-action banner above multi-column footer.
 */

$company_name = get_field('branding_company_name', 'option');
$footer_logo_img = get_field('branding_logo', 'option');
$contact_phone_val = get_field('contact_phone', 'option');
$contact_email_val = get_field('contact_email', 'option');
$contact_address_val = get_field('contact_address', 'option');

$social_facebook = get_field('social_facebook', 'option');
$social_instagram = get_field('social_instagram', 'option');
$social_linkedin = get_field('social_linkedin', 'option');
$social_youtube = get_field('social_youtube', 'option');
$social_twitter = get_field('social_twitter', 'option');
?>

<footer class="devq-footer devq-footer-cta">
  <!-- CTA Section -->
  <div class="devq-footer-cta-banner">
    <div class="container">
      <div class="devq-cta-inner">
        <div class="devq-cta-text">
          <h3>Ready to get started?</h3>
          <p>Let's bring your vision to life. Get in touch today.</p>
        </div>
        <div class="devq-cta-action">
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-white">Get in Touch</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Columns Section -->
  <div class="devq-footer-main">
    <div class="container">
      <div class="devq-footer-grid">
        <!-- Column 1: Brand -->
        <div class="devq-footer-col devq-footer-brand">
          <?php if ($footer_logo_img) : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="devq-footer-logo">
              <img src="<?php echo esc_url($footer_logo_img['url']); ?>" alt="<?php echo esc_attr($footer_logo_img['alt']); ?>">
            </a>
          <?php endif; ?>
          <?php if ($company_name) : ?>
            <p class="devq-footer-desc"><?php echo esc_html($company_name); ?></p>
          <?php endif; ?>

          <?php if ($social_facebook || $social_instagram || $social_linkedin || $social_youtube || $social_twitter) : ?>
            <div class="devq-footer-social">
              <?php if ($social_facebook) : ?><a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
              <?php if ($social_instagram) : ?><a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a><?php endif; ?>
              <?php if ($social_linkedin) : ?><a href="<?php echo esc_url($social_linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
              <?php if ($social_youtube) : ?><a href="<?php echo esc_url($social_youtube); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a><?php endif; ?>
              <?php if ($social_twitter) : ?><a href="<?php echo esc_url($social_twitter); ?>" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a><?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="devq-footer-col">
          <h4 class="devq-footer-heading">Quick Links</h4>
          <?php
          wp_nav_menu(array(
            'menu' => 'Desktop',
            'theme_location' => 'primary',
            'menu_class' => 'devq-footer-links',
            'container' => false,
            'depth' => 1,
            'items_wrap' => '<ul class="%2$s">%3$s</ul>',
          ));
          ?>
        </div>

        <!-- Column 3: Contact -->
        <div class="devq-footer-col">
          <h4 class="devq-footer-heading">Contact</h4>
          <ul class="devq-footer-contact">
            <?php if ($contact_phone_val) : ?>
              <li><i class="fas fa-phone"></i><a href="tel:<?php echo esc_attr($contact_phone_val); ?>"><?php echo esc_html($contact_phone_val); ?></a></li>
            <?php endif; ?>
            <?php if ($contact_email_val) : ?>
              <li><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_attr($contact_email_val); ?>"><?php echo esc_html($contact_email_val); ?></a></li>
            <?php endif; ?>
            <?php if ($contact_address_val) : ?>
              <li><i class="fas fa-map-marker-alt"></i><span><?php echo esc_html($contact_address_val); ?></span></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Copyright Bar -->
  <div class="devq-footer-copyright">
    <div class="container">
      <p>Copyright &copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html($company_name); ?> - Website Powered by <a href="https://thedevq.com/" target="_blank" rel="noopener">DevQ</a></p>
    </div>
  </div>
</footer>

<style>
  /* CTA Banner */
  .devq-footer-cta-banner {
    background: var(--tertiary);
    padding: 50px 0;
  }

  .devq-cta-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
  }

  .devq-cta-text h3 {
    color: var(--primary);
    margin: 0 0 8px;
    font-size: 1.8rem;
  }

  .devq-cta-text p {
    color: rgba(0, 0, 0, 0.7);
    margin: 0;
    font-size: 1rem;
  }

  .devq-cta-action .btn {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    padding: 14px 36px;
    font-size: 15px;
    white-space: nowrap;
  }

  .devq-cta-action .btn:hover {
    background: var(--secondary);
    border-color: var(--secondary);
    color: #fff;
  }

  /* Footer Main — reuses .devq-footer-columns styles */
  .devq-footer-cta .devq-footer-main {
    background: var(--primary);
    padding: 50px 0 35px;
  }

  .devq-footer-cta .devq-footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 40px;
  }

  .devq-footer-cta .devq-footer-logo img {
    max-width: 160px;
    height: auto;
    filter: brightness(0) invert(1);
    margin-bottom: 15px;
  }

  .devq-footer-cta .devq-footer-desc {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    margin: 0 0 20px;
  }

  .devq-footer-cta .devq-footer-social {
    display: flex;
    gap: 10px;
  }

  .devq-footer-cta .devq-footer-social a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s, color 0.2s;
  }

  .devq-footer-cta .devq-footer-social a:hover {
    background: var(--tertiary);
    color: var(--primary);
  }

  .devq-footer-cta .devq-footer-heading {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .devq-footer-cta .devq-footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .devq-footer-cta .devq-footer-links li {
    margin-bottom: 10px;
  }

  .devq-footer-cta .devq-footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 14px;
    transition: color 0.2s;
  }

  .devq-footer-cta .devq-footer-links a:hover {
    color: var(--tertiary);
  }

  .devq-footer-cta .devq-footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .devq-footer-cta .devq-footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
  }

  .devq-footer-cta .devq-footer-contact i {
    color: var(--tertiary);
    margin-top: 3px;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
  }

  .devq-footer-cta .devq-footer-contact a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color 0.2s;
  }

  .devq-footer-cta .devq-footer-contact a:hover {
    color: var(--tertiary);
  }

  /* Copyright */
  .devq-footer-cta .devq-footer-copyright {
    background: rgba(0, 0, 0, 0.15);
    padding: 15px 0;
  }

  .devq-footer-cta .devq-footer-copyright p {
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
    font-size: 13px;
    text-align: center;
  }

  .devq-footer-cta .devq-footer-copyright a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 600;
  }

  @media (max-width: 1199px) {
    .devq-cta-inner {
      flex-direction: column;
      text-align: center;
    }

    .devq-footer-cta .devq-footer-grid {
      grid-template-columns: 1fr 1fr;
    }

    .devq-footer-cta .devq-footer-brand {
      grid-column: 1 / -1;
      text-align: center;
    }

    .devq-footer-cta .devq-footer-logo img {
      margin: 0 auto 15px;
    }

    .devq-footer-cta .devq-footer-social {
      justify-content: center;
    }
  }

  @media (max-width: 767px) {
    .devq-footer-cta-banner {
      padding: 35px 0;
    }

    .devq-cta-text h3 {
      font-size: 1.5rem;
    }

    .devq-footer-cta .devq-footer-main {
      padding: 35px 0 25px;
    }

    .devq-footer-cta .devq-footer-grid {
      grid-template-columns: 1fr;
      text-align: center;
    }

    .devq-footer-cta .devq-footer-contact li {
      justify-content: center;
    }
  }
</style>
