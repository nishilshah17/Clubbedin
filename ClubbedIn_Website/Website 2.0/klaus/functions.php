<?php 
/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!

-------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*  Set Max Content Width
/* ----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) )
	$content_width = 1170;

/*-----------------------------------------------------------------------------------*/
/*	Default Theme Constant
/*-----------------------------------------------------------------------------------*/

define('AZ_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/');
define('AZ_THEME_NAME', 'klaus');


/*-----------------------------------------------------------------------------------*/
/*	Theme Setup
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_theme_setup' ) ) {
	function az_theme_setup(){
		// Load Translation Domain
		load_theme_textdomain(AZ_THEME_NAME, get_template_directory() . '/languages');

		// Remove Generator for Security
		remove_action( 'wp_head', 'wp_generator' );

		// Register Menus
		register_nav_menus(array('primary_menu' => __('Primary Menu', AZ_THEME_NAME) ));

		// Add RSS Feed links to HTML
		add_theme_support('automatic-feed-links');

		// Add Support for Post Formats
		add_theme_support('post-formats', array('quote','video','audio', 'image', 'gallery','link'));

		// Configure Thumbnails
		add_theme_support('post-thumbnails');
		add_image_size('portfolio-thumb', 400, 400, true); // Portfolio Thumb Only
		add_image_size('portfolio-wall-thumb', 400, 400, true); // Portfolio Wall Thumb
		add_image_size('team-thumb', 400, 400, true); // Team Thumb Only
		add_image_size('latest-post-thumb', 400, 300, true); // Latest Post Only
	}
}
add_action('after_setup_theme', 'az_theme_setup');


/*-----------------------------------------------------------------------------------*/
/*	Custom Login Logo
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_custom_login_logo' ) ) {
	function az_custom_login_logo() {
	    echo '<style type="text/css">
	        h1 a { background-image:url('.get_template_directory_uri().'/_include/img/logo-admin.png) !important; width: auto !important; height: 98px !important; background-size: auto auto !important; }
	    </style>';
	}
}
add_action('login_head', 'az_custom_login_logo');

if ( !function_exists( 'az_wp_login_url' ) ) {
	function az_wp_login_url() {
		return home_url();
	}
}
add_filter('login_headerurl', 'az_wp_login_url');

if ( !function_exists( 'az_wp_login_title' ) ) {
	function az_wp_login_title() {
		return get_option('blogname');
	}
}
add_filter('login_headertitle', 'az_wp_login_title');

/*-----------------------------------------------------------------------------------*/
/*	Register / Enqueue Google Fonts or Custom Fonts
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'klaus_google_fonts' ) ) {
	function klaus_google_fonts() {
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'klaus-font', "$protocol://fonts.googleapis.com/css?family=Muli:400,300,300italic,400italic|Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900italic,900" );
	}
}

if ( !function_exists( 'az_enqueue_custom_fonts_css' ) ) {
	function az_enqueue_custom_fonts_css() {
		wp_register_style('custom-fonts', get_template_directory_uri() . '/_include/css/custom-fonts.css.php');
		wp_enqueue_style('custom-fonts');
	}
} 

$options = get_option('klaus');
if( !empty($options['enable-custom-fonts']) && $options['enable-custom-fonts'] == 1 ) {
	// Enqueue Custom Fonts CSS 
	add_action('wp_print_styles', 'az_enqueue_custom_fonts_css', 100);
} else {
	// Enqueue Default Theme Google Fonts
	add_action( 'wp_enqueue_scripts', 'klaus_google_fonts' );
}

/*-----------------------------------------------------------------------------------*/
/*	Register / Enqueue JS
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_register_js' ) ) {
	function az_register_js() {	
		
		if (!is_admin()) {
			
			// Register 
			wp_register_script('modernizer', get_template_directory_uri() . '/_include/js/modernizr.js', 'jquery', '2.5.3');
			wp_register_script('bootstrap-js', get_template_directory_uri() . '/_include/js/bootstrap.min.js', 'jquery', '2.3', TRUE);
			wp_register_script('isotope', get_template_directory_uri() . '/_include/js/isotope.js', 'jquery', '1.5.25', TRUE);
				
			wp_register_script('plugins', get_template_directory_uri() . '/_include/js/plugins.js', 'jquery', '1.0.0' ,TRUE);
			
			// Enqueue
			wp_enqueue_script('jquery');
			wp_enqueue_script('modernizer');
			wp_enqueue_script('bootstrap-js');
			wp_enqueue_script('isotope');

			wp_enqueue_script('plugins');
		}
	}
}
add_action('wp_enqueue_scripts', 'az_register_js');

if ( !function_exists( 'az_page_specific_js' ) ) {
	function az_page_specific_js() {
		
		// Contact Page
		if ( is_page_template('template-contact.php') ) {
			wp_register_script('googleMaps', 'http://maps.google.com/maps/api/js?sensor=false', NULL, NULL, TRUE);
			wp_register_script('azMap', get_template_directory_uri() . '/_include/js/map.js', array('jquery', 'googleMaps'), '1.0', TRUE);
			
			wp_enqueue_script('googleMaps');
			wp_enqueue_script('azMap');
		}
		
		// Loads the javascript required for threaded comments
		if( is_singular() && comments_open() && get_option( 'thread_comments') ) 
	        wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'az_page_specific_js'); 



/*-----------------------------------------------------------------------------------*/
/*	Register / Enqueue CSS
/*-----------------------------------------------------------------------------------*/

//Main Styles
if ( !function_exists( 'az_main_styles' ) ) {
	function az_main_styles() {	
			 
			 // Register 
			 wp_register_style('bootstrap', get_template_directory_uri() . '/_include/css/bootstrap.min.css');
			 wp_register_style("main-styles", get_stylesheet_directory_uri() . "/style.css");
			 
			 // Enqueue
			 wp_enqueue_style('bootstrap'); 
			 wp_enqueue_style('main-styles');
	}
}
add_action('wp_print_styles', 'az_main_styles');


/*-----------------------------------------------------------------------------------*/
/*	Dynamic Styles
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_enqueue_dynamic_css' ) ) {
	function az_enqueue_dynamic_css() {
		wp_register_style('dynamic-colors', get_template_directory_uri() . '/_include/css/color.css.php', 'style');
		wp_register_style('custom', get_template_directory_uri() . '/_include/css/custom.css.php', 'style');
		
		wp_enqueue_style('dynamic-colors'); 
		wp_enqueue_style('custom');
	} 
}
add_action('wp_print_styles', 'az_enqueue_dynamic_css');


/*-----------------------------------------------------------------------------------*/
/*	Widget Area
/*-----------------------------------------------------------------------------------*/

if(function_exists('register_sidebar')) {
	
	register_sidebar(array(
		'name' => __('Blog Sidebar', AZ_THEME_NAME), 
		'description' => __('Widget area for blog pages.', AZ_THEME_NAME),
		'id' => 'sidebar-blog',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  =>
		'<h3 class="widget-title">',
		'after_title'   => '</h3>'
		)
	);
	
	register_sidebar(array(
		'name' => __('Page Sidebar', AZ_THEME_NAME), 
		'description' => __('Widget area for pages.', AZ_THEME_NAME),
		'id' => 'sidebar-page', 
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>', 
		'before_title'  => '<h3 class="widget-title">', 
		'after_title'   => '</h3>'
		)
	);
	
	register_sidebar(array(
		'name' => __('Footer Area 1', AZ_THEME_NAME), 
		'description' => __('Widget area for footer area.', AZ_THEME_NAME),
		'id' => 'footer-area-one', 
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>', 
		'before_title'  => '<h3>', 
		'after_title'   => '</h3>'
		)
	);
	
	register_sidebar(array(
		'name' => __('Footer Area 2', AZ_THEME_NAME), 
		'description' => __('Widget area for footer area.', AZ_THEME_NAME),
		'id' => 'footer-area-two',  
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>', 
		'before_title'  => '<h3>', 
		'after_title'   => '</h3>'
		)
	);
	
	register_sidebar(array(
		'name' => __('Footer Area 3', AZ_THEME_NAME), 
		'description' => __('Widget area for footer area.', AZ_THEME_NAME),
		'id' => 'footer-area-three',  
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>', 
		'before_title'  => '<h3>', 
		'after_title'   => '</h3>'
		)
	);

	register_sidebar(array(
		'name' => __('Footer Area 4', AZ_THEME_NAME), 
		'description' => __('Widget area for footer area.', AZ_THEME_NAME),
		'id' => 'footer-area-four',  
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>', 
		'before_title'  => '<h3>', 
		'after_title'   => '</h3>'
		)
	);
}


/*------------------------------------------------------------------------------*/
/*	Widgets: Twitter - Flickr
/*------------------------------------------------------------------------------*/

include('framework/widgets/flickr-widget.php');
include('framework/widgets/twitter-widget.php');
include('framework/widgets/dribbble-widget.php');
include('framework/widgets/social-widget.php');

/*-----------------------------------------------------------------------------------*/
/*	Add Custom Class Last Post
/*-----------------------------------------------------------------------------------*/

function az_post_class($classes){
    global $wp_query;
    if(($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'last';
    return $classes;
}

add_filter('post_class', 'az_post_class');

/*-----------------------------------------------------------------------------------*/
/*	Common Fix
/*-----------------------------------------------------------------------------------*/

//Fixing filtering for shortcodes
function shortcode_empty_paragraph_fix($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}

add_filter('the_content', 'shortcode_empty_paragraph_fix');


// Remove rel attribute from the category list
function remove_category_list_rel( $output ) {
    return str_replace( ' rel="category tag"', '', $output );
}
 
add_filter( 'wp_list_categories', 'remove_category_list_rel' );
add_filter( 'the_category', 'remove_category_list_rel' );

// Twitter Filter
function TwitterFilter($string)
{
$content_array = explode(" ", $string);
$output = '';

foreach($content_array as $content)
{
//starts with http://
if(substr($content, 0, 7) == "http://")
$content = '<a href="' . $content . '">' . $content . '</a>';

//starts with www.
if(substr($content, 0, 4) == "www.")
$content = '<a href="http://' . $content . '">' . $content . '</a>';

if(substr($content, 0, 8) == "https://")
$content = '<a href="' . $content . '">' . $content . '</a>';

if(substr($content, 0, 1) == "#")
$content = '<a href="https://twitter.com/search?src=hash&q=' . $content . '">' . $content . '</a>';

if(substr($content, 0, 1) == "@")
$content = '<a href="https://twitter.com/' . $content . '">' . $content . '</a>';

$output .= " " . $content;
}

$output = trim($output);
return $output;
}

function attr($s,$attrname) { // return html attribute
	preg_match_all('#\s*('.$attrname.')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x);
	if (count($x)>=3) return $x[2][0]; else return "";
}


/*-----------------------------------------------------------------------------------*/
/* Exclude Pages from search
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'az_exclude_pages_in_search' ) ) {
    function az_exclude_pages_in_search($query) {
        if( !$query->is_admin && $query->is_search ) {
            $query->set('post_type', 'post');
        }
    return $query;
    }
}

add_filter('pre_get_posts','az_exclude_pages_in_search');


/*-----------------------------------------------------------------------------------*/
/*	Excerpt Length
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_excerpt_length' ) ) {
	function az_excerpt_length($length) {
		return 34; 
	}
}
add_filter('excerpt_length', 'az_excerpt_length');


if ( !function_exists( 'az_excerpt_more' ) ) {
	function az_excerpt_more($excerpt) {
		return str_replace('[...]', '...', $excerpt); 
	}
}
add_filter('wp_trim_excerpt', 'az_excerpt_more');


/*-----------------------------------------------------------------------------------*/
/*	Meta Config
/*-----------------------------------------------------------------------------------*/


function enqueue_media(){
	
	//enqueue the correct media scripts for the media library 
	$wp_version = floatval(get_bloginfo('version'));
	
	if ( $wp_version < "3.5" ) {
	    wp_enqueue_script(
	        'redux-opts-field-upload-js', 
	        AZ_FRAMEWORK_DIRECTORY . 'assets/upload/field_upload_3_4.js', 
	        array('jquery', 'thickbox', 'media-upload'),
	        time(),
	        true
	    );
	    wp_enqueue_style('thickbox');// thanks to https://github.com/rzepak
	} else {
	    wp_enqueue_script(
	        'redux-opts-field-upload-js', 
	        AZ_FRAMEWORK_DIRECTORY . 'assets/upload/field_upload.js', 
	        array('jquery'),
	        time(),
	        true
	    );
	    wp_enqueue_script(
	        'redux-field-gallery-js', 
	        AZ_FRAMEWORK_DIRECTORY . 'assets/gallery/field_gallery.js', 
	        array('jquery'),
	        time(),
	        true
	    );
		wp_enqueue_script(
			'redux-field-color-js', 
			AZ_FRAMEWORK_DIRECTORY . 'assets/color/field_color.js',
			array( 'jquery', 'wp-color-picker' ),
			time(),
			true
		);
		wp_enqueue_style(
			'redux-field-color-css', 
			AZ_FRAMEWORK_DIRECTORY . 'assets/color/field_color.css', 
			time(),
			true
		);
	    wp_enqueue_media();
	}
	
}


//Meta Styling
function  az_metabox_styles() {
	wp_enqueue_style('az_meta_css', AZ_FRAMEWORK_DIRECTORY .'assets/css/az_meta.css');
}

//Meta Scripts
function az_metabox_scripts() {
	wp_register_script('az-upload', AZ_FRAMEWORK_DIRECTORY .'assets/js/az-meta.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('az-upload');
	wp_localize_script('redux-opts-field-upload-js', 'redux_upload', array('url' => AZ_FRAMEWORK_DIRECTORY .'assets/upload/blank.png'));
}
add_action('admin_enqueue_scripts', 'az_metabox_scripts');
add_action('admin_print_styles', 'az_metabox_styles');
add_action('admin_print_styles', 'enqueue_media');


//Meta Core functions
include("framework/meta/meta-config.php");

// Page Header Meta
include("framework/meta/page-meta.php");

// Team Meta
include("framework/meta/team-meta.php");

// Portfolio Meta
include("framework/meta/portfolio-meta.php");

// Post Meta
include("framework/meta/post-meta.php");

// Footer Meta
include("framework/meta/footer-meta.php");

/*-----------------------------------------------------------------------------------*/
/*  Custom Output Page Title
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'az_custom_get_page_title' ) ) {
    function az_custom_get_page_title() {
        $page_title = '';
        if( is_archive() ) {
                if( is_category() ) {
                    $page_title = sprintf( __( 'All posts in &#8220;%s&#8221', AZ_THEME_NAME ), single_cat_title('', false) );
                } elseif( is_tag() ) {
                    $page_title = sprintf( __( 'All posts in &#8220;%s&#8221', AZ_THEME_NAME ), single_tag_title('', false) );
                } elseif( is_date() ) {
                    if( is_month() ) {
                        $page_title = sprintf( __( 'Archive for &#8220;%s&#8221', AZ_THEME_NAME ), get_the_time( 'F, Y' ) );
                    } elseif( is_year() ) {
                        $page_title = sprintf( __( 'Archive for &#8220;%s&#8221', AZ_THEME_NAME ), get_the_time( 'Y' ) );
                    } elseif( is_day() ) {
                        $page_title = sprintf( __('Archive for &#8220;%s&#8221', AZ_THEME_NAME ), get_the_time( get_option('date_format') ) );
                    } else {
                        $page_title = __('Blog Archives', AZ_THEME_NAME);
                    }
                } elseif( is_author() ) {
                    if(get_query_var('author_name')) {
                        $curauth = get_user_by( 'login', get_query_var('author_name') );
                    } else {
                        $curauth = get_userdata(get_query_var('author'));
                    }
                    $page_title = $curauth->display_name;
                } 
            } 
		elseif( is_search() ) {
       		$page_title = sprintf( __( 'Search Results for &#8220;%s&#8221;', AZ_THEME_NAME ), get_search_query() );
        } 

        return $page_title;
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Navigation
/*-----------------------------------------------------------------------------------*/

// Simple Navigation Blog
if ( !function_exists( 'az_pagination' ) ) {
	
	function az_pagination() {	
		global $options;
		
		if( get_next_posts_link() || get_previous_posts_link() ) { 
			echo '<section class="main-content-navi default-padding">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="navigation-projects">
									<ul>
				  						<li class="prev">'.get_previous_posts_link('<i class="font-icon-arrow-left-simple-round"></i> Older Entries').'</li>
				  						<li class="next">'.get_next_posts_link('<i class="font-icon-arrow-right-simple-round"></i> New Entries').'</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				  </section>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Comment Styling
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_comment' ) ) {
	
	function az_comment($comment, $args, $depth) {
	
        $isByAuthor = false;

        if($comment->comment_author_email == get_the_author_meta('email')) {
            $isByAuthor = true;
        }

        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-section">              
                <div class="comment-side">
                	<?php echo get_avatar($comment,$size='50'); ?>
                </div>
             
                <div class="comment-cont">
                    <div class="comment-author">
                        <cite class="fn"><?php echo get_comment_author_link(); ?></cite><?php if( $isByAuthor ) { ?><span class="badge_author"></span><?php } ?>
                    </div>
                    
                    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( __('%1$s at %2$s', AZ_THEME_NAME), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link(__('Edit', AZ_THEME_NAME), ' / ','') ?> / <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
                    
                    <?php if ( $comment -> comment_approved == '0') : ?>
                        <em class="moderation"><?php _e('Your comment is awaiting moderation.', AZ_THEME_NAME) ?></em><br />
                    <?php endif; ?>
                    
                    <div class="comment-body">
                        <?php comment_text() ?>
                    </div>
                </div>
            </div>
	<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Seperated Pings Styling
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'az_comment_list_pings' ) ) {
	function az_comment_list_pings($comment, $args, $depth) {
	    $GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
		<?php 
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Social Profiles
/*-----------------------------------------------------------------------------------*/

$socials_profiles = array ('500px', 'addthis', 'behance', 'bebo', 'blogger', 'deviant-art', 'digg', 'dribbble', 'email', 'envato', 'evernote', 'facebook', 'flickr', 'forrst', 'github', 'google-plus', 'grooveshark', 'instagram', 'last-fm', 'linkedin', 'myspace', 'paypal', 'photobucket', 'pinterest', 'quora', 'share-this', 'skype', 'soundcloud', 'stumbleupon', 'tumblr', 'twitter', 'viddler', 'vimeo', 'virb', 'wordpress', 'yahoo', 'yelp', 'youtube', 'zerply');


/*-----------------------------------------------------------------------------------*/
/*	Extend Body Class
/*-----------------------------------------------------------------------------------*/

/**
 * Add browser detection and post name to body class
 * Add post title to body class on single pages
 *
 * @link http://www.wprecipes.com/wordpress-hack-automatically-add-post-name-to-the-body-class
 * @param array $classes The current body classes
 * @return array The new body classes
 */
if ( !function_exists( 'az_browser_body_class' ) ) {
	function az_body_classes($classes) {
	    // Add our browser class
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE){ 
			$classes[] = 'ie';
			if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version)) $classes[] = 'ie'.$browser_version[1];
		} else $classes[] = 'unknown';
	
		if($is_iphone) $classes[] = 'iphone';
		
		// Add the post title
		if( is_singular() ) {
    		global $post;
    		array_push( $classes, "{$post->post_type}-{$post->post_name}" );
    	}
    	
    	// Add 'az'
    	array_push( $classes, "az" );
    	
		return $classes;

	}
}
add_filter('body_class','az_body_classes');

/*-----------------------------------------------------------------------------------*/
/*	Open Graph
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'add_opengraph' ) ) {
	function add_opengraph() {
		global $post;

		echo "<meta property='og:site_name' content='". get_bloginfo('name') ."'/>\n";
		echo "<meta property='og:url' content='" . get_permalink() . "'/>\n";

		if (is_singular()) { // If we are on a blog post/page
	        echo "<meta property='og:title' content='" . get_the_title() . "'/>\n";
	        echo "<meta property='og:type' content='article'/>\n";
	        if(has_post_thumbnail( $post->ID )) {
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				echo "<meta property='og:image' content='" . esc_attr( $thumbnail[0] ) . "'/>\n";
			} 
	    } elseif(is_front_page() or is_home()) {
	    	echo "<meta property='og:title' content='" . get_bloginfo("name") . "'/>\n";
	    	echo "<meta property='og:type' content='website'/>\n";
	    	if(has_post_thumbnail( $post->ID )) {
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				echo "<meta property='og:image' content='" . esc_attr( $thumbnail[0] ) . "'/>\n";
			} 
	    }

	}
}
add_action( 'wp_head', 'add_opengraph', 2 );


/*-----------------------------------------------------------------------------------*/
/*	Include the framework
/*-----------------------------------------------------------------------------------*/

$tempdir = get_template_directory();
require_once($tempdir .'/framework/meta/custom-functions-meta.php');
require_once($tempdir .'/framework/options/framework.php');
require_once($tempdir .'/framework/options/az_framework/config.php');
require_once($tempdir .'/framework/plugin-activation/init.php');

?>