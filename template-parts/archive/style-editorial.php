<?php
/**
 * Archive Style - Editorial List
 * Horizontal layout with large thumbnail left, content right. Magazine index feel.
 */
?>

<div class="container-fluid">
  <div class="archive-hero archive-hero-editorial">
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

<div class="container archive-content-editorial">
  <?php if (have_posts()) : ?>
    <div class="archive-list">
      <?php while (have_posts()) : the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        $categories = get_the_category();
      ?>
        <article class="archive-list-item">
          <a href="<?php the_permalink(); ?>" class="archive-list-link">
            <?php if ($thumb) : ?>
              <div class="archive-list-image">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
              </div>
            <?php endif; ?>
            <div class="archive-list-body">
              <div class="archive-list-meta">
                <?php if ($categories) : ?>
                  <span class="archive-list-cat"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                <span class="archive-list-date"><?php echo esc_html(get_the_date()); ?></span>
              </div>
              <h2><?php the_title(); ?></h2>
              <div class="archive-list-excerpt"><?php the_excerpt(); ?></div>
              <span class="archive-list-readmore">Continue Reading <i class="far fa-long-arrow-right"></i></span>
            </div>
          </a>
        </article>
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
  .archive-hero-editorial {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .archive-hero-editorial h1 {
    color: white;
    margin: 0;
  }

  .archive-hero-editorial .archive-description {
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--spacing-small);
  }

  .archive-content-editorial {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
    max-width: 900px;
    margin: 0 auto;
  }

  .archive-list-item {
    border-bottom: 1px solid #eee;
  }

  .archive-list-item:last-child {
    border-bottom: none;
  }

  .archive-list-link {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: var(--spacing-medium);
    text-decoration: none;
    color: inherit;
    padding: var(--spacing-medium) 0;
    align-items: center;
  }

  .archive-list-image {
    overflow: hidden;
    border-radius: var(--button-radius, 4px);
  }

  .archive-list-image img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }

  .archive-list-item:hover .archive-list-image img {
    transform: scale(1.05);
  }

  .archive-list-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
  }

  .archive-list-cat {
    background: var(--primary);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 3px 10px;
    border-radius: 2px;
  }

  .archive-list-date {
    font-size: 13px;
    color: #999;
  }

  .archive-list-body h2 {
    margin: 0 0 8px;
    line-height: 1.3;
    transition: color 0.2s;
  }

  .archive-list-item:hover .archive-list-body h2 {
    color: var(--primary);
  }

  .archive-list-excerpt {
    color: #666;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 10px;
  }

  .archive-list-excerpt p {
    margin: 0;
  }

  .archive-list-readmore {
    color: var(--primary);
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: gap 0.2s;
  }

  .archive-list-item:hover .archive-list-readmore {
    gap: 14px;
  }

  .archive-pagination {
    margin-top: var(--spacing-large);
    text-align: center;
  }

  @media (max-width: 1199px) {
    .archive-list-link {
      grid-template-columns: 220px 1fr;
    }

    .archive-list-image img {
      height: 160px;
    }
  }

  @media (max-width: 767px) {
    .archive-list-link {
      grid-template-columns: 1fr;
      gap: var(--spacing-small);
    }

    .archive-list-image img {
      height: 200px;
    }
  }
</style>
