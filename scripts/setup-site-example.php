<?php
/**
 * Example Site Setup Script
 *
 * Creates standard pages using presets and configures the site.
 * Adapt this file for each new client site.
 *
 * Usage:
 *   wp eval-file "wp-content/themes/DevQ Starter/scripts/setup-site-example.php"
 *
 * Or via WP-CLI commands:
 *   wp devq create-page --title="Home" --preset=home --status=publish
 *   wp devq create-page --title="About" --preset=about --status=publish
 *   wp devq create-page --title="Services" --preset=services --status=publish
 *   wp devq create-page --title="Contact" --preset=contact --status=publish
 */

if (!function_exists('devq_create_page')) {
    echo "Error: DevQ Starter theme must be active.\n";
    return;
}

// --- Create Pages ---

$pages = array(
    array(
        'title' => 'Home',
        'slug' => 'home',
        'status' => 'publish',
        'preset' => 'home',
    ),
    array(
        'title' => 'About',
        'slug' => 'about',
        'status' => 'publish',
        'preset' => 'about',
    ),
    array(
        'title' => 'Services',
        'slug' => 'services',
        'status' => 'publish',
        'preset' => 'services',
    ),
    array(
        'title' => 'Contact',
        'slug' => 'contact',
        'status' => 'publish',
        'preset' => 'contact',
    ),
);

$presets = devq_get_page_presets();
$created_pages = array();

foreach ($pages as $page) {
    $args = array(
        'title' => $page['title'],
        'slug' => $page['slug'],
        'status' => $page['status'],
        'blocks' => isset($presets[$page['preset']]) ? $presets[$page['preset']] : array(),
    );

    $post_id = devq_create_page($args);

    if (is_wp_error($post_id)) {
        echo "Error creating {$page['title']}: " . $post_id->get_error_message() . "\n";
    } else {
        echo "Created {$page['title']} (ID: {$post_id})\n";
        $created_pages[$page['slug']] = $post_id;
    }
}

// --- Set Home as Front Page ---

if (isset($created_pages['home'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $created_pages['home']);
    echo "Set Home as static front page.\n";
}

// --- Create Primary Navigation Menu ---

$menu_name = 'Primary Menu';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);

    if (!is_wp_error($menu_id)) {
        // Add pages to menu in order
        $menu_order = 1;
        foreach (array('home', 'about', 'services', 'contact') as $slug) {
            if (isset($created_pages[$slug])) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => get_the_title($created_pages[$slug]),
                    'menu-item-object-id' => $created_pages[$slug],
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $menu_order,
                ));
                $menu_order++;
            }
        }

        // Assign to primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

        echo "Created '{$menu_name}' with " . ($menu_order - 1) . " items and assigned to primary location.\n";
    }
} else {
    echo "Menu '{$menu_name}' already exists, skipping.\n";
}

echo "\nSetup complete!\n";
