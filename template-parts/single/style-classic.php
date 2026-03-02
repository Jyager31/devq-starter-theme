<?php
/**
 * Single Post Style - Classic Hero
 * Color banner hero with title, date below. Clean and reliable.
 */
?>

<div class="container-fluid">
  <div class="single-hero single-hero-classic">
    <div class="container">
      <?php $categories = get_the_category(); ?>
      <?php if ($categories) : ?>
        <span class="single-cat"><?php echo esc_html($categories[0]->name); ?></span>
      <?php endif; ?>
      <h1><?php echo esc_html(get_the_title()); ?></h1>
      <div class="single-meta">
        <span class="single-date"><?php echo esc_html(get_the_date()); ?></span>
        <span class="single-author">by <?php echo esc_html(get_the_author()); ?></span>
      </div>
    </div>
  </div>
</div>

<div class="container single-content single-content-classic">
  <?php the_content(); ?>

  <div class="single-post-nav">
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
  </div>
</div>

<style>
  .single-hero-classic {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .single-hero-classic .single-cat {
    display: inline-block;
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 12px;
    border-radius: 2px;
    margin-bottom: 15px;
  }

  .single-hero-classic h1 {
    color: white;
    margin: 0 0 15px;
    max-width: 800px;
  }

  .single-hero-classic .single-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    color: rgba(255, 255, 255, 0.75);
    font-size: 14px;
  }

  .single-content-classic {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
    max-width: 800px;
  }

  /* Post Navigation */
  .single-post-nav {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: var(--spacing-large);
    padding-top: var(--spacing-medium);
    border-top: 1px solid #eee;
  }

  .single-nav-prev,
  .single-nav-next {
    text-decoration: none;
    color: inherit;
    max-width: 45%;
    transition: color 0.2s;
  }

  .single-nav-next {
    text-align: right;
    margin-left: auto;
  }

  .single-nav-label {
    display: block;
    font-size: 13px;
    color: #999;
    margin-bottom: 4px;
  }

  .single-nav-title {
    display: block;
    font-weight: 600;
    font-size: 15px;
    line-height: 1.4;
  }

  .single-nav-prev:hover,
  .single-nav-next:hover {
    color: var(--primary);
  }

  @media (max-width: 1199px) {
    .single-hero-classic {
      text-align: center;
    }

    .single-hero-classic .single-meta {
      justify-content: center;
    }
  }

  @media (max-width: 767px) {
    .single-post-nav {
      flex-direction: column;
    }

    .single-nav-prev,
    .single-nav-next {
      max-width: 100%;
      text-align: left;
    }
  }
</style>
