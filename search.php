<?php

/**
 * The template for displaying search results pages.
 */

get_header(); ?>

<div class="container search-results-content">
  <?php if (have_posts()) : ?>

    <h1 class="search-title"><?php printf(esc_html__('Search Results for: %s', 'devq'), '<span>' . get_search_query() . '</span>'); ?></h1>

    <div class="search-grid">
      <?php while (have_posts()) : the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
      ?>
        <div class="search-card">
          <a href="<?php the_permalink(); ?>" class="search-card-link">
            <?php if ($thumb) : ?>
              <div class="search-card-image" style="background-image:url('<?php echo esc_url($thumb); ?>');"></div>
            <?php endif; ?>
            <div class="search-card-body">
              <p><strong><?php the_title(); ?></strong></p>
              <?php the_excerpt(); ?>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>

    <?php the_posts_navigation(); ?>

  <?php else : ?>

    <h1 class="search-title"><?php esc_html_e('Nothing Found', 'devq'); ?></h1>
    <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'devq'); ?></p>
    <?php get_search_form(); ?>

  <?php endif; ?>
</div>

<style>
  .search-results-content {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .search-title {
    margin-bottom: var(--spacing-medium);
  }

  .search-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-medium);
  }

  .search-card {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: var(--transition-default);
    overflow: hidden;
  }

  .search-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
  }

  .search-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .search-card-image {
    height: 200px;
    background-size: cover;
    background-position: center;
  }

  .search-card-body {
    padding: var(--spacing-medium);
  }

  @media (max-width: 767px) {
    .search-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<?php get_footer(); ?>