<?php
/**
 * Template Name: Block Library
 *
 * Showcase page for all DevQ blocks with category filtering.
 * Displays a sticky filter bar above the_content() so blocks
 * can be filtered by category.
 */

// Noindex this page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

get_header(); ?>

<style>
    .block-library-header {
        background: #1a1a2e;
        padding: 80px 0 60px;
        text-align: center;
    }

    .block-library-header .block-library-title {
        color: #fff;
        margin-bottom: 15px;
        font-size: 3rem;
        font-weight: 800;
    }

    .block-library-header .block-library-description {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto;
    }

    .block-library-filters {
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .block-library-filter-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .block-library-filter {
        padding: 8px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 30px;
        background: transparent;
        color: #666;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        font-family: var(--font2);
        transition: var(--transition-default);
    }

    .block-library-filter:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .block-library-filter.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .block-library-content .block-library-divider {
        padding: 50px 0 20px;
        text-align: center;
    }

    .block-library-content .block-library-divider h2 {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #999;
        font-weight: 700;
        margin: 0;
        font-family: var(--font2);
    }

    .block-library-content .block-library-divider hr {
        border: none;
        border-top: 1px solid #e0e0e0;
        margin-top: 15px;
        max-width: 200px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Block name labels - only on library page */
    .block-library-content [data-block-category] {
        position: relative;
    }

    .block-library-content [data-block-category]::before {
        content: attr(data-block-name);
        display: block;
        background: #1a1a2e;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 6px 16px;
        font-family: var(--font2);
        position: absolute;
        top: 0;
        left: 0;
        z-index: 10;
        border-radius: 0 0 6px 0;
    }

    .block-library-content [data-block-category]:not([data-block-name])::before {
        display: none;
    }

    @media (max-width: 767px) {
        .block-library-header {
            padding: 50px 0 40px;
        }

        .block-library-header .block-library-title {
            font-size: 2.25rem;
        }

        .block-library-filter-bar {
            gap: 6px;
        }

        .block-library-filter {
            padding: 6px 14px;
            font-size: 13px;
        }
    }
</style>

<div class="block-library-header">
    <div class="container">
        <h1 class="block-library-title">Block Library</h1>
        <p class="block-library-description">Browse all available blocks by category. Click a filter to show only that type.<br><small style="opacity:0.5;">This page is noindexed and will not appear in search results.</small></p>
    </div>
</div>

<div class="block-library-filters" id="block-library-filters">
    <div class="container">
        <div class="block-library-filter-bar">
            <button class="block-library-filter active" data-category="all">All</button>
            <button class="block-library-filter" data-category="heroes">Heroes</button>
            <button class="block-library-filter" data-category="content">Content</button>
            <button class="block-library-filter" data-category="cards">Cards &amp; Grids</button>
            <button class="block-library-filter" data-category="socialproof">Social Proof</button>
            <button class="block-library-filter" data-category="media">Media</button>
            <button class="block-library-filter" data-category="conversion">Conversion</button>
            <button class="block-library-filter" data-category="lists">Lists</button>
        </div>
    </div>
</div>

<div class="block-library-content">
    <?php the_content(); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var filters = document.querySelectorAll('.block-library-filter');
    var content = document.querySelector('.block-library-content');

    // Add block name labels
    var blockMap = {
        'hero-block': 'Hero',
        'herosplit-block': 'Hero Split',
        'textimage-block': 'Text Image',
        'wysiwyg-block': 'WYSIWYG',
        'about-block': 'About',
        'cards-block': 'Cards',
        'team-block': 'Team',
        'pricing-block': 'Pricing',
        'testimonials-block': 'Testimonials',
        'logobar-block': 'Logo Bar',
        'stats-block': 'Stats',
        'gallery-block': 'Gallery',
        'video-block': 'Video',
        'cta-block': 'CTA',
        'contactsplit-block': 'Contact Split',
        'faq-block': 'FAQ',
        'process-block': 'Process',
        'featureslist-block': 'Features List',
        'image-block': 'Image'
    };

    var allBlocks = content.querySelectorAll('[data-block-category]');
    allBlocks.forEach(function(block) {
        var classes = block.className.split(' ');
        for (var i = 0; i < classes.length; i++) {
            if (blockMap[classes[i]]) {
                block.setAttribute('data-block-name', blockMap[classes[i]]);
                break;
            }
        }
    });

    filters.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var category = this.getAttribute('data-category');

            // Update active state
            filters.forEach(function(f) { f.classList.remove('active'); });
            this.classList.add('active');

            // Find blocks fresh each time (in case DOM changed)
            var blocks = content.querySelectorAll('[data-block-category]');

            blocks.forEach(function(block) {
                if (category === 'all' || block.getAttribute('data-block-category') === category) {
                    block.style.display = '';
                } else {
                    block.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>
