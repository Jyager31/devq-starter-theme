<?php

/**
 * The template for displaying all single posts.
 */

get_header(); ?>

<div class="container-fluid">
  <div class="single-hero">
    <div class="container">
      <h1><?php echo esc_html(get_the_title()); ?></h1>
      <p class="single-meta"><?php echo esc_html(get_the_date()); ?></p>
    </div>
  </div>
</div>

<div class="container single-content">
  <?php the_content(); ?>
</div>

<style>
  .single-hero {
    background-color: var(--primary);
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  .single-hero h1 {
    color: white;
    margin: 0;
  }

  .single-hero .single-meta {
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--spacing-small);
  }

  .single-content {
    padding: var(--section-padding-top) 0 var(--section-padding-bottom);
  }

  @media (max-width: 1199px) {
    .single-hero {
      text-align: center;
    }
  }
</style>

<?php get_footer(); ?>