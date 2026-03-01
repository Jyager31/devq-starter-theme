<?php
class fluent_themes_custom_walker_nav_menu extends Walker_Nav_Menu
{

    private $blog_sidebar_pos = "";
    // add classes to ul sub-menus
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // depth dependent classes
        $indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'dropdown-menu',
            ($display_depth % 2  ? 'menu-odd' : 'menu-even'),
            ($display_depth >= 2 ? '' : ''),
            'menu-depth-' . $display_depth
        );
        $class_names = implode(' ', $classes);

        // build html

        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    // add main/sub classes to li's and links
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query, $wpdb;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

        // depth dependent classes
        $depth_classes = array(
            ($depth == 0 ? '' : ''), //class for the top level menu which got sub-menu
            ($depth >= 1 ? '' : 'dropdown'), //class for the level-1 sub-menu which got level-2 sub-menu
            ($depth >= 2 ? 'sub-sub-menu-item' : ''), //class for the level-2 sub-menu which got level-3 sub-menu
            ($depth % 2 ? 'menu-item-odd' : 'menu-item-even'),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // passed classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // build html
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // link attributes
        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';
        //$attributes .= ' class="' . ( $depth > 0 ? '' : '' ) . '"';

        // Check if menu item is in main menu
        $has_children = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(meta_id) FROM {$wpdb->postmeta} WHERE meta_key = '_menu_item_menu_item_parent' AND meta_value = %d",
            $item->ID
        ));

        if ($depth == 0 && $has_children > 0) {
            // These lines adds your custom class and attribute
            $attributes .= ' class="dropdown-toggle"';
            $attributes .= ' data-toggle="dropdown"';
            $attributes .= ' data-hover="dropdown"';
            $attributes .= ' data-animations="fadeInUp"';
        }
        $description  = !empty($item->description) ? '<span class="fa ' . esc_attr($item->description) . '" aria-hidden="true"></span>' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $description . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after; //If you want the description to be output after <a>
        //$item_output .= $description.$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after; //If you want the description to be output before </a>

        // Add the caret if menu level is 0
        if ($depth == 0 && $has_children > 0) {
            $item_output .= '<i class="fas fa-caret-down"></i>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id);
    }
} //End Walker_Nav_Menu