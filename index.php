<?php

/**
 * The main template file.
 */

get_header(); ?>

<div class="container-fluid">
  <div class="index-hero">
    <div class="container">
      <h1><?php esc_html_e('Blog', 'devq'); ?></h1>
    </div>
  </div>
</div>

<div class="container index-content">
  <?php if (have_posts()) : ?>
    <div class="index-grid">
      <?php while (have_posts()) : the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
      ?>
        <div class="index-card">
          <a href="<?php the_permalink(); ?>" class="index-card-link">
            <?php if ($thumb) : ?>
              <div class="index-card-image">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
              </div>
            <?php endif; ?>
            <div class="index-card-body">
              <h2><?php the_title(); ?></h2>
              <div class="index-card-excerpt"><?php the_excerpt(); ?></div>
              <span class="index-card-readmore">Read More <i class="far fa-arrow-right"></i></span>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="index-pagination">
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
  .index-hero {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .index-hero h1 {
    color: white;
    margin: 0;
  }

  .index-content {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .index-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-medium);
  }

  .index-card {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: var(--transition-default);
    background: white;
    overflow: hidden;
  }

  .index-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
  }

  .index-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .index-card-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
  }

  .index-card-body {
    padding: var(--spacing-medium);
  }

  .index-card-body h2 {
    margin-top: 0;
  }

  .index-card-readmore {
    color: var(--primary);
    font-weight: 600;
  }

  .index-pagination {
    margin-top: var(--spacing-large);
  }

  @media (max-width: 1199px) {
    .index-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 767px) {
    .index-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<?php get_footer(); ?>