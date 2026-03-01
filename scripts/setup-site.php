<?php
/**
 * Site Content Scaffold — Phase 2 of New Site Setup
 *
 * Creates pages from presets, sets front page, builds nav menu,
 * cleans up default content, and sets permalinks.
 * Requires an active DevQ Starter (or child) theme.
 *
 * Usage:
 *   wp eval-file "wp-content/themes/devq-starter/scripts/setup-site.php"
 *   wp eval-file "wp-content/themes/devq-starter/scripts/setup-site.php" home about services contact
 *
 * Pass page names as arguments to override the defaults (home, about, services, contact).
 * Each name must match a key in devq_get_page_presets().
 */

// --- Verify theme is active ---

if ( ! function_exists( 'devq_create_page' ) ) {
    WP_CLI::error( 'DevQ Starter theme must be active. Run bootstrap.php first.' );
}

if ( ! function_exists( 'devq_get_page_presets' ) ) {
    WP_CLI::error( 'Page presets not available. Ensure functions/page-presets.php is loaded.' );
}

// --- Determine which pages to create ---

$presets = devq_get_page_presets();

$default_pages = array( 'home', 'about', 'services', 'contact' );
$page_list = ! empty( $args ) ? array_map( 'strtolower', $args ) : $default_pages;

// Validate all requested pages have presets
foreach ( $page_list as $page_key ) {
    if ( ! isset( $presets[ $page_key ] ) ) {
        $available = implode( ', ', array_keys( $presets ) );
        WP_CLI::error( "No preset found for '{$page_key}'. Available presets: {$available}" );
    }
}

// --- Create pages ---

$created_pages = array();

foreach ( $page_list as $page_key ) {
    $title = ucfirst( $page_key );

    // Check if a page with this slug already exists
    $existing = get_page_by_path( $page_key );
    if ( $existing ) {
        WP_CLI::warning( "Page '{$title}' already exists (ID: {$existing->ID}). Skipping." );
        $created_pages[ $page_key ] = $existing->ID;
        continue;
    }

    $post_id = devq_create_page( array(
        'title'  => $title,
        'slug'   => $page_key,
        'status' => 'publish',
        'blocks' => $presets[ $page_key ],
    ) );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "Error creating {$title}: " . $post_id->get_error_message() );
    } else {
        WP_CLI::log( "Created {$title} (ID: {$post_id})" );
        $created_pages[ $page_key ] = $post_id;
    }
}

// --- Set Home as static front page ---

if ( isset( $created_pages['home'] ) ) {
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $created_pages['home'] );
    WP_CLI::log( 'Set Home as static front page.' );
} else {
    WP_CLI::warning( 'No "home" page created — skipping front page setting.' );
}

// --- Create Primary Navigation Menu ---

$menu_name = 'Primary Menu';
$menu_exists = wp_get_nav_menu_object( $menu_name );

if ( ! $menu_exists ) {
    $menu_id = wp_create_nav_menu( $menu_name );

    if ( ! is_wp_error( $menu_id ) ) {
        $menu_order = 1;
        foreach ( $page_list as $page_key ) {
            if ( isset( $created_pages[ $page_key ] ) ) {
                wp_update_nav_menu_item( $menu_id, 0, array(
                    'menu-item-title'     => get_the_title( $created_pages[ $page_key ] ),
                    'menu-item-object-id' => $created_pages[ $page_key ],
                    'menu-item-object'    => 'page',
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $menu_order,
                ) );
                $menu_order++;
            }
        }

        // Assign to primary location
        $locations = get_theme_mod( 'nav_menu_locations' );
        if ( ! is_array( $locations ) ) {
            $locations = array();
        }
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        WP_CLI::log( "Created '{$menu_name}' with " . ( $menu_order - 1 ) . ' items and assigned to primary location.' );
    } else {
        WP_CLI::warning( 'Failed to create nav menu: ' . $menu_id->get_error_message() );
    }
} else {
    WP_CLI::warning( "Menu '{$menu_name}' already exists. Skipping." );
}

// --- Delete default content ---

// Delete "Sample Page"
$sample_page = get_page_by_path( 'sample-page' );
if ( $sample_page ) {
    wp_delete_post( $sample_page->ID, true );
    WP_CLI::log( 'Deleted default "Sample Page".' );
}

// Delete "Hello world!" post
$hello_post = get_posts( array(
    'name'        => 'hello-world',
    'post_type'   => 'post',
    'post_status' => 'any',
    'numberposts' => 1,
) );
if ( ! empty( $hello_post ) ) {
    wp_delete_post( $hello_post[0]->ID, true );
    WP_CLI::log( 'Deleted default "Hello world!" post.' );
}

// Delete default "Uncategorized" is not worth it (WP recreates it), skip.

// --- Set permalink structure ---

global $wp_rewrite;
$wp_rewrite->set_permalink_structure( '/%postname%/' );
$wp_rewrite->flush_rules();
WP_CLI::log( 'Set permalink structure to /%postname%/.' );

WP_CLI::success( 'Site scaffold complete!' );
