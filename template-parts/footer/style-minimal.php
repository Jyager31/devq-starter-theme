<?php
/**
 * Footer Style - Minimal Bar
 * Simple copyright bar. Clean and unobtrusive.
 */

$company_name = get_field('branding_company_name', 'option');
?>

<footer class="devq-footer devq-footer-minimal">
  <div class="container">
    <p>Copyright &copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html($company_name); ?> - Website Powered by <a href="https://thedevq.com/" target="_blank" rel="noopener">DevQ</a></p>
  </div>
</footer>

<style>
  .devq-footer-minimal {
    background: var(--secondary);
    padding: 18px 0;
  }

  .devq-footer-minimal p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 14px;
    text-align: center;
  }

  .devq-footer-minimal a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: opacity 0.2s;
  }

  .devq-footer-minimal a:hover {
    opacity: 0.75;
  }
</style>
