<?php
/**
 * Single Post Style - Full Image
 * Edge-to-edge featured image with overlapping title card below.
 */

$thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
$categories = get_the_category();
?>

<?php if ($thumb) : ?>
  <div class="single-fullimage-hero">
    <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    <div class="single-fullimage-overlay"></div>
  </div>
<?php endif; ?>

<div class="container single-fullimage-wrap">
  <div class="single-fullimage-titlecard">
    <?php if ($categories) : ?>
      <span class="single-fi-cat"><?php echo esc_html($categories[0]->name); ?></span>
    <?php endif; ?>
    <h1><?php echo esc_html(get_the_title()); ?></h1>
    <div class="single-fi-meta">
      <span><?php echo esc_html(get_the_date()); ?></span>
      <span class="single-fi-sep">&middot;</span>
      <span>by <?php echo esc_html(get_the_author()); ?></span>
    </div>
  </div>

  <div class="single-content single-content-fullimage">
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
</div>

<style>
  .single-fullimage-hero {
    position: relative;
    width: 100%;
    max-height: 500px;
    overflow: hidden;
  }

  .single-fullimage-hero img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    display: block;
  }

  .single-fullimage-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0) 40%, rgba(0,0,0,0.3) 100%);
  }

  /* Title Card */
  .single-fullimage-wrap {
    max-width: 800px;
    position: relative;
  }

  .single-fullimage-titlecard {
    background: #fff;
    padding: 40px;
    margin-top: -80px;
    position: relative;
    z-index: 2;
    border-radius: var(--button-radius, 4px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
  }

  .single-fi-cat {
    display: inline-block;
    background: var(--primary);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 14px;
    border-radius: 2px;
    margin-bottom: 15px;
  }

  .single-fullimage-titlecard h1 {
    margin: 0 0 15px;
    line-height: 1.2;
  }

  .single-fi-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #999;
    font-size: 14px;
  }

  .single-fi-sep {
    color: #ccc;
  }

  /* Content */
  .single-content-fullimage {
    padding: var(--spacing-large) 0 var(--section-padding-bottom);
  }

  .single-content-fullimage .single-post-nav {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: var(--spacing-large);
    padding-top: var(--spacing-medium);
    border-top: 1px solid #eee;
  }

  .single-content-fullimage .single-nav-prev,
  .single-content-fullimage .single-nav-next {
    text-decoration: none;
    color: inherit;
    max-width: 45%;
    transition: color 0.2s;
  }

  .single-content-fullimage .single-nav-next {
    text-align: right;
    margin-left: auto;
  }

  .single-content-fullimage .single-nav-label {
    display: block;
    font-size: 13px;
    color: #999;
    margin-bottom: 4px;
  }

  .single-content-fullimage .single-nav-title {
    display: block;
    font-weight: 600;
    font-size: 15px;
    line-height: 1.4;
  }

  .single-content-fullimage .single-nav-prev:hover,
  .single-content-fullimage .single-nav-next:hover {
    color: var(--primary);
  }

  @media (max-width: 1199px) {
    .single-fullimage-hero img,
    .single-fullimage-hero {
      height: 380px;
      max-height: 380px;
    }

    .single-fullimage-titlecard {
      margin-top: -60px;
      padding: 30px;
    }
  }

  @media (max-width: 767px) {
    .single-fullimage-hero img,
    .single-fullimage-hero {
      height: 260px;
      max-height: 260px;
    }

    .single-fullimage-titlecard {
      margin-top: -40px;
      padding: 25px 20px;
    }

    .single-content-fullimage .single-post-nav {
      flex-direction: column;
    }

    .single-content-fullimage .single-nav-prev,
    .single-content-fullimage .single-nav-next {
      max-width: 100%;
      text-align: left;
    }
  }
</style>
