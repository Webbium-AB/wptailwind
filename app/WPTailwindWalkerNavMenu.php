<?php
namespace WPTailwind;

class WPTailwindWalkerNavMenu extends \Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul x-show="open" class="ml-4 lg:ml-0 border-l-2 border-gray-200 lg:absolute lg:orgin-top-right lg:mt-2 w-48 lg:rounded-md lg:shadow-lg lg:bg-white lg:py-1 ' . $class_names . '">' . "\n";
    }
 
    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
 
        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
 
        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        $hasChildren = in_array('menu-item-has-children', $item->classes);
        
        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class=" pr-3' . $depth_class_names . ' ' . $class_names.'"';
        $inline = $depth == 0 ? 'inline-block' : '';
        if ($hasChildren ) {
            $output .= ' x-data="{ open: false }" @click.away="open = false"';
            $inline = 'inline-flex relative';
        }
        $output .= '>';
 
        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

        $url = (!empty($item->url) && !$hasChildren) ? $item->url : '#';
        $attributes .= ' href="'.esc_attr($url).'"';

        $attributes .= $hasChildren ? ' @click="open = !open"' : '';

        $attributes .= ' class="'.$inline.' py-2 px-4 menu-link ' . ( $depth > 0 ? 'sub-menu-link block leading-5 text-gray-700 lg:hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out' : 'main-menu-link' ) . '"';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            ($hasChildren) ? '<svg class="-mr-1 ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>'.$args->link_after : $args->link_after,
            $args->after
        );

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}