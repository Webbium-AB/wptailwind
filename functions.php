<?php
use WPTailwind\AutoLoader;

/*
 * Set up our auto loading class and mapping our namespace to the app directory.
 */
require_once(__DIR__.'/app/AutoLoader.php');
$loader = new AutoLoader();
$loader->register();
$loader->addNamespace('WPTailwind', get_stylesheet_directory().'/app');

/*
 * Composer
 */
require_once(__DIR__.'/vendor/autoload.php');

/*
 * Restrict API access to whitelist IP(s), remove to enable WP API
 */
function restrictRestApiToLocalhost() {
    $whitelist = [];

    if( ! in_array($_SERVER['REMOTE_ADDR'], $whitelist ) ){
        die( 'REST API is disabled.' );
    }
}
add_action('rest_api_init', 'restrictRestApiToLocalhost', 0);

/*
 * Register widget area
 */
function widgetsInit() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wptailwind' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wptailwind' ),
		'before_widget' => '<section id="%1$s" class="shadow-md bg-white mx-2 mb-4 p-4 lg:mx-0 widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'widgetsInit' );


/*
 * Theme support
 */
function setupTheme() {
    /*
    * Make theme available for translation.
    * Translations can be filed in the /languages/ directory.
    * If you're building a theme based on wptailwind, use can find and replace
    * to change 'wptailwind' to the name of your theme in all the template files.
    */
    load_theme_textdomain( 'wptailwind', get_template_directory() . '/languages' );

    // Post thumbnail
    add_theme_support('post-thumbnails');    
    set_post_thumbnail_size(960, 360, ['center', 'center']);

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'navbar' => esc_html__('Navbar', 'wptailwind'),
    ) );
}
add_action('after_setup_theme', 'setupTheme');

/**
 * Enqueue scripts
 */
function enqueueScripts() {
    // Material icons
    wp_enqueue_script('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons');

    // Google Fonts (Poppins)
    wp_enqueue_style('poppins', 'https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap', []);

    // Local styles and scripts
    wp_enqueue_style('webbium-style', get_template_directory_uri().'/dist/css/app.css', [], date('Y-m-d'));
    wp_enqueue_script('webbium-javascript', get_template_directory_uri() . '/dist/js/app.js', array(), date('Y-m-d'), true);
   
}
add_action('wp_enqueue_scripts', 'enqueueScripts' );

function tailwindPagination( \WP_Query $wp_query = null, $echo = true ) {
	if ( null === $wp_query ) {
		global $wp_query;
	}
	$pages = paginate_links( [
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __( '« Föregående' ),
			'next_text'    => __( 'Nästa »' ),
			'add_args'     => false,
			'add_fragment' => ''
		]
	);
	if ( is_array( $pages ) ) {
        $pagination = '<div class="flex mb-4 mx-4 lg:mx-0"><ul class="flex rounded border-gray-400 bg-white border overflow-hidden">';
        foreach ($pages as $page) {
            $pagination .= '<li class="inline-flex page-item' . (strpos($page, 'current') !== false ? ' bg-gray-400' : ' hover:bg-gray-200') . '"> ' . str_replace('page-numbers', 'page-link py-2 px-3', $page) . '</li>';
        }
        $pagination .= '</ul></div>';
        
        if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}
	return null;
}

/*
 * Change "Read more" link in post listings
 */
function theContentMoreLink() {
    return '<div class="text-left"><a class="text-blue-500 hover:underline" href="' . get_permalink() . '">Read more</a></div>';
}
add_filter( 'the_content_more_link', 'theContentMoreLink' );

/*
 * Shortcode(s)
 */

function addShortCodeButton($atts, $content = null) {
    $a = shortcode_atts([
        'target' => '_blank',
        'class' => 'bg-red-500 py-2 px-4 mb-4 text-white rounded',
        'href' => ''
    ], $atts);

    return '<a href="'.$a['href'].'" target="'.$a['target'].'" class="inline-block btn '.$a['class'].'">'.esc_html($content).'</a>';
}

add_shortcode('button', 'addShortCodeButton');