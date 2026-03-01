<?php

/**
 * The template for displaying 404 pages (not found).
 */

get_header();

// Get 404 page settings
$title = get_field('404_title', 'option') ?: 'Page Not Found';
$message = get_field('404_message', 'option') ?: 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.';
$show_search = get_field('404_show_search', 'option');
$link_1 = get_field('404_link_1', 'option');
$link_2 = get_field('404_link_2', 'option');
$link_3 = get_field('404_link_3', 'option');
?>

<div class="container">
	<div class="error-page-container" style="padding: var(--section-padding-top) 0 var(--section-padding-bottom); text-align: center; max-width: 800px; margin: 0 auto;">
		<h1 style="font-size: 4rem; margin-bottom: var(--spacing-medium);"><?php echo esc_html($title); ?></h1>

		<div class="error-page-content" style="margin-bottom: var(--spacing-large);">
			<p style="font-size: 1.2rem; margin-bottom: var(--spacing-medium);"><?php echo esc_html($message); ?></p>

			<?php if ($show_search) : ?>
				<div class="error-page-search" style="margin: var(--spacing-medium) 0;">
					<h3 style="margin-bottom: var(--spacing-small);">Search our site</h3>
					<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; max-width: 500px; margin: 0 auto;">
						<input type="search" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: var(--button-radius) 0 0 var(--button-radius);">
						<button type="submit" class="search-submit" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 0 var(--button-radius) var(--button-radius) 0; cursor: pointer;">Search</button>
					</form>
				</div>
			<?php endif; ?>

			<div class="error-page-links" style="margin-top: var(--spacing-large);">
				<h3 style="margin-bottom: var(--spacing-small);">Quick Links</h3>
				<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: var(--spacing-small);">
					<?php if ($link_1) : ?>
						<a href="<?php echo esc_url($link_1['url']); ?>" class="btn"><?php echo esc_html($link_1['title']); ?></a>
					<?php endif; ?>

					<?php if ($link_2) : ?>
						<a href="<?php echo esc_url($link_2['url']); ?>" class="btn"><?php echo esc_html($link_2['title']); ?></a>
					<?php endif; ?>

					<?php if ($link_3) : ?>
						<a href="<?php echo esc_url($link_3['url']); ?>" class="btn"><?php echo esc_html($link_3['title']); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>