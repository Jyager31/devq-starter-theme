<?php
/**
 * Block Library Demo Page Generator
 *
 * Creates a "Block Library" page with one of every block filled with demo content.
 * Assign the "Block Library" page template for category filtering.
 *
 * Usage: wp eval-file wp-content/themes/devq-starter/scripts/create-block-library.php
 */

if (!defined('ABSPATH')) {
    echo "This script must be run via WP-CLI: wp eval-file\n";
    exit(1);
}

if (!function_exists('devq_create_page')) {
    echo "Error: devq_create_page() not found. Is the DevQ Starter theme active?\n";
    exit(1);
}

// Check if page already exists
$existing = get_page_by_path('block-library');
if ($existing) {
    wp_delete_post($existing->ID, true);
    echo "Deleted existing Block Library page.\n";
}

// Build blocks array with demo content
$blocks = array();

// ── HEROES ──────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Hero',
    'fields' => array(
        'style' => 'image',
        'eyebrow' => 'Welcome to DevQ',
        'heading' => 'We Build Digital Experiences That Matter',
        'subheading' => 'Premium web development and design for businesses that want to stand out. From concept to launch, we make it happen.',
        'primary_button' => array('title' => 'Get Started', 'url' => '#', 'target' => ''),
        'secondary_button' => array('title' => 'Learn More', 'url' => '#', 'target' => ''),
        'overlay_opacity' => 60,
        'overlay_color' => '#000000',
    ),
);

$blocks[] = array(
    'name' => 'Hero Split',
    'fields' => array(
        'eyebrow' => 'About Our Agency',
        'heading' => 'Crafting Websites That Convert Visitors Into Customers',
        'content' => 'We combine stunning design with proven conversion strategies to build websites that don\'t just look good — they perform. Every pixel has a purpose.',
        'primary_button' => array('title' => 'View Our Work', 'url' => '#', 'target' => ''),
        'secondary_button' => array('title' => 'Contact Us', 'url' => '#', 'target' => ''),
        'image_position' => 'right',
    ),
);

// ── CONTENT ─────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Text Image',
    'fields' => array(
        'eyebrow' => 'Our Approach',
        'heading' => 'Strategy-Driven Design That Delivers Results',
        'content' => '<p>We start every project with a deep understanding of your business goals, target audience, and competitive landscape. This research-first approach ensures every design decision is backed by data and aligned with your objectives.</p><p>Our team brings together expertise in UX design, development, and digital marketing to create cohesive digital experiences that drive measurable growth.</p>',
        'button' => array('title' => 'Our Process', 'url' => '#', 'target' => ''),
        'image_position' => 'right',
    ),
);

$blocks[] = array(
    'name' => 'Wysiwyg',
    'fields' => array(
        'content' => '<h2>Rich Content Block</h2><p>This is the WYSIWYG block with a <strong>default</strong> max-width setting. It\'s perfect for long-form content, blog-style pages, and general text sections. The content is centered and constrained for optimal readability.</p><p>You can include <a href="#">links</a>, <strong>bold text</strong>, <em>italic text</em>, lists, images, and any other HTML content the WordPress editor supports.</p><ul><li>Full WYSIWYG editor support</li><li>Three width options: narrow, default, and wide</li><li>Clean typography with proper spacing</li></ul><blockquote>This is a blockquote. It stands out from the rest of the content with a left border accent.</blockquote>',
        'max_width' => 'default',
    ),
);

$blocks[] = array(
    'name' => 'About',
    'fields' => array(
        'eyebrow' => 'Who We Are',
        'heading' => 'A Team Passionate About Digital Excellence',
        'content' => '<p>Founded in 2015, we\'ve grown from a two-person startup into a full-service digital agency. Our team of designers, developers, and strategists share a common mission: building digital products that make a real difference for our clients.</p><p>We believe great work comes from great collaboration. That\'s why we partner closely with every client, treating their goals as our own.</p>',
        'button' => array('title' => 'Meet the Team', 'url' => '#', 'target' => ''),
        'show_stats' => 1,
        'stats' => array(
            array('number' => '150+', 'label' => 'Projects Delivered'),
            array('number' => '50+', 'label' => 'Happy Clients'),
            array('number' => '10', 'label' => 'Years Experience'),
            array('number' => '12', 'label' => 'Team Members'),
        ),
    ),
);

