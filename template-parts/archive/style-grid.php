<?php
/**
 * Archive Style - Card Grid
 * 3-column card grid with hover lift and clean typography.
 */
?>

<div class="container-fluid">
  <div class="archive-hero archive-hero-grid">
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

<div class="container archive-content-grid">
  <?php if (have_posts()) : ?>
    <div class="archive-grid">
      <?php while (have_posts()) : the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
      ?>
        <article class="archive-card">
          <a href="<?php the_permalink(); ?>" class="archive-card-link">
            <?php if ($thumb) : ?>
              <div class="archive-card-image">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
              </div>
            <?php endif; ?>
            <div class="archive-card-body">
              <span class="archive-card-date"><?php echo esc_html(get_the_date()); ?></span>
              <h2><?php the_title(); ?></h2>
              <div class="archive-card-excerpt"><?php the_excerpt(); ?></div>
              <span class="archive-card-readmore">Read More <i class="far fa-arrow-right"></i></span>
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
  .archive-hero-grid {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .archive-hero-grid h1 {
    color: white;
    margin: 0;
  }

  .archive-hero-grid .archive-description {
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--spacing-small);
  }

  .archive-content-grid {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .archive-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-medium);
  }

  .archive-card {
    background: #fff;
    border-radius: var(--button-radius, 4px);
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .archive-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .archive-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .archive-card-image {
    overflow: hidden;
  }

  .archive-card-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }

  .archive-card:hover .archive-card-image img {
    transform: scale(1.04);
  }

  .archive-card-body {
    padding: var(--spacing-medium);
  }

  .archive-card-date {
    display: block;
    font-size: 13px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
  }

  .archive-card-body h2 {
    margin: 0 0 10px;
    line-height: 1.3;
  }

  .archive-card-excerpt {
    color: #666;
    margin-bottom: 15px;
  }

  .archive-card-excerpt p {
    margin: 0;
  }

  .archive-card-readmore {
    color: var(--primary);
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s;
  }

  .archive-card:hover .archive-card-readmore {
    gap: 10px;
  }

  .archive-pagination {
    margin-top: var(--spacing-large);
    text-align: center;
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
