<?php
/**
 * Bootstrap Script — Phase 1 of New Site Setup
 *
 * Copies the child theme boilerplate, renames it for the client,
 * and activates parent + child themes. Runs BEFORE the theme is active
 * (no theme functions required).
 *
 * Usage:
 *   wp eval-file "wp-content/themes/devq-starter/scripts/bootstrap.php" "Client Name"
 */

// --- Validate arguments ---

if ( empty( $args ) || empty( $args[0] ) ) {
    WP_CLI::error( 'Client name is required. Usage: wp eval-file "...bootstrap.php" "Client Name"' );
}

$client_name = trim( $args[0] );
$client_slug = sanitize_title( $client_name ); // e.g. "Acme Corp" → "acme-corp"
$child_dir_name = $client_slug . '-child';

// --- Paths ---

$themes_dir   = get_theme_root();
$boilerplate  = $themes_dir . '/devq-starter/devq-starter-child';
$destination  = $themes_dir . '/' . $child_dir_name;

// --- Copy child theme boilerplate ---

if ( is_dir( $destination ) ) {
    WP_CLI::warning( "Child theme directory '{$child_dir_name}' already exists. Skipping copy." );
} else {
    if ( ! is_dir( $boilerplate ) ) {
        WP_CLI::error( "Boilerplate not found at: {$boilerplate}" );
    }

    // Copy directory
    $files = scandir( $boilerplate );
    if ( ! mkdir( $destination, 0755, true ) ) {
        WP_CLI::error( "Failed to create directory: {$destination}" );
    }

    foreach ( $files as $file ) {
        if ( $file === '.' || $file === '..' ) {
            continue;
        }
        $src  = $boilerplate . '/' . $file;
        $dest = $destination . '/' . $file;

        if ( is_file( $src ) ) {
            copy( $src, $dest );
        }
    }

    WP_CLI::log( "Copied child theme boilerplate to: {$child_dir_name}/" );
}

// --- Update style.css with client name ---

$style_path = $destination . '/style.css';
if ( file_exists( $style_path ) ) {
    $style_contents = file_get_contents( $style_path );
    $style_contents = str_replace( 'Client Name', $client_name, $style_contents );

    // Update the theme directory name (Theme Name matches client)
    $style_contents = preg_replace(
        '/^Theme Name:\s*.+$/m',
        'Theme Name: ' . $client_name,
        $style_contents
    );

    file_put_contents( $style_path, $style_contents );
    WP_CLI::log( "Updated style.css with client name: {$client_name}" );
}

// --- Activate parent theme, then child theme ---

// Switch to parent first to ensure it's recognized
switch_theme( 'devq-starter' );
WP_CLI::log( 'Activated parent theme: devq-starter' );

// WordPress needs to rescan themes to pick up the new child directory
wp_clean_themes_cache();
search_theme_directories( true );

// Now activate the child theme
$child_theme = wp_get_theme( $child_dir_name );
if ( ! $child_theme->exists() ) {
    WP_CLI::error( "Child theme '{$child_dir_name}' not found after copy. Check the themes directory." );
}

switch_theme( $child_dir_name );
WP_CLI::success( "Activated child theme: {$child_dir_name}" );

// --- Verify ACF is active ---

if ( ! class_exists( 'ACF' ) && ! function_exists( 'get_field' ) ) {
    WP_CLI::warning( 'ACF Pro is NOT active. Install and activate it before running setup-site.php.' );
} else {
    WP_CLI::log( 'ACF Pro is active.' );
}

WP_CLI::success( "Bootstrap complete for '{$client_name}'." );
