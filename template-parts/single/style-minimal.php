<?php
/**
 * Single Post Style - Minimal
 * No hero. Typography-focused. Clean, readable layout.
 */

$thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
$categories = get_the_category();
?>

<div class="container single-minimal-wrap">
  <article class="single-minimal">
    <header class="single-minimal-header">
      <?php if ($categories) : ?>
        <span class="single-min-cat"><?php echo esc_html($categories[0]->name); ?></span>
      <?php endif; ?>
      <h1><?php echo esc_html(get_the_title()); ?></h1>
      <div class="single-min-meta">
        <span><?php echo esc_html(get_the_date('F j, Y')); ?></span>
        <span class="single-min-sep">&middot;</span>
        <span><?php echo esc_html(get_the_author()); ?></span>
      </div>
    </header>

    <?php if ($thumb) : ?>
      <div class="single-minimal-image">
        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
      </div>
    <?php endif; ?>

    <div class="single-content single-content-minimal">
      <?php the_content(); ?>
    </div>

    <nav class="single-post-nav">
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      ?>
      <?php if ($prev) : ?>
        <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="single-nav-prev">
          <span class="single-nav-label"><i class="far fa-arrow-left"></i> Previous</span>
          <span class="single-nav-title"><?php echo esc_html($prev->post_title); ?></span>
        </a>
      <?php endif; ?>
      <?php if ($next) : ?>
        <a href="<?php echo esc_url(get_permalink($next)); ?>" class="single-nav-next">
          <span class="single-nav-label">Next <i class="far fa-arrow-right"></i></span>
          <span class="single-nav-title"><?php echo esc_html($next->post_title); ?></span>
        </a>
      <?php endif; ?>
    </nav>
  </article>
</div>

<style>
  .single-minimal-wrap {
    max-width: 760px;
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .single-minimal-header {
    text-align: center;
    margin-bottom: var(--spacing-large);
  }

  .single-min-cat {
    display: inline-block;
    color: var(--primary);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 15px;
  }

  .single-minimal-header h1 {
    margin: 0 0 15px;
    line-height: 1.15;
  }

  .single-min-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #999;
    font-size: 14px;
  }

  .single-min-sep {
    color: #ccc;
  }

  .single-minimal-image {
    margin-bottom: var(--spacing-large);
    border-radius: var(--button-radius, 4px);
    overflow: hidden;
  }

  .single-minimal-image img {
    width: 100%;
    height: auto;
    display: block;
  }

  .single-content-minimal {
    line-height: 1.8;
  }

  /* Post Navigation */
  .single-minimal .single-post-nav {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: var(--spacing-large);
    padding-top: var(--spacing-medium);
    border-top: 1px solid #eee;
  }

  .single-minimal .single-nav-prev,
  .single-minimal .single-nav-next {
    text-decoration: none;
    color: inherit;
    max-width: 45%;
    transition: color 0.2s;
  }

  .single-minimal .single-nav-next {
    text-align: right;
    margin-left: auto;
  }

  .single-minimal .single-nav-label {
    display: block;
    font-size: 13px;
    color: #999;
    margin-bottom: 4px;
  }

  .single-minimal .single-nav-title {
    display: block;
    font-weight: 600;
    font-size: 15px;
    line-height: 1.4;
  }

  .single-minimal .single-nav-prev:hover,
  .single-minimal .single-nav-next:hover {
    color: var(--primary);
  }

  @media (max-width: 767px) {
    .single-minimal .single-post-nav {
      flex-direction: column;
    }

    .single-minimal .single-nav-prev,
    .single-minimal .single-nav-next {
      max-width: 100%;
      text-align: left;
    }
  }
</style>
