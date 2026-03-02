<?php
/**
 * Archive Style - Magazine Feature
 * First post spans full width as hero card, remaining in 2-col grid.
 */
?>

<div class="container-fluid">
  <div class="archive-hero archive-hero-magazine">
    <div class="container">
      <h1><?php
        if (is_home()) {
          esc_html_e('Blog', 'devq');
        } else {
          the_archive_title();
        }
      ?></h1>
      <?php if (!is_home()) the_archive_description('<p class="archive-description">', '</p>'); ?>
    </div>
  </div>
</div>

<div class="container archive-content-magazine">
  <?php if (have_posts()) :
    $post_index = 0;
  ?>

    <?php while (have_posts()) : the_post();
      $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
      $categories = get_the_category();
      $post_index++;

      if ($post_index === 1) : // Featured first post ?>
        <article class="magazine-featured">
          <a href="<?php the_permalink(); ?>" class="magazine-featured-link">
            <?php if ($thumb) : ?>
              <div class="magazine-featured-image">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                <div class="magazine-featured-overlay"></div>
              </div>
            <?php endif; ?>
            <div class="magazine-featured-content">
              <div class="magazine-featured-meta">
                <?php if ($categories) : ?>
                  <span class="magazine-cat"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                <span class="magazine-date"><?php echo esc_html(get_the_date()); ?></span>
              </div>
              <h2><?php the_title(); ?></h2>
              <div class="magazine-featured-excerpt"><?php the_excerpt(); ?></div>
            </div>
          </a>
        </article>

        <div class="magazine-grid">
      <?php else : // Remaining posts ?>
        <article class="magazine-card">
          <a href="<?php the_permalink(); ?>" class="magazine-card-link">
            <?php if ($thumb) : ?>
              <div class="magazine-card-image">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
              </div>
            <?php endif; ?>
            <div class="magazine-card-body">
              <div class="magazine-card-meta">
                <?php if ($categories) : ?>
                  <span class="magazine-cat"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                <span class="magazine-date"><?php echo esc_html(get_the_date()); ?></span>
              </div>
              <h3><?php the_title(); ?></h3>
              <div class="magazine-card-excerpt"><?php the_excerpt(); ?></div>
            </div>
          </a>
        </article>
      <?php endif; ?>
    <?php endwhile; ?>

    <?php if ($post_index > 1) : ?>
      </div><!-- .magazine-grid -->
    <?php endif; ?>

    <div class="archive-pagination">
      <?php the_posts_pagination(array(
        'mid_size' => 2,
        'prev_text' => '&laquo; Previous',
        'next_text' => 'Next &raquo;',
      )); ?>
    </div>

  <?php else : ?>
    <p><?php esc_html_e('No posts found.', 'devq'); ?></p>
  <?php endif; ?>
</div>

<style>
  .archive-hero-magazine {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .archive-hero-magazine h1 {
    color: white;
    margin: 0;
  }

  .archive-hero-magazine .archive-description {
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--spacing-small);
  }

  .archive-content-magazine {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  /* Featured Post */
  .magazine-featured {
    margin-bottom: var(--spacing-large);
  }

  .magazine-featured-link {
    display: block;
    position: relative;
    text-decoration: none;
    color: inherit;
    border-radius: var(--button-radius, 4px);
    overflow: hidden;
  }

  .magazine-featured-image {
    position: relative;
  }

  .magazine-featured-image img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
  }

  .magazine-featured:hover .magazine-featured-image img {
    transform: scale(1.03);
  }

  .magazine-featured-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 60%);
  }

  .magazine-featured-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    z-index: 2;
  }

  .magazine-featured-content h2 {
    color: #fff;
    margin: 0 0 10px;
    font-size: 2rem;
    max-width: 700px;
  }

  .magazine-featured-excerpt {
    color: rgba(255, 255, 255, 0.8);
    max-width: 600px;
    font-size: 15px;
  }

  .magazine-featured-excerpt p {
    margin: 0;
  }

  /* Shared Meta */
  .magazine-featured-meta,
  .magazine-card-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
  }

  .magazine-cat {
    background: var(--tertiary);
    color: var(--primary);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 3px 10px;
    border-radius: 2px;
  }

  .magazine-featured-meta .magazine-date {
    color: rgba(255, 255, 255, 0.7);
    font-size: 13px;
  }

  .magazine-card-meta .magazine-date {
    color: #999;
    font-size: 13px;
  }

  /* Grid Cards */
  .magazine-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-medium);
  }

  .magazine-card {
    background: #fff;
    border-radius: var(--button-radius, 4px);
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .magazine-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .magazine-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .magazine-card-image {
    overflow: hidden;
  }

  .magazine-card-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }

  .magazine-card:hover .magazine-card-image img {
    transform: scale(1.04);
  }

  .magazine-card-body {
    padding: var(--spacing-medium);
  }

  .magazine-card-body h3 {
    margin: 0 0 8px;
    line-height: 1.3;
    transition: color 0.2s;
  }

  .magazine-card:hover .magazine-card-body h3 {
    color: var(--primary);
  }

  .magazine-card-excerpt {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
  }

  .magazine-card-excerpt p {
    margin: 0;
  }

  .archive-pagination {
    margin-top: var(--spacing-large);
    text-align: center;
  }

  @media (max-width: 1199px) {
    .magazine-featured-image img {
      height: 350px;
    }

    .magazine-featured-content {
      padding: 30px;
    }

    .magazine-featured-content h2 {
      font-size: 1.6rem;
    }
  }

  @media (max-width: 767px) {
    .magazine-featured-image img {
      height: 260px;
    }

    .magazine-featured-content {
      padding: 20px;
    }

    .magazine-featured-content h2 {
      font-size: 1.3rem;
    }

    .magazine-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