// ── CARDS & GRIDS ───────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Cards',
    'fields' => array(
        'eyebrow' => 'What We Do',
        'heading' => 'Services Built for Growth',
        'subheading' => 'Comprehensive digital solutions tailored to your business needs. From design to deployment and beyond.',
        'columns' => '3',
        'cards' => array(
            array('icon_type' => 'fontawesome', 'icon_class' => 'fa-solid fa-palette', 'title' => 'Web Design', 'description' => 'Beautiful, responsive designs that capture your brand identity and engage your audience from the first click.', 'link' => array('title' => 'Learn More', 'url' => '#', 'target' => '')),
            array('icon_type' => 'fontawesome', 'icon_class' => 'fa-solid fa-code', 'title' => 'Development', 'description' => 'Custom WordPress development with clean code, fast performance, and scalable architecture built to last.', 'link' => array('title' => 'Learn More', 'url' => '#', 'target' => '')),
            array('icon_type' => 'fontawesome', 'icon_class' => 'fa-solid fa-chart-line', 'title' => 'SEO & Marketing', 'description' => 'Data-driven strategies that increase your visibility, drive qualified traffic, and maximize conversions.', 'link' => array('title' => 'Learn More', 'url' => '#', 'target' => '')),
            array('icon_type' => 'fontawesome', 'icon_class' => 'fa-solid fa-mobile-screen', 'title' => 'Mobile First', 'description' => 'Every site we build is optimized for mobile devices, ensuring a seamless experience across all screen sizes.', 'link' => array('title' => 'Learn More', 'url' => '#', 'target' => '')),
            array('icon_type' => 'fontawesome', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Security', 'description' => 'Enterprise-grade security practices to protect your site and your customers\' data from threats.', 'link' => array('title' => 'Learn More', 'url' => '#', 'target' => '')),
            array('icon_type' => 'fontawesome', 'icon_class' => 'fa-solid fa-headset', 'title' => 'Support', 'description' => 'Ongoing maintenance and support to keep your site running smoothly, securely, and up to date.', 'link' => array('title' => 'Learn More', 'url' => '#', 'target' => '')),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Team',
    'fields' => array(
        'eyebrow' => 'Our Team',
        'heading' => 'Meet the People Behind the Work',
        'subheading' => 'A talented group of designers, developers, and strategists dedicated to delivering exceptional results.',
        'columns' => '4',
        'members' => array(
            array('name' => 'Sarah Chen', 'role' => 'Creative Director', 'bio' => 'Leading design strategy with 12+ years of experience in digital branding.', 'social_links' => array(array('platform' => 'linkedin', 'url' => '#'), array('platform' => 'twitter', 'url' => '#'))),
            array('name' => 'Marcus Johnson', 'role' => 'Lead Developer', 'bio' => 'Full-stack engineer specializing in WordPress and modern JavaScript frameworks.', 'social_links' => array(array('platform' => 'github', 'url' => '#'), array('platform' => 'linkedin', 'url' => '#'))),
            array('name' => 'Emily Rodriguez', 'role' => 'UX Designer', 'bio' => 'Creating intuitive user experiences backed by research and data-driven insights.', 'social_links' => array(array('platform' => 'linkedin', 'url' => '#'), array('platform' => 'instagram', 'url' => '#'))),
            array('name' => 'David Park', 'role' => 'Project Manager', 'bio' => 'Keeping projects on track and clients happy with clear communication and planning.', 'social_links' => array(array('platform' => 'linkedin', 'url' => '#'))),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Pricing',
    'fields' => array(
        'eyebrow' => 'Pricing',
        'heading' => 'Plans That Scale With You',
        'subheading' => 'Transparent pricing with no hidden fees. Choose the plan that fits your needs.',
        'plans' => array(
            array('name' => 'Starter', 'price' => '$999', 'period' => 'one-time', 'description' => 'Perfect for small businesses getting started online.', 'features' => "5-page responsive website\nMobile optimized\nContact form\nBasic SEO setup\n1 round of revisions\n30-day support", 'button' => array('title' => 'Get Started', 'url' => '#', 'target' => ''), 'is_featured' => 0),
            array('name' => 'Professional', 'price' => '$2,499', 'period' => 'one-time', 'description' => 'For growing businesses that need more features and flexibility.', 'features' => "10-page responsive website\nCustom design\nAdvanced SEO\nBlog setup\nSocial media integration\n3 rounds of revisions\n90-day support", 'button' => array('title' => 'Get Started', 'url' => '#', 'target' => ''), 'is_featured' => 1),
            array('name' => 'Enterprise', 'price' => '$4,999', 'period' => 'one-time', 'description' => 'Full-service solution for established businesses.', 'features' => "Unlimited pages\nCustom functionality\nE-commerce ready\nAdvanced integrations\nPriority support\nUnlimited revisions\n1 year support", 'button' => array('title' => 'Contact Us', 'url' => '#', 'target' => ''), 'is_featured' => 0),
        ),
    ),
);

// ── SOCIAL PROOF ────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Testimonials',
    'fields' => array(
        'eyebrow' => 'Testimonials',
        'heading' => 'What Our Clients Say',
        'style' => 'carousel',
        'testimonials' => array(
            array('quote' => 'Working with this team was an absolute game-changer for our business. They delivered a website that not only looks stunning but actually converts visitors into customers. Our online inquiries increased by 300% within the first month.', 'name' => 'Jennifer Walsh', 'role' => 'CEO, Greenlight Solutions', 'rating' => 5),
            array('quote' => 'The attention to detail and strategic thinking they brought to our project was impressive. They didn\'t just build us a website — they built us a digital platform for growth. Highly recommended.', 'name' => 'Michael Torres', 'role' => 'Founder, UrbanCraft Co.', 'rating' => 5),
            array('quote' => 'Professional, responsive, and incredibly talented. They took our vague ideas and turned them into a polished, high-performing website that perfectly represents our brand.', 'name' => 'Amanda Foster', 'role' => 'Marketing Director, Apex Industries', 'rating' => 5),
            array('quote' => 'Best investment we\'ve made in our business this year. The ROI has been incredible — our organic traffic doubled and our bounce rate dropped significantly after the redesign.', 'name' => 'Robert Kim', 'role' => 'Owner, Pacific Ventures', 'rating' => 4),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Logo Bar',
    'fields' => array(
        'heading' => 'Trusted By Leading Brands',
        'grayscale' => 1,
        'logos' => array(
            array('link' => '#'),
            array('link' => '#'),
            array('link' => '#'),
            array('link' => '#'),
            array('link' => '#'),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Stats',
    'fields' => array(
        'eyebrow' => 'By the Numbers',
        'heading' => 'Results That Speak for Themselves',
        'background' => 'dark',
        'stats' => array(
            array('number' => '500', 'label' => 'Projects Completed', 'prefix' => '', 'suffix' => '+'),
            array('number' => '98', 'label' => 'Client Satisfaction', 'prefix' => '', 'suffix' => '%'),
            array('number' => '15', 'label' => 'Years Experience', 'prefix' => '', 'suffix' => '+'),
            array('number' => '50', 'label' => 'Team Members', 'prefix' => '', 'suffix' => ''),
        ),
    ),
);

// ── MEDIA ───────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Gallery',
    'fields' => array(
        'heading' => 'Our Work',
        'show_filters' => 1,
        'images' => array(
            array('category' => 'Branding', 'caption' => 'Brand identity for tech startup'),
            array('category' => 'Web Design', 'caption' => 'E-commerce platform redesign'),
            array('category' => 'Branding', 'caption' => 'Logo and visual identity system'),
            array('category' => 'Web Design', 'caption' => 'SaaS dashboard interface'),
            array('category' => 'Marketing', 'caption' => 'Social media campaign visuals'),
            array('category' => 'Web Design', 'caption' => 'Portfolio website for architect'),
            array('category' => 'Marketing', 'caption' => 'Email campaign design'),
            array('category' => 'Branding', 'caption' => 'Packaging design for food brand'),
            array('category' => 'Web Design', 'caption' => 'Non-profit organization website'),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Video',
    'fields' => array(
        'eyebrow' => 'Watch',
        'heading' => 'See Our Process in Action',
        'content' => 'Take a behind-the-scenes look at how we approach every project, from initial discovery to final launch.',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'aspect_ratio' => '16:9',
    ),
);

// ── CONVERSION ──────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'CTA',
    'fields' => array(
        'eyebrow' => 'Ready to Start?',
        'heading' => 'Let\'s Build Something Great Together',
        'content' => 'Get in touch today for a free consultation. We\'ll discuss your goals and create a custom plan to bring your vision to life.',
        'button' => array('title' => 'Schedule a Call', 'url' => '#', 'target' => ''),
        'background' => 'primary',
    ),
);

$blocks[] = array(
    'name' => 'Contact Split',
    'fields' => array(
        'eyebrow' => 'Get In Touch',
        'heading' => 'Contact Us',
        'show_phone' => 1,
        'show_email' => 1,
        'show_address' => 1,
        'show_hours' => 1,
        'hours' => "Monday - Friday: 9am - 6pm\nSaturday: 10am - 2pm\nSunday: Closed",
        'show_map' => 0,
        'map_embed' => '',
        'form_shortcode' => '',
    ),
);

// ── LISTS ───────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'FAQ',
    'fields' => array(
        'eyebrow' => 'FAQ',
        'heading' => 'Frequently Asked Questions',
        'subheading' => 'Find answers to common questions about our services, process, and pricing.',
        'items' => array(
            array('question' => 'How long does a typical project take?', 'answer' => '<p>Most projects take between 4-8 weeks from kickoff to launch, depending on complexity. We\'ll provide a detailed timeline during our initial consultation so you know exactly what to expect.</p>'),
            array('question' => 'What is your design process?', 'answer' => '<p>Our process follows four key phases: Discovery (understanding your goals), Design (creating mockups and prototypes), Development (building the site), and Launch (testing and going live). We keep you involved at every step.</p>'),
            array('question' => 'Do you offer ongoing support?', 'answer' => '<p>Yes! We offer flexible maintenance and support plans starting at $99/month. This includes security updates, backups, performance monitoring, and a set number of content changes each month.</p>'),
            array('question' => 'Can you work with our existing brand guidelines?', 'answer' => '<p>Absolutely. We regularly work within established brand guidelines and can extend your visual identity into the digital space while maintaining complete brand consistency.</p>'),
            array('question' => 'What platforms do you build on?', 'answer' => '<p>We primarily build on WordPress with custom themes, but we also work with Shopify for e-commerce and can recommend the best platform based on your specific needs and goals.</p>'),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Process',
    'fields' => array(
        'eyebrow' => 'How It Works',
        'heading' => 'Our Proven 4-Step Process',
        'subheading' => 'A clear, structured approach that ensures every project is delivered on time and exceeds expectations.',
        'steps' => array(
            array('icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Discovery', 'description' => 'We start by understanding your business, goals, audience, and competitive landscape through in-depth research.'),
            array('icon_class' => 'fa-solid fa-pen-ruler', 'title' => 'Design', 'description' => 'Our designers create stunning mockups and prototypes, iterating based on your feedback until it\'s perfect.'),
            array('icon_class' => 'fa-solid fa-code', 'title' => 'Development', 'description' => 'Our engineers build your site with clean, performant code that\'s optimized for speed and search engines.'),
            array('icon_class' => 'fa-solid fa-rocket', 'title' => 'Launch', 'description' => 'After thorough testing across all devices and browsers, we launch your site and provide training for your team.'),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Features List',
    'fields' => array(
        'eyebrow' => 'Why Choose Us',
        'heading' => 'Everything You Need to Succeed Online',
        'subheading' => 'We don\'t just build websites — we build complete digital solutions that drive results.',
        'columns' => '2',
        'features' => array(
            array('icon_class' => 'fa-solid fa-gauge-high', 'title' => 'Lightning Fast Performance', 'description' => 'Optimized code and smart caching ensure your site loads in under 2 seconds, keeping visitors engaged.'),
            array('icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'SEO Optimized', 'description' => 'Built-in SEO best practices from the ground up, including schema markup, meta tags, and semantic HTML.'),
            array('icon_class' => 'fa-solid fa-mobile-screen', 'title' => 'Fully Responsive', 'description' => 'Beautiful on every device — from phones to ultrawide monitors, your site adapts perfectly.'),
            array('icon_class' => 'fa-solid fa-lock', 'title' => 'Security First', 'description' => 'Enterprise-grade security measures protect your site and your visitors\' data around the clock.'),
            array('icon_class' => 'fa-solid fa-universal-access', 'title' => 'Accessible Design', 'description' => 'WCAG 2.1 compliant designs that ensure your site is usable by everyone, regardless of ability.'),
            array('icon_class' => 'fa-solid fa-chart-simple', 'title' => 'Analytics Integration', 'description' => 'Comprehensive tracking and reporting so you can measure results and make data-driven decisions.'),
        ),
    ),
);

// ── CREATE THE PAGE ─────────────────────────────────────────────────────

$post_id = devq_create_page(array(
    'title' => 'Block Library',
    'slug' => 'block-library',
    'status' => 'publish',
    'template' => 'page-block-library.php',
    'blocks' => $blocks,
));

if (is_wp_error($post_id)) {
    echo "Error creating Block Library page: " . $post_id->get_error_message() . "\n";
    exit(1);
}

echo "Block Library page created successfully!\n";
echo "Post ID: {$post_id}\n";
echo "View: " . get_permalink($post_id) . "\n";
echo "Edit: " . admin_url("post.php?post={$post_id}&action=edit") . "\n";

// Verify WYSIWYG data made it into post_content
$page = get_post($post_id);
$has_wysiwyg = strpos($page->post_content, 'Rich Content Block') !== false;
echo $has_wysiwyg ? "\n[OK] WYSIWYG content found in post_content\n" : "\n[WARN] WYSIWYG content NOT found in post_content\n";

echo "\nNote: Image fields are empty — add placeholder images via the editor.\n";
echo "Note: Logo Bar logos need to be added via the editor.\n";
