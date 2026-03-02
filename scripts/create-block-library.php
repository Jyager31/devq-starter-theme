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

$blocks[] = array(
    'name' => 'Hero Video',
    'fields' => array(
        'eyebrow' => 'See It In Motion',
        'heading' => 'Bringing Your Brand to Life With Video',
        'subheading' => 'Immersive video backgrounds that capture attention and tell your story from the moment visitors arrive.',
        'primary_button' => array('title' => 'Watch Showreel', 'url' => '#', 'target' => ''),
        'secondary_button' => array('title' => 'Start a Project', 'url' => '#', 'target' => ''),
        'video_source' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'overlay_color' => '#000000',
        'overlay_opacity' => 60,
        'content_alignment' => 'center',
        'content_width' => 'default',
        'height' => 'large',
        'vertical_position' => 'center',
        'show_scroll_indicator' => 0,
    ),
);

$blocks[] = array(
    'name' => 'Hero Slider',
    'fields' => array(
        'content_alignment' => 'left',
        'content_width' => 'wide',
        'height' => 'large',
        'vertical_position' => 'center',
        'autoplay' => 1,
        'autoplay_speed' => 5000,
        'transition_style' => 'fade',
        'show_arrows' => 1,
        'show_dots' => 1,
        'slides' => array(
            array(
                'eyebrow' => 'Web Design',
                'heading' => 'Beautiful Websites That Drive Results',
                'subheading' => 'Custom-designed websites that combine stunning aesthetics with conversion-focused strategy.',
                'button' => array('title' => 'View Portfolio', 'url' => '#', 'target' => ''),
                'overlay_color' => '#000000',
                'overlay_opacity' => 55,
            ),
            array(
                'eyebrow' => 'Development',
                'heading' => 'Built With Performance in Mind',
                'subheading' => 'Lightning-fast WordPress sites with clean code and scalable architecture.',
                'button' => array('title' => 'Our Process', 'url' => '#', 'target' => ''),
                'overlay_color' => '#0a0a2e',
                'overlay_opacity' => 60,
            ),
            array(
                'eyebrow' => 'Strategy',
                'heading' => 'Digital Growth That Scales',
                'subheading' => 'Data-driven strategies that turn your website into your most powerful sales tool.',
                'button' => array('title' => 'Get Started', 'url' => '#', 'target' => ''),
                'overlay_color' => '#1a0a0a',
                'overlay_opacity' => 55,
            ),
        ),
    ),
);

