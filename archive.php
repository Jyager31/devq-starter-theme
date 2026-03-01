<?php

/**
 * The template for displaying archive pages.
 */

get_header(); ?>

<div class="container-fluid">
  <div class="archive-hero">
    <div class="container">
      <h1><?php the_archive_title(); ?></h1>
      <?php the_archive_description('<p class="archive-description">', '</p>'); ?>
    </div>
  </div>
</div>

<div class="container archive-content">
  <?php if (have_posts()) : ?>
    <div class="archive-grid">
      <?php while (have_posts()) : the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
      ?>
        <div class="archive-card">
          <a href="<?php the_permalink(); ?>" class="archive-card-link">
            <?php if ($thumb) : ?>
              <div class="archive-card-image">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
              </div>
            <?php endif; ?>
            <div class="archive-card-body">
              <h2><?php the_title(); ?></h2>
              <div class="archive-card-excerpt"><?php the_excerpt(); ?></div>
              <span class="archive-card-readmore">Read More <i class="far fa-arrow-right"></i></span>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>

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
  .archive-hero {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .archive-hero h1 {
    color: white;
    margin: 0;
  }

  .archive-hero .archive-description {
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--spacing-small);
  }

  .archive-content {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .archive-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-medium);
  }

  .archive-card {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: var(--transition-default);
    background: white;
    overflow: hidden;
  }

  .archive-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
  }

  .archive-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .archive-card-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
  }

  .archive-card-body {
    padding: var(--spacing-medium);
  }

  .archive-card-body h2 {
    margin-top: 0;
  }

  .archive-card-readmore {
    color: var(--primary);
    font-weight: 600;
  }

  .archive-pagination {
    margin-top: var(--spacing-large);
  }

  @media (max-width: 1199px) {
    .archive-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 767px) {
    .archive-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<?php get_footer(); ?>