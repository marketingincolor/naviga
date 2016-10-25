<?php
/**
 * Setup theme options
 */
function madico_theme_setup() {
	add_post_type_support( 'page', 'excerpt' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 265, 60 );
	add_image_size( 'sidebar-featured', 300, 200 );
}
add_action( 'after_setup_theme', 'madico_theme_setup', 11 );

add_action('init', 'register_custom_posttypes');
add_filter('wp_list_pages','base_better_lists');
add_filter('wp_list_categories','base_better_lists');


/**
 * Enqueue styles
 */
function css_enqueue() {
	wp_enqueue_style( 'custom_meta_css', get_bloginfo('stylesheet_directory') . '/css/meta.css' );
}
add_action( 'admin_enqueue_scripts', 'css_enqueue' );

/**
 * Check if post is in a menu
 *
 * @param $menu menu name, id, or slug
 * @param $object_id int post object id of page
 * @return bool true if object is in menu
 */
function madico_post_in_menu( $menu = null, $object_id = null ) {

    $menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );

    // stop if there isn't a menu
    if( ! $menu_object )
        return false;

    // get the object_id field out of the menu object
    $menu_items = wp_list_pluck( $menu_object, 'object_id' );

    // use the current post if object_id is not specified
    if( ! $object_id ) {
        global $post;
        $object_id = get_queried_object_id();
    }

    return in_array( (int) $object_id, $menu_items );
}

/**
 * Generate sidebar menu for "product technology" pages
 */
function madico_sidebar_nav() {

	global $section;
	if ( $section !== 'specialty-film' && $section !== 'pv-backsheets' )
		return false;

	// which menu to display?
	if ( $section === 'specialty-film' )
		$menu = 'Product Technology';
	else
		$menu = 'Product Technology: PV Backsheets';

	if ( madico_post_in_menu( $menu ) || is_page('contact') ) {
		$html = '<li>';
		$html .= "<h2>Product Technology</h2>";
		$html .= wp_nav_menu( array(
			'menu' => $menu,
			'echo' => false,
	    ) );
	    $html .= '</li>';

	    return $html;
	}

	return false;
}

/**
 * Rewrite Search Results URL
 * http://bavotasan.com/2011/rewrite-search-result-url-for-wordpress/
 */
function base_search_url_rewrite_rule() {
	if ( is_search() && !empty($_GET['s'])) {
		wp_redirect( home_url("/search/") . urlencode( get_query_var('s') ) . '/' );
		exit();
	}
}
// add_action('template_redirect', 'base_search_url_rewrite_rule');

/**
 * Relevanssi Excerpt Content Filtering
 */
function madico_search_excerpt_filters( $content ) {
	// Remove text between { and } to avoid showing commands
	// for the Tabs Slides plugin used for tabbed content
	$content = preg_replace('/{([^}]*)}/', '.', $content);

	return $content;
}
add_filter('relevanssi_excerpt_content', 'madico_search_excerpt_filters');


/**
 * Replace useless paragraph tags from strings output by the WYSIWYG editor
 */
function base_tinymce_filtering( $content ) {
	$content_editted = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', $content); // Remove empty paragraphs

	return $content_editted;
}
add_filter( 'the_content', 'base_tinymce_filtering', 10 );

/**
 * Pagination for archives and listing pages
 */