$blocks[] = array(
    'name' => 'Hero Fullscreen',
    'fields' => array(
        'eyebrow' => 'Make a Statement',
        'heading' => 'Bold Ideas Deserve a Bold Presence',
        'subheading' => 'Full-screen impact that commands attention. When your story is worth the entire screen, this is how you tell it.',
        'primary_button' => array('title' => 'Explore Our Work', 'url' => '#', 'target' => ''),
        'secondary_button' => array('title' => 'Contact Us', 'url' => '#', 'target' => ''),
        'overlay_color' => '#000000',
        'overlay_opacity' => 50,
        'content_alignment' => 'center',
        'content_width' => 'default',
        'vertical_position' => 'center',
        'show_scroll_indicator' => 1,
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
    'name' => 'Content',
    'fields' => array(
        'content' => '<h2>Rich Content Block</h2><p>This is the Content block with a <strong>default</strong> max-width setting. It\'s perfect for long-form content, blog-style pages, and general text sections. The content is centered and constrained for optimal readability.</p><p>You can include <a href="#">links</a>, <strong>bold text</strong>, <em>italic text</em>, lists, images, and any other HTML content the WordPress editor supports.</p><ul><li>Full WYSIWYG editor support</li><li>Three width options: narrow, default, and wide</li><li>Clean typography with proper spacing</li></ul><blockquote>This is a blockquote. It stands out from the rest of the content with a left border accent.</blockquote>',
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

// ── BANNER ──────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Banner',
    'fields' => array(
        'text' => 'New: We just launched our redesigned portfolio. Check it out!',
        'link' => array('title' => 'View Portfolio', 'url' => '#', 'target' => ''),
        'background' => 'primary',
        'dismissible' => 0,
    ),
);

// ── BLOG POSTS ──────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Blog Posts',
    'fields' => array(
        'eyebrow' => 'From the Blog',
        'heading' => 'Latest Insights & Articles',
        'subheading' => 'Stay up to date with the latest trends in web design, development, and digital marketing.',
        'posts_per_page' => 3,
        'columns' => '3',
        'show_date' => 1,
        'show_excerpt' => 1,
        'button' => array('title' => 'View All Posts', 'url' => '#', 'target' => ''),
    ),
);

// ── TABS ────────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Tabs',
    'fields' => array(
        'eyebrow' => 'Our Services',
        'heading' => 'What We Bring to the Table',
        'subheading' => 'Explore our core service areas and discover how we can help your business grow.',
        'style' => 'horizontal',
        'tabs' => array(
            array('title' => 'Web Design', 'icon_class' => 'fa-solid fa-palette', 'content' => '<p>Our design team creates visually stunning, user-centered websites that capture your brand\'s essence. We focus on clean layouts, intuitive navigation, and responsive design that looks beautiful on every device.</p><ul><li>Custom UI/UX design</li><li>Responsive layouts</li><li>Brand-aligned aesthetics</li><li>Conversion-focused design</li></ul>'),
            array('title' => 'Development', 'icon_class' => 'fa-solid fa-code', 'content' => '<p>We build fast, scalable, and secure websites using modern technologies. Our development process follows best practices for performance, accessibility, and maintainability.</p><ul><li>Custom WordPress development</li><li>E-commerce solutions</li><li>API integrations</li><li>Performance optimization</li></ul>'),
            array('title' => 'Marketing', 'icon_class' => 'fa-solid fa-bullhorn', 'content' => '<p>Drive traffic and conversions with our data-driven digital marketing strategies. From SEO to social media, we help you reach the right audience at the right time.</p><ul><li>Search engine optimization</li><li>Content strategy</li><li>Social media management</li><li>Analytics and reporting</li></ul>'),
            array('title' => 'Support', 'icon_class' => 'fa-solid fa-life-ring', 'content' => '<p>We don\'t disappear after launch. Our ongoing support and maintenance plans ensure your site stays secure, up-to-date, and performing at its best.</p><ul><li>24/7 monitoring</li><li>Security updates</li><li>Performance tuning</li><li>Content updates</li></ul>'),
        ),
    ),
);

// ── MARQUEE ─────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Marquee',
    'fields' => array(
        'style' => 'text',
        'speed' => 'medium',
        'direction' => 'left',
        'pause_on_hover' => 1,
        'separator' => '•',
        'items' => array(
            array('text' => 'Web Design'),
            array('text' => 'Development'),
            array('text' => 'Branding'),
            array('text' => 'SEO'),
            array('text' => 'E-Commerce'),
            array('text' => 'UI/UX'),
            array('text' => 'Strategy'),
            array('text' => 'Marketing'),
        ),
    ),
);

// ── MAP ─────────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Map',
    'fields' => array(
        'eyebrow' => 'Find Us',
        'heading' => 'Visit Our Office',
        'content' => 'We\'re located in the heart of downtown. Stop by for a coffee and a chat about your next project.',
        'map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215!2d-73.9857!3d40.7484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        'map_height' => 450,
        'style' => 'contained',
    ),
);

// ── TIMELINE ────────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Timeline',
    'fields' => array(
        'eyebrow' => 'Our Journey',
        'heading' => 'Company Milestones',
        'subheading' => 'From a small startup to a full-service agency — here\'s how we got here.',
        'items' => array(
            array('date' => '2015', 'icon_class' => 'fa-solid fa-flag', 'title' => 'Founded', 'description' => 'Started as a two-person freelance team working out of a co-working space with a passion for great web design.'),
            array('date' => '2017', 'icon_class' => 'fa-solid fa-users', 'title' => 'Team of 5', 'description' => 'Hired our first full-time employees and moved into our first dedicated office space.'),
            array('date' => '2019', 'icon_class' => 'fa-solid fa-trophy', 'title' => '100th Project', 'description' => 'Celebrated our 100th completed project and won our first industry design award.'),
            array('date' => '2021', 'icon_class' => 'fa-solid fa-building', 'title' => 'New HQ', 'description' => 'Moved into our current headquarters with room for 20+ team members and a dedicated client meeting space.'),
            array('date' => '2024', 'icon_class' => 'fa-solid fa-rocket', 'title' => 'Going Global', 'description' => 'Expanded our services internationally, working with clients across three continents.'),
        ),
    ),
);

// ── COMPARISON TABLE ────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Comparison Table',
    'fields' => array(
        'eyebrow' => 'Compare Plans',
        'heading' => 'Find the Right Fit',
        'subheading' => 'See how our plans stack up against each other. Choose the one that best suits your needs.',
        'columns' => array(
            array('name' => 'Starter', 'is_highlighted' => 0, 'button' => array('title' => 'Choose Starter', 'url' => '#', 'target' => '')),
            array('name' => 'Professional', 'is_highlighted' => 1, 'button' => array('title' => 'Choose Pro', 'url' => '#', 'target' => '')),
            array('name' => 'Enterprise', 'is_highlighted' => 0, 'button' => array('title' => 'Contact Us', 'url' => '#', 'target' => '')),
        ),
        'features' => array(
            array('feature_name' => 'Pages', 'col_1' => 'custom', 'col_1_custom' => 'Up to 5', 'col_2' => 'custom', 'col_2_custom' => 'Up to 15', 'col_3' => 'custom', 'col_3_custom' => 'Unlimited'),
            array('feature_name' => 'Custom Design', 'col_1' => 'cross', 'col_2' => 'check', 'col_3' => 'check'),
            array('feature_name' => 'SEO Setup', 'col_1' => 'custom', 'col_1_custom' => 'Basic', 'col_2' => 'custom', 'col_2_custom' => 'Advanced', 'col_3' => 'custom', 'col_3_custom' => 'Advanced'),
            array('feature_name' => 'E-Commerce', 'col_1' => 'cross', 'col_2' => 'cross', 'col_3' => 'check'),
            array('feature_name' => 'Blog', 'col_1' => 'cross', 'col_2' => 'check', 'col_3' => 'check'),
            array('feature_name' => 'Support', 'col_1' => 'custom', 'col_1_custom' => '30 days', 'col_2' => 'custom', 'col_2_custom' => '90 days', 'col_3' => 'custom', 'col_3_custom' => '1 year'),
            array('feature_name' => 'Revisions', 'col_1' => 'custom', 'col_1_custom' => '1 round', 'col_2' => 'custom', 'col_2_custom' => '3 rounds', 'col_3' => 'custom', 'col_3_custom' => 'Unlimited'),
            array('feature_name' => 'Analytics', 'col_1' => 'cross', 'col_2' => 'check', 'col_3' => 'check'),
        ),
    ),
);

// ── BEFORE/AFTER ────────────────────────────────────────────────────────

$blocks[] = array(
    'name' => 'Before After',
    'fields' => array(
        'eyebrow' => 'The Difference',
        'heading' => 'See the Transformation',
        'before_label' => 'Before',
        'after_label' => 'After',
        'default_position' => 50,
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

// Verify Content block data made it into post_content
$page = get_post($post_id);
$has_content = strpos($page->post_content, 'Rich Content Block') !== false;
echo $has_content ? "\n[OK] Content block data found in post_content\n" : "\n[WARN] Content block data NOT found in post_content\n";

echo "\nNote: Image fields are empty — add placeholder images via the editor.\n";
echo "Note: Logo Bar logos need to be added via the editor.\n";