function madico_pagination()
{
	global $wp_query;

	$total = $wp_query->max_num_pages;

	$permalink_structure = get_option('permalink_structure');

	//$format = ( empty( $permalink_structure ) ) ? '&page=%#%' : 'page/%#%/';
	$test_format = get_query_var('s');
	//$format = ( empty( $permalink_structure ) ) ? '&paged=%#%' : 'page/%#%/';
	$format = ( $test_format !='' ) ? '&paged=%#%' : 'page/%#%/';


	$paginate_links = paginate_links(array(
		'base' => get_pagenum_link(1) . '%_%',
		'format' => $format,
		'current' => max( 1, get_query_var('paged') ),
		'total' => $total
	));

	if( $paginate_links )
	{
		echo '<div class="pagination">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}

/**
 *	Configure default oEmbed video sizes
 */
function base_oembed_defaults($embed_size) {
	if( is_single() ) {
		$embed_size['width'] = 580;
		$embed_size['height'] = 435;
	}
	return $embed_size;
}
add_filter('embed_defaults', 'base_oembed_defaults');

/**
 *	Editor styles and added classes
 */
add_editor_style('css/editor-style.css?v=2');

function madico_tinymce_add_styleselect($buttons)
{
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'madico_tinymce_add_styleselect');

function madico_tinymce_set_formats($settings)
{
	$style_formats = array(
		// Buttons
		array(
			'title' => 'Button',
			'block' => 'p',
			'classes' => 'button'
		)
	);
	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}
add_filter('tiny_mce_before_init', 'madico_tinymce_set_formats');

/**
 *	Callout post type list
 */
if ( !function_exists('madico_post_type_list') ) {
	function madico_post_type_list( $post_type = 'team', $size = -1)
	{
		$pos = strpos($post_type, ',');

		/** Get multiple post types if passed an array */
		if ( $pos !== false ) {
			$post_types = explode(',', $post_type);
		} else {
			$post_types = $post_type;
		}

		/** Query arguments */
		$query_args = array(
			'post_type' => $post_types,
			'posts_per_page' => $size,
			'post_status' => 'publish'
		);
		$query = null;
		$query = new WP_Query($query_args);
		$query_size = $query->post_count;
		$counter = 0;

		if ($query->have_posts()) {

			global $post;
			$current_page = $post->ID;

			$html = "<ul>";

			while ($query->have_posts()) {

				/** Settings */
				$counter++;
				global $post;
				$query->the_post();
				$id = get_the_ID();
				$title = get_the_title();
				$link = get_permalink();
				$classes = array();
				array_push($classes, $post->post_type);
				if ( $id == $current_page ) array_push($classes, 'current');
				if ( $query_size == $counter ) array_push($classes, 'last');
				$class = implode(' ', $classes);

				/** Output */
				$html .= "<li id='entry-$id' class='$class'><a href='$link' title='$title'>$title</a></li>";
			}

			wp_reset_query();

			$html .= "</ul>";

			return $html;

		} else {

			return false;

		}
	}
}

/**
 * Get the current URL
 */
function base_get_current_url() {
	$pageURL = 'http';

	if ( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
		$pageURL .= "s";

	$pageURL .= "://";

	if ( $_SERVER["SERVER_PORT"] != "80" )
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	return $pageURL;
}

/**
 * Register global variables
 */
function madico_globals() {
	// Check for Chinese translation
	$url = parse_url( base_get_current_url() );
	if ( strstr($url['path'], '/zh-hant/') || strstr($url['path'], '/zh-hans/') )
		$GLOBALS['language'] = 'chinese';
	else
		$GLOBALS['language'] = 'english';
}
add_action('template_redirect', 'madico_globals', 1);

/**
 * New more link
 */
function new_excerpt_more($more) {
	global $post;
	return '&hellip; <p><a href="'. get_permalink($post->ID) . '" class="button more-link">' . translate('Read More') . '</a></p>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length($length) {
	return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

/**
* Constructs an ordered array from cf metadata
* THIS FUNCTION REQUIRES A CFT SETUP LIKE SO:
* [NAME_fieldset] is the fieldset
* [NAME_field] 	for each field
* call function using NAME
*/
function get_cft_repeating_data( $like_item ){
	global $post, $wpdb;

	$sql = "SELECT *
	FROM $wpdb->postmeta
	WHERE post_id = $post->ID
	AND meta_key LIKE '%" . $like_item . "%'
	ORDER BY meta_id ASC";

	$return = array();
	$images = array();	//cft_slideshow_image
	$captions = array();//cft_slideshow_description

	$data_objects = $wpdb->get_results($sql);
	if( $data_objects ) {
		foreach( $data_objects as $data ) {
			if( $data->meta_key == 'cft_slideshow_image' ) {
				$images[] = $data->meta_value;
			}
			else
			if( $data->meta_key == 'cft_slideshow_description' ) {
				$captions[] = $data->meta_value;
			}
		}
	}

	if( $images ) {
		foreach( $images as $index => $image) {

			$caption = (isset( $captions[$index] ) ? $captions[$index] : '' );

			$return[$index] = array(
				'cft_slideshow_image' => $image,
				'cft_slideshow_description' => $caption,
			);

		}
	}
	return $return;
}

// Generate Breadcrumbs
function show_breadcrumb() {
	global $post;

	// If page has a parent build the breadcrumbs
	if ( !isset($post->post_parent) || empty($post->post_parent) )
		return false;

	// Breadcrumb output
	$html = '<div class="breadcrumbs">';

	if ( isset($post->ancestors) )
		$ancestors = ( is_array($post->ancestors) ) ? array_values($post->ancestors) : array($post->ancestors);
	else
		$ancestors = array($post->post_parent);

	// More than 1 level deep
	if ( $ancestors ) {
		$ancestors = array_reverse($ancestors);
		$count = count($ancestors);
		$i = 0;
		foreach ( $ancestors as $ancestor ) {
			$html .= '<a href="' . get_permalink($ancestor) . '">' . strip_tags( get_the_title( $ancestor ) ) . '</a> ';

			// Add separator
			if ( $i != $count)
				$html .= ' <span class="divider">&raquo;</span> ';

			$i++;
		}
		$html .= '<strong>' . apply_filters('the_title', $post->post_title) . '</strong>';
	}
	$html .= '</div>';

	echo $html;
}

function custom_page_menu_args($args) {
	$args["show_home"] = true;
	return $args;
}
add_filter("wp_page_menu_args", "custom_page_menu_args");

//Add 'first' and 'last' classes to ends of wp_list_pages and wp_list_categories
function base_better_lists($content) {
	$pattern = '/<li class="/is';
	$content = preg_replace($pattern, '<li class="first ', $content, 1);
	$pattern = '/<li class="(?!.*<li class=")/is';
	$content = preg_replace($pattern, '<li class="last ', $content, 1);
	return $content;
}

// Additional Admin Styles
function admin_register_head() {
	$siteurl = get_option('siteurl');
	$url = get_bloginfo('template_directory') . '/css/admin.css';
	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
	$url = get_bloginfo('template_directory') . '/js/admin.js';
	echo "<script type='text/javascript' src='$url'></script>\n";
}
add_action('admin_head', 'admin_register_head');

// Modded wp_list_pages() function for dropdown's
function main_navigation() {
	wp_list_pages('title_li=&sort_column=menu_order&depth=2&sort_order=ASC&link_before=<span>&link_after=</span>');
}

/**
 * Theme JavaScript
 */
function madico_enqueue_js(){

	// Only load for front facing website
	if ( is_admin() )
		return;

	// Theme JS
	wp_enqueue_script( 'headjs', get_stylesheet_directory_uri() . '/js/head.load.min.js', array(), filemtime( get_stylesheet_directory() . '/js/head.load.min.js' ), false );
	wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.min.js', array('headjs', 'jquery'), filemtime( get_stylesheet_directory() . '/js/global.min.js' ), false );

	// Comments
	if ( is_singular() && comments_open() )
		wp_enqueue_script( 'comment-reply' );
}
add_action('wp_enqueue_scripts', 'madico_enqueue_js');

/**
 * Generates semantic classes for BODY element
 */
function base_body_class( $print = true ) {
	global $wp_query, $current_user, $language;

	// It's surely a WordPress blog, right?
	$c = array('wordpress');

	// Applies the time- and date-based classes (below) to BODY element
	//thematic_date_classes( time(), $c );

	// Generic semantic classes for what type of content is displayed
	is_front_page()  ? $c[] = 'home'       : null; // For the front page, if set
	is_home()        ? $c[] = 'blog'       : null; // For the blog posts page, if set
	is_archive()     ? $c[] = 'archive'    : null;
	is_date()        ? $c[] = 'date'       : null;
	is_search()      ? $c[] = 'search'     : null;
	is_paged()       ? $c[] = 'paged'      : null;
	is_attachment()  ? $c[] = 'attachment' : null;
	is_404()         ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	if( get_post_meta($wp_query->post->ID, "_wp_page_template", true) == 'homepage.php'
		|| get_post_meta($wp_query->post->ID, "_wp_page_template", true) == 'page-films-landing.php' )
		$c[] = 'home';

	 if ( $language == 'chinese' )
	 	$c[] = 'chinese';

	global $wp_query;
	$c[] = 'post-id-'.$wp_query->post->ID;

	// Special classes for BODY element when a singular post
	if ( is_singular() ) {
		$c[] = 'singular';
	} else {
		$c[] = 'not-singular';
	}

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

        // Adds post slug class, prefixed by 'slug-'
        $c[] = 'slug-' . $wp_query->post->post_name;

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset( $wp_query->post->post_date ) )
			thematic_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$mime_type = get_post_mime_type();
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
				$c[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();

		// For posts with excerpts
		if (has_excerpt())
			$c[] = 's-has-excerpt';

		// For posts with comments open or closed
		if (comments_open()) {
			$c[] = 's-comments-open';
		} else {
			$c[] = 's-comments-closed';
		}

		// For posts with pings open or closed
		if (pings_open()) {
			$c[] = 's-pings-open';
		} else {
			$c[] = 's-pings-closed';
		}

		// For password-protected posts
		if ( $post->post_password )
			$c[] = 's-protected';

		// For sticky posts
		if (is_sticky())
		   $c[] = 's-sticky';

		// Custom post types
		if ( get_query_var('post_type') )
			$c[] = 'type-' . get_query_var('post_type');

	}

	//if the page is using a subnav
	global $post;
	if($post->post_parent != 0) {
		$c[] = 'hasSubNav';
	}

	// Author name classes for BODY on author archives
	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	elseif ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug;
	}

	// Page author for BODY on 'pages'
	elseif ( is_page() ) {
		$pageID = $wp_query->post->ID;
		$page_children = wp_list_pages("child_of=$pageID&echo=0");
		the_post();

        // Adds post slug class, prefixed by 'slug-'
        $c[] = 'slug-' . $wp_query->post->post_name;

		$c[] = 'page pageid-' . $pageID;

		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

		// Checks to see if the page has children and/or is a child page; props to Adam
		if ( $page_children )
			$c[] = 'page-parent';
		if ( $wp_query->post->post_parent )
			$c[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;

		// For pages with excerpts
		if (has_excerpt())
			$c[] = 'page-has-excerpt';

		// For pages with comments open or closed
		if (comments_open()) {
			$c[] = 'page-comments-open';
		} else {
			$c[] = 'page-comments-closed';
		}

		// For pages with pings open or closed
		if (pings_open()) {
			$c[] = 'page-pings-open';
		} else {
			$c[] = 'page-pings-closed';
		}

		// For password-protected pages
		if ( $post->post_password )
			$c[] = 'page-protected';

		// Checks to see if the page is using a template
		if ( is_page_template() & !is_page_template('default') )
			$c[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
		rewind_posts();
	}

	// Search classes for results or no results
	elseif ( is_search() ) {
		the_post();
		if ( have_posts() ) {
			$c[] = 'search-results';
		} else {
			$c[] = 'search-no-results';
		}
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) {
	// Thanks to Prentiss Riddle, twitter.com/pzriddle, for the security fix below.
 			$page = intval($page); // Ensures that an integer (not some dangerous script) is passed for the variable
		$c[] = 'paged-' . $page;
		if ( is_single() ) {
			$c[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$c[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$c[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$c[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) {
			$c[] = 'date-paged-' . $page;
		} elseif ( is_author() ) {
			$c[] = 'author-paged-' . $page;
		} elseif ( is_search() ) {
			$c[] = 'search-paged-' . $page;
		}
	}

	// A little Browser detection shall we?
	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];

	// Is it an iPhone?
	if(preg_match( "/iPhone/", $browser ) || preg_match( "/iPod/", $browser ))
			$c[] = 'iphone';

	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ){
			$c[] = 'mac';

	} elseif ( preg_match( "/Windows/", $browser ) ){
			$c[] = 'windows';

	} elseif ( preg_match( "/Linux/", $browser ) ) {
			$c[] = 'linux';

	} else {
			$c[] = 'unknown-os';
	}

	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Chrome/", $browser ) ) {
			$c[] = 'chrome';

			preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
			$ch_version = 'ch' . str_replace( '.', '-', $matches[1] );
			$c[] = $ch_version;

	} elseif ( preg_match( "/Safari/", $browser ) ) {
			$c[] = 'safari';

			preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
			$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
			$c[] = $sf_version;

	} elseif ( preg_match( "/Opera/", $browser ) ) {
			$c[] = 'opera';

			preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
			$op_version = 'op' . str_replace( '.', '-', $matches[1] );
			$c[] = $op_version;

	} elseif ( preg_match( "/MSIE/", $browser ) ) {
			$c[] = 'msie';

			if( preg_match( "/MSIE 6.0/", $browser ) ) {
					$c[] = 'ie6';
			} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
					$c[] = 'ie7';
			} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
					$c[] = 'ie8';
			}

	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
			$c[] = 'firefox';

			preg_match( "/Firefox\/(\d)/si", $browser, $matches);
			$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
			$c[] = $ff_version;

	} else {
			$c[] = 'unknown-browser';
	}

	if ( isset( $postID ) ) {
		in_array(4, get_post_ancestors($postID))? $c[] = "specialty-film" : null;
		// We have to hard code because the plugin can't check the whole ancestry.
		in_array(6, get_post_ancestors($postID))? $c[] = "window-film" : null;
		in_array(2, get_post_ancestors($postID))? $c[] = "about" : null;
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join( ' ', apply_filters( 'body_class',  $c ) ); // Available filter: body_class

	// And tada!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
/*function thematic_date_classes( $t, &$c, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}*/






// Multiple Sidebars
/*if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name'=>'Specialty Film Pages',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'name'=>'Window Film Pages',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'name'=>'General Page',
		'before_widget' => '<li id="%1$s" class="callout">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'name'=>'Event',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name'=>'Blog',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}*/

//Initialize and Register sidebars for theme
function theme_widgets_init() {
	register_sidebar(array(
		'name' => 'Primary Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Secondary Sidebar',
		'id' => 'sidebar-2',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Tertiary Sidebar',
		'id' => 'sidebar-3',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	));
}
add_action( 'widgets_init', 'theme_widgets_init' );





/**
 *	Child page conditional
 *	@ Accept's page ID, page slug or page title as parameters
 */
function is_child( $parent = '' ) {
	global $post;

	$parent_obj = get_page( $post->post_parent, ARRAY_A );
	$ancestors = $parent_obj->ancestors;
	$parent = (string) $parent;
	$parent_array = (array) $parent;

	if ( in_array( (string) $parent_obj['ID'], $parent_array ) ) {
		return true;
	}
	else if ( in_array( (string) $parent_obj['post_name'], $parent_array ) ) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * Add styles to TinyMCE link class dropdown
 */
function madico_mce_css($wp) {
	return $wp .= ',' . get_bloginfo('template_directory') . '/css/mce.css';
}
add_filter( 'mce_css', 'madico_mce_css' );

/**
 * Custom walker class, using regular WP Menu method instead of older page listing.
 */
class Madico_Custom_Walker_Menu extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$tier_number = $depth + 2;
		$output .= "\n$indent<div class=\"tier-$tier_number\"><ul class='children'>\n";
	}
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $tier_current = $depth + 1;
        $class_names = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        if ($args->has_children && $depth > 0) {
            $class_names .= ' page_item_has_children';
        } else if($args->has_children && $depth === 0) {
            $class_names .= ' page_item_has_children';
        }
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $output .= $indent . '<li' . $class_names .'>';
        $attributes = ! empty( $item->attr_title ) ? 'title="' . esc_attr( $item->attr_title     ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element ) {
            return;
        }
        $id_field = $this->db_fields['id'];
        //display this element
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

function language_selector_flags(){
	$languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
	if(!empty($languages)){
		foreach($languages as $l){
			if(!$l['active']) echo '<a href="'.$l['url'].'">';
			echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
			if(!$l['active']) echo '</a>';
		}
	}
}
