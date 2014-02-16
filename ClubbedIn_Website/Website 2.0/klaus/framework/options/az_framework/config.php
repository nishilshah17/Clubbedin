<?php

/*
 *
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'redux-framework-demo'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
		'icon' => 'paper-clip',
		'icon_class' => 'icon-large',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
add_filter('redux-opts-sections-redux-sample', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
    //$args['dev_mode'] = false;
    
    return $args;
}
//add_filter('redux-opts-args-redux-sample-file', 'change_framework_args');


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options(){
    $args = array();


    // For use with a tab below
		$tabs = array();

		ob_start();

		$ct = wp_get_theme();
        $theme_data = $ct;
        $item_name = $theme_data->get('Name'); 
		$tags = $ct->Tags;
		$screenshot = $ct->get_screenshot();
		$class = $screenshot ? 'has-screenshot' : '';

		$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'redux-framework-demo' ), $ct->display('Name') );

		?>
		<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
			<?php if ( $screenshot ) : ?>
				<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
				<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
					<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
				</a>
				<?php endif; ?>
				<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
			<?php endif; ?>

			<h4>
				<?php echo $ct->display('Name'); ?>
			</h4>

			<div>
				<ul class="theme-info">
					<li><?php printf( __('By %s', 'redux-framework-demo'), $ct->display('Author') ); ?></li>
					<li><?php printf( __('Version %s', 'redux-framework-demo'), $ct->display('Version') ); ?></li>
					<li><?php echo '<strong>'.__('Tags', 'redux-framework-demo').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
				</ul>
				<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
				<?php if ( $ct->parent() ) {
					printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
						__( 'http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'),
						$ct->parent()->display( 'Name' ) );
				} ?>
				
			</div>

		</div>

		<?php
		$item_info = ob_get_contents();
		    
		ob_end_clean();


	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}  		
		$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
	}


    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
    $args['dev_mode_icon_class'] = 'icon-large';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = 'klaus';

    // Setting system info to true allows you to view info useful for debugging.
    // Default: false
    //$args['system_info'] = true;

    
	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

    // If you want to use Google Webfonts, you MUST define the api key.
    $args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

    // Define the starting tab for the option panel.
    // Default: '0';
    //$args['last_tab'] = '0';

    // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
    // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
    // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
    // Default: 'standard'
    //$args['admin_stylesheet'] = 'standard';

    // Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/bluxart',
        'title' => 'Follow me on Twitter', 
        'img' => 'font-icon-social-twitter'
    );
    $args['share_icons']['dribbble'] = array(
        'link' => 'http://dribbble.com/Bluxart',
        'title' => 'Find me on Dribbble', 
        'img' => 'font-icon-social-dribbble'
    );
	$args['share_icons']['forrst'] = array(
        'link' => 'http://forrst.com/people/Bluxart',
        'title' => 'Find me on Forrst', 
        'img' => 'font-icon-social-forrst'
    );
	$args['share_icons']['behance'] = array(
        'link' => 'http://www.behance.net/alessioatzeni',
        'title' => 'Find me on Behance', 
        'img' => 'font-icon-social-behance'
    );
	$args['share_icons']['facebook'] = array(
        'link' => 'https://www.facebook.com/atzenialessio',
        'title' => 'Follow me on Facebook', 
        'img' => 'font-icon-social-facebook'
    );
	$args['share_icons']['google_plus'] = array(
        'link' => 'https://plus.google.com/105500420878314068694/posts',
        'title' => 'Find me on Google Plus', 
        'img' => 'font-icon-social-google-plus'
    );
	$args['share_icons']['linked_in'] = array(
        'link' => 'http://www.linkedin.com/in/alessioatzeni',
        'title' => 'Find me on LinkedIn', 
        'img' => 'font-icon-social-linkedin'
    );
	$args['share_icons']['envato'] = array(
        'link' => 'http://themeforest.net/user/Bluxart',
        'title' => 'Find me on Themeforest', 
        'img' => 'font-icon-social-envato'
    );

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

    // Set a custom menu icon.
    //$args['menu_icon'] = '';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Klaus', 'redux-framework-demo');

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Klaus', 'redux-framework-demo');

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: redux_options
    $args['page_slug'] = 'redux_options';

    $args['default_show'] = false;
    $args['default_mark'] = '';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    //$args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options_general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    //$args['page_position'] = null;

    // Set a custom page icon class (used to override the page icon next to heading)
    //$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-1',
        'title' => __('Theme Information 1', 'redux-framework-demo'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
    );
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-2',
        'title' => __('Theme Information 2', 'redux-framework-demo'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
    );

    // Set the help sidebar for the options page.                                        
    $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');


    // Add HTML before the form.
    if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
    	if (!empty($args['global_variable'])) {
    		$v = $args['global_variable'];
    	} else {
    		$v = str_replace("-", "_", $args['opt_name']);
    	}
    	$args['intro_text'] = __('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$'.$v.'</strong></p>', 'redux-framework-demo');
    } else {
    	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
    }

    // Add content after the form.
    // $args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');

    // Set footer/credit line.
    //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'redux-framework-demo');
    $args['footer_credit'] = false;

    $sections = array();              

    //Background Patterns Reader
    $sample_patterns_path = REDUX_DIR . '../sample/patterns/';
    $sample_patterns_url  = REDUX_URL . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) :
    	
      if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
      	$sample_patterns = array();

        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

          if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
          	$name = explode(".", $sample_patterns_file);
          	$name = str_replace('.'.end($name), '', $sample_patterns_file);
          	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
          }
        }
      endif;
    endif;

    // General Options
	$sections[] = array(
		'title' => __('General Options', 'redux-framework-demo'),
		'desc' => __('Welcome to the Klaus Options Panel! Control and configure the general setup of your theme.', 'redux-framework-demo'),
		'icon_class' => 'icon-large',
        'icon' => 'home',
		'fields' => array(
			array(
				'id'=>'favicon',
				'type' => 'media', 
				'title' => __('Favicon Upload', 'redux-framework-demo'),
				'subtitle' => __('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.', 'redux-framework-demo'),
				'desc'=> ''
			),
			array(
                'id' => 'enable-animation',
                'type' => 'switch',
                'title' => __('Do you want Preloader?', 'redux-framework-demo'), 
                'subtitle' => __('Enable/Disable preloader page for your site.', 'redux-framework-demo'),
                'desc' => '',
                'default' => 0
            ),
            array(
                'id' => 'enable-animation-effects',
                'type' => 'switch',
                'title' => __('Do you want Animation Effects on mobile devices?', 'redux-framework-demo'), 
                'subtitle' => __('Enable/Disable animation effects on mobile devices for items.', 'redux-framework-demo'),
                'desc' => '',
                'default' => 0
            ),
            array(
                'id' => 'enable-back-to-top',
                'type' => 'switch',
                'title' => __('Back to Top?', 'redux-framework-demo'), 
                'subtitle' => __('Enable/Disable Back to Top Feature.', 'redux-framework-demo'),
                'desc' => '',
                'default' => 1
            ),
            array(
				'id'=>'tracking-code',
				'type' => 'textarea',
				'title' => __('Tracking Code', 'redux-framework-demo'), 
				'subtitle' => __('Paste your Google Analytics (or other) tracking code here.<br/> It will be inserted before the closing head tag of your theme.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id'=>'custom-css',
				'type' => 'textarea',
				'title' => __('Custom CSS', 'redux-framework-demo'), 
				'subtitle' => __('If you have any custom CSS you would like added to the site, please enter it here.', 'redux-framework-demo'),
				'desc' => '',
				'validate' => 'css'
			),
		)
	);

    // Color Options
    $sections[] = array(
        'title' => __('Color Options', 'redux-framework-demo'),
        'desc' => __('Welcome to the Klaus Options Panel! Control and configure the colors of your theme.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'home',
        'fields' => array(
            array(
                'id' => 'accent-color',
                'type' => 'color',
                'title' => __('Accent Color', 'redux-framework-demo'),
                'subtitle' => __('Change this color to alter the accent color globally for your site. Try one of the six pre-picked colors that are guaranteed to look awesome!', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#F05253'
            ),

            // Custom Header Colors
            array(
                'id'=>'enable-header-color',
                'type' => 'switch', 
                'title' => __('Custom Header Colors?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom colors for header?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            array(
                'id' => 'header-background',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Background', 'redux-framework-demo'),
                'subtitle' => __('Choose a Background Color for Header.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#FFFFFF'
            ),
            array(
                'id' => 'header-logo-font-color',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Logo Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Logo Font Color for Header.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#2D3C48'
            ),
            array(
                'id' => 'header-font-color',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Font Color for Header.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#818B92'
            ),
            array(
                'id' => 'header-font-color-hover',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Font Color Hover', 'redux-framework-demo'),
                'subtitle' => __('Choose a Hover Font Color for Header.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#2D3C48'
            ),
            array(
                'id' => 'header-separator-color',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Font Color Hover', 'redux-framework-demo'),
                'subtitle' => __('Choose a Separator Color for menu list.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#EEEEEE'
            ),
            array(
                'id' => 'header-dropdown-background',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Dropdown Background', 'redux-framework-demo'),
                'subtitle' => __('Choose a Background Color for Dropdown menu.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#252728'
            ),
            array(
                'id' => 'header-dropdown-font-color',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Dropdown Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Font Color for Dropdown menu.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#FFFFFF'
            ),
            array(
                'id' => 'header-dropdown-separator-color',
                'type' => 'color',
                'required' => array('enable-header-color','=','1'),
                'title' => __('Header Dropdown Separator Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Separator Color for Dropdown menu list.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#2F2F2F'
            ),

            // Custom Mobile Header Colors
            array(
                'id'=>'enable-mobile-color',
                'type' => 'switch', 
                'title' => __('Custom Mobile Dropdown Colors?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom colors for mobile header?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            array(
                'id' => 'mobile-dropdown-background',
                'type' => 'color',
                'required' => array('enable-mobile-color','=','1'),
                'title' => __('Mobile Dropdown Background', 'redux-framework-demo'),
                'subtitle' => __('Choose a Background Color for Mobile Dropdown.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#252728'
            ),
            array(
                'id' => 'mobile-dropdown-font-color',
                'type' => 'color',
                'required' => array('enable-mobile-color','=','1'),
                'title' => __('Mobile Dropdown Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Font Color for Mobile Dropdown.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#818B92'
            ),
            array(
                'id' => 'mobile-dropdown-font-color-hover',
                'type' => 'color',
                'required' => array('enable-mobile-color','=','1'),
                'title' => __('Mobile Dropdown Hover Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Hover Font Color for Mobile Dropdown.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#FFFFFF'
            ),
            array(
                'id' => 'mobile-dropdown-separator-color',
                'type' => 'color',
                'required' => array('enable-mobile-color','=','1'),
                'title' => __('Mobile Dropdown Separator Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Separator Color for Mobile Dropdown Menu List.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#2F2F2F'
            ),
            array(
                'id' => 'mobile-dropdown-icon-color',
                'type' => 'color',
                'required' => array('enable-mobile-color','=','1'),
                'title' => __('Mobile Dropdown Icon Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Icon Color for Mobile Dropdown Menu List.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#444444'
            ),

            // Custom Typography Colors
            array(
                'id'=>'enable-typography-color',
                'type' => 'switch', 
                'title' => __('Custom Typography Colors?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom colors for typography?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            array(
                'id' => 'body-typo-color',
                'type' => 'color',
                'required' => array('enable-typography-color','=','1'),
                'title' => __('Body Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Color for Body.<br/><br/>
                                  <em>(i.e. body, shortcodes etc.)</em>', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#818B92'
            ),
            array(
                'id' => 'heading-typo-color',
                'type' => 'color',
                'required' => array('enable-typography-color','=','1'),
                'title' => __('Heading Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Color for Heading.<br/><br/>
                                  <em>(i.e. headings, shortcodes etc.)</em>', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#2D3C48'
            ),

            // Custom Back to Top Colors
            array(
                'id'=>'enable-back-top-color',
                'type' => 'switch', 
                'title' => __('Custom Back To Top Colors?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom colors for back to top?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            array(
                'id' => 'back-top-background',
                'type' => 'color',
                'required' => array('enable-back-top-color','=','1'),
                'title' => __('Back To Top Background', 'redux-framework-demo'),
                'subtitle' => __('Choose a Background for Back To Top.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#171717'
            ),
            array(
                'id' => 'back-top-color',
                'type' => 'color',
                'required' => array('enable-back-top-color','=','1'),
                'title' => __('Back To Top Icon Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Color for Icon Back To Top.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#FFFFFF'
            ),

            // Custom Footer Colors
            array(
                'id'=>'enable-footer-color',
                'type' => 'switch', 
                'title' => __('Custom Footer Colors?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom colors for footer?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            array(
                'id' => 'footer-widget-background',
                'type' => 'color',
                'required' => array('enable-footer-color','=','1'),
                'title' => __('Footer Widget Background', 'redux-framework-demo'),
                'subtitle' => __('Choose a Background for Footer Widget.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#222222'
            ),
            array(
                'id' => 'footer-widget-heading-color',
                'type' => 'color',
                'required' => array('enable-footer-color','=','1'),
                'title' => __('Footer Widget Heading Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Heading Font Color for Footer Widget Area.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#717580'
            ),
            array(
                'id' => 'footer-widget-font-color',
                'type' => 'color',
                'required' => array('enable-footer-color','=','1'),
                'title' => __('Footer Widget Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Font Color for Footer Widget Area.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#FFFFFF'
            ),
            array(
                'id' => 'footer-credits-background',
                'type' => 'color',
                'required' => array('enable-footer-color','=','1'),
                'title' => __('Footer Credits Background', 'redux-framework-demo'),
                'subtitle' => __('Choose a Background for Footer Credits Area.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#121212'
            ),
            array(
                'id' => 'footer-credits-font-color',
                'type' => 'color',
                'required' => array('enable-footer-color','=','1'),
                'title' => __('Footer Credits Font Color', 'redux-framework-demo'),
                'subtitle' => __('Choose a Font Color for Footer Credits Area.', 'redux-framework-demo'),
                'desc' => '',
                'default' => '#FFFFFF'
            ),
        )
    );

	// Typography Options
	$sections[] = array(
		'title' => __('Typography Options', 'redux-framework-demo'),
		'desc' => __('Control and configure the typography of your theme.', 'redux-framework-demo'),
		'icon_class' => 'icon-large',
        'icon' => 'home',
		'fields' => array(
			array(
				'id'=>'enable-custom-fonts',
				'type' => 'switch', 
				'title' => __('Use Custom Fonts?', 'redux-framework-demo'),
				'subtitle' => __('Do you want enable custom fonts features?.', 'redux-framework-demo'),
				'desc'=> '',
				'default' => 0
			),
            // Header Fonts
            array(
                'id'=>'enable-header-fonts',
                'type' => 'switch',
                'required' => array('enable-custom-fonts','=','1'), 
                'title' => __('Use Header Custom Fonts?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom fonts for header?.', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            // Logo
			array(
                'id' => 'logo-font',
                'type' => 'typography',
                'required' => array('enable-header-fonts','=','1'), 
                'title' => __('Logo Font', 'redux-framework-demo'),
                'subtitle' => __('Select the font for logo.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'line-height'=>false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '42px',
                    'font-style' => 'normal',
                    'font-weight' => '600',
                    'letter-spacing' => '-2'
                ),
            ),
            // Menu
            array(
                'id' => 'menu-font',
                'type' => 'typography',
                'required' => array('enable-header-fonts','=','1'), 
                'title' => __('Header Menu Font', 'redux-framework-demo'),
                'subtitle' => __('Select the font for header menu.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'line-height'=>false,
                'font-style' => true,
                'font-weight' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '14px',
                    'font-style' => 'normal',
                    'font-weight' => '400'
                ),
            ),
            // Dropdown Menu
            array(
                'id' => 'dropdown-menu-font',
                'type' => 'typography',
                'required' => array('enable-header-fonts','=','1'),
                'title' => __('Dropdown Menu Font', 'redux-framework-demo'),
                'subtitle' => __('Select the font for dropdown menu.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'line-height'=>false,
                'font-style' => true,
                'font-weight' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '13px',
                    'font-style' => 'normal',
                    'font-weight' => '400'
                ),
            ),
            // Mobile Menu
            array(
                'id' => 'mobile-menu-font',
                'type' => 'typography',
                'required' => array('enable-header-fonts','=','1'), 
                'title' => __('Mobile Menu Font', 'redux-framework-demo'),
                'subtitle' => __('Select the font for dropdown menu.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'line-height'=>false,
                'font-style' => true,
                'font-weight' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '13px',
                    'font-style' => 'normal',
                    'font-weight' => '400'
                ),
            ),
            // Body Fonts
            array(
                'id'=>'enable-body-fonts',
                'type' => 'switch',
                'required' => array('enable-custom-fonts','=','1'), 
                'title' => __('Use Body Custom Fonts?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom fonts for body?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            // Body
            array(
				'id' => 'body-font',
				'type' => 'typography',
				'required' => array('enable-body-fonts','=','1'),	
				'title' => __('Body Font', 'redux-framework-demo'),
				'subtitle' => __('Select the font for body.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em>', 'redux-framework-demo'),
				'compiler' => false,
				'google' => true,
				'font-backup' => false,
				'font-style' => true,
				'font-weight' => true,
				'subset' => true,
                'color' => false,
				'preview' => true,
				'units' => 'px',
				'default' => array(
					'font-family' => 'Muli',
					'font-size' => '14px',
					'font-style' => 'normal',
					'font-weight' => '300',
					'line-height' => '24'
				),
			),
            // Headings Fonts
            array(
                'id'=>'enable-headings-fonts',
                'type' => 'switch',
                'required' => array('enable-custom-fonts','=','1'), 
                'title' => __('Use Heading Custom Fonts?', 'redux-framework-demo'),
                'subtitle' => __('Do you want enable custom fonts for heading?', 'redux-framework-demo'),
                'desc'=> '',
                'default' => 0
            ),
            // Page Header and Caption
			array(
                'id' => 'pageheader-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'),   
                'title' => __('Page Header Font', 'redux-framework-demo'),
                'subtitle' => __('Select the font for page header.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '42px',
                    'font-style' => 'normal',
                    'font-weight' => '600',
                    'line-height' => '54',
                    'letter-spacing' => '-2'
                ),
            ),
            array(
                'id' => 'pagecaption-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'),   
                'title' => __('Page Header Caption Font', 'redux-framework-demo'),
                'subtitle' => __('Select the font for page header caption.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '28px',
                    'font-style' => 'italic',
                    'font-weight' => '300',
                    'line-height' => '39',
                    'letter-spacing' => '-1'
                ),
            ),
            // Headings 
            array(
				'id' => 'heading1-font',
				'type' => 'typography',
				'required' => array('enable-headings-fonts','=','1'),	
				'title' => __('Heading Font - H1', 'redux-framework-demo'),
				'subtitle' => __('Select the font for H1.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
				'compiler' => false,
				'google' => true,
				'font-backup' => false,
				'font-style' => true,
				'font-weight' => true,
                'letter-spacing' => true,
				'subset' => true,
                'color' => false,
				'preview' => true,
				'units' => 'px',
				'default' => array(
					'font-family' => 'Source Sans Pro',
					'font-size' => '32px',
					'font-style' => 'normal',
					'font-weight' => '400',
					'line-height' => '48',
                    'letter-spacing' => '-1'
				),
			),
            array(
                'id' => 'heading2-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'), 
                'title' => __('Heading Font - H2', 'redux-framework-demo'),
                'subtitle' => __('Select the font for H2.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '28px',
                    'font-style' => 'normal',
                    'font-weight' => '400',
                    'line-height' => '42',
                    'letter-spacing' => '-1'
                ),
            ),
            array(
                'id' => 'heading3-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'), 
                'title' => __('Heading Font - H3', 'redux-framework-demo'),
                'subtitle' => __('Select the font for H3.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '24px',
                    'font-style' => 'normal',
                    'font-weight' => '400',
                    'line-height' => '36',
                    'letter-spacing' => '-1'
                ),
            ),
            array(
                'id' => 'heading4-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'), 
                'title' => __('Heading Font - H4', 'redux-framework-demo'),
                'subtitle' => __('Select the font for H4.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '20px',
                    'font-style' => 'normal',
                    'font-weight' => '400',
                    'line-height' => '30',
                    'letter-spacing' => '-1'
                ),
            ),
            array(
                'id' => 'heading5-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'), 
                'title' => __('Heading Font - H5', 'redux-framework-demo'),
                'subtitle' => __('Select the font for H5.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '18px',
                    'font-style' => 'normal',
                    'font-weight' => '400',
                    'line-height' => '27',
                    'letter-spacing' => '-1'
                ),
            ),
            array(
                'id' => 'heading6-font',
                'type' => 'typography',
                'required' => array('enable-headings-fonts','=','1'), 
                'title' => __('Heading Font - H6', 'redux-framework-demo'),
                'subtitle' => __('Select the font for H6.<br/>
                                  <em>Font Family</em><br/>
                                  <em>Font Weight - Font Style</em><br/>
                                  <em>Subset</em><br/>
                                  <em>Font Size</em><br/>
                                  <em>Line Height</em><br/>
                                  <em>Letter Spacing</em>', 'redux-framework-demo'),
                'compiler' => false,
                'google' => true,
                'font-backup' => false,
                'font-style' => true,
                'font-weight' => true,
                'letter-spacing' => true,
                'subset' => true,
                'color' => false,
                'preview' => true,
                'units' => 'px',
                'default' => array(
                    'font-family' => 'Source Sans Pro',
                    'font-size' => '16px',
                    'font-style' => 'normal',
                    'font-weight' => '400',
                    'line-height' => '24',
                    'letter-spacing' => '-1'
                ),
            )
		)
	);
	
	// Boxed Layout Options
	$sections[] = array(
		'title' => __('Boxed Layout Options', 'redux-framework-demo'),
		'desc' => __('Control and configure the general setup of your boxed layout.', 'redux-framework-demo'),
		'icon_class' => 'icon-large',
        'icon' => 'home',
		'fields' => array(
			array(
				'id' => 'enable-boxed-layout',
				'type' => 'switch',
				'title' => __('Enable Boxed Layout?', 'redux-framework-demo'),
				'subtitle' => __('Do you enable boxed layout?', 'redux-framework-demo'),
				'desc' => '',
				'default' => 0
			),
			array(
				'id'=>'boxed-background-color',
				'type' => 'color', 
				'required' => array('enable-boxed-layout','=','1'),						
				'title' => __('Background Color', 'redux-framework-demo'),
				'subtitle'=> __('If you would rather simply use a solid color for your background, select one here.', 'redux-framework-demo'),
				'desc' => '',
				'default' => '#AEAEAE'
			),
			array(
                'id' => 'boxed-background-image',
                'type' => 'media',
                'required' => array('enable-boxed-layout','=','1'),	
                'title' => __('Background Image', 'redux-framework-demo'), 
                'subtitle' => __('Upload your background here. You can find sample elements here:<br/><br/>
                                  <em>/_include/img/sample_bg_images/</em><br/>
                                  <em>/_include/img/sample_patterns/</em>', 'redux-framework-demo'),
                'desc' => ''
            ),
            array(
                'id' => 'boxed-background-repeat',
                'type' => 'select',
                'required' => array('enable-boxed-layout','=','1'),	
                'title' => __('Background Repeat', 'redux-framework-demo'), 
                'subtitle' => __('Do you want your background to repeat? (Turn on when using patterns)', 'redux-framework-demo'),
                'desc' => '',
                'options' => array(
                	'no-repeat'=>'No-Repeat', 
                	'repeat'=>'Repeat'
                ),
				'default' => 'no-repeat'
            ),
            array(
                'id' => 'boxed-background-position', 
                'type' => 'select',
                'required' => array('enable-boxed-layout','=','1'), 
                'title' => __('Background Position', 'redux-framework-demo'),
                'subtitle' => __('How would you like your background image to be aligned?', 'redux-framework-demo'),
                'options' => array(
                     'left top' => 'Left Top',
                     'left center' => 'Left Center',
                     'left bottom' => 'Left Bottom',
                     'center top' => 'Center Top',
                     'center center' => 'Center Center',
                     'center bottom' => 'Center Bottom',
                     'right top' => 'Right Top',
                     'right center' => 'Right Center',
                     'right bottom' => 'Right Bottom'
                ),
                'default' => 'left top'
            ),
            array(
                'id' => 'boxed-background-attachment', 
                'type' => 'select',
                'required' => array('enable-boxed-layout','=','1'), 
                'title' => __('Background Attachment', 'redux-framework-demo'),
                'subtitle' => __('Would you prefer your background to scroll with your site or be fixed and not move', 'redux-framework-demo'),
                'options' => array(
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed'
                ),
                'default' => 'scroll'
            ),
			array(
                'id' => 'boxed-background-cover',
                'type' => 'switch',
                'required' => array('enable-boxed-layout','=','1'),
                'title' => __('Auto resize background image to fit window?', 'redux-framework-demo'), 
                'subtitle' => __('This will ensure your background image always fits no matter what size screen the user has. (Don\'t use with patterns)', 'redux-framework-demo'),
                'desc' => '',
                'default' => 0
            ),
		)
	);
	
	// Header Options
	$sections[] = array(
        'title' => __('Header Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your header.', 'redux-framework-demo'),
		'icon_class' => 'icon-large',
		'icon' => 'cogs',
		'fields' => array(
			array(
                'id' => 'use-logo',
                'type' => 'switch',
                'title' => __('Use Image for Logo?', 'redux-framework-demo'), 
                'subtitle' => __('Upload a logo for your theme.<br/> Otherwise you will see the Plain Text Logo.', 'redux-framework-demo'),
                'desc' => '',
				'default' => 0
            ),
            array(
                'id' => 'logo',
                'type' => 'media',
                'required' => array('use-logo','=','1'),	
                'title' => __('Logo Upload', 'redux-framework-demo'), 
                'subtitle' => __('Upload your logo.', 'redux-framework-demo'),
                'desc' => ''  
            ),
            array(
                'id' => 'retina-logo',
                'type' => 'media',
                'required' => array('use-logo','=','1'),
                'title' => __('Retina Logo Upload', 'redux-framework-demo'), 
                'subtitle' => __('Upload your Retina Logo for Retina Devices.', 'redux-framework-demo'),
                'desc' => ''  
            ),
            array(
                'id' => 'header-layout',
                'type' => 'select',
                'title' => __('Header Layout', 'redux-framework-demo'), 
                'subtitle' => __('Please select your header layout.', 'redux-framework-demo'),
                'desc' => '',
                'options' => array(
                	'normal-header' => 'Normal Header',
                	'sticky-header' => 'Sticky Header'
                ),
				'default' => 'normal-header'
            )
		)
	);

	// Footer Options
	$sections[] = array(
        'title' => __('Footer Options', 'redux-framework-demo'),
        'desc' => __('Control and configure of your footer area.', 'redux-framework-demo'),
		'icon_class' => 'icon-large',
		'icon' => 'edit',
        'fields' => array(
        	array(
				'id' => 'footer-widget-columns',
				'type' => 'image_select',
				'title' => __('Footer Widget Area Columns', 'redux-framework-demo'), 
				'subtitle' => __('Select the columns for footer widget area.', 'redux-framework-demo'),
				'desc' => '',
				'options' => array(
					'2' => array('title' => '2 Columns', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/2col.png'),
					'3' => array('title' => '3 Columns', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/3col.png'),
					'4' => array('title' => '4 Columns', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/4col.png')
				),
				'default' => '3'
			),   
			array(
                'id' => 'enable-footer-social-area',
                'type' => 'switch',
                'title' => __('Footer Social Area', 'redux-framework-demo'), 
                'subtitle' => __('Do you want enable social profiles?<br/>You can set your social profile in <b>Social Options Tabs</b>.', 'redux-framework-demo'),
                'desc' => '',
				'default' => 0
            ),
			array(
                'id' => 'footer-copyright-text',
                'type' => 'textarea',
                'title' => __('Footer Copyright Section Text', 'redux-framework-demo'), 
                'subtitle' => __('Please enter the copyright section text.<br/><br/><em>HTML is allowed.</em>', 'redux-framework-demo'),
                'desc' => '',
                'validate' => 'html'
            )
        )
    );

	// Portfolio Options
	$sections[] = array(
        'title' => __('Portfolio Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your portfolio.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'folder-open-alt',
        'fields' => array( 
			array(
                'id' => 'enable-comment-portfolio-area',
                'type' => 'switch',
                'title' => __('Enable Comments Template on Single Portfolio Post?', 'redux-framework-demo'), 
                'subtitle' => __('Enable/Disable Comments Template.', 'redux-framework-demo'),
                'desc' => '',
                'default' => 0
            ),
			array(
				'id' => 'portfolio_rewrite_slug', 
				'type' => 'text', 
				'title' => __('Custom Slug', 'redux-framework-demo'),
				'subtitle' => __('If you want your portfolio post type to have a custom slug in the url, please enter it here. <br/><br/>
								 <b>You will still have to refresh your permalinks after saving this!</b><br/><br/>
								 This is done by going to <b>Settings -> Permalinks</b> and clicking save.', 'redux-framework-demo'),
				'desc' => ''
			)                          
        )
    );

	// Team Options
	$sections[] = array(
        'title' => __('Team Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your team.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'folder-open-alt',
        'fields' => array( 
			array(
                'id' => 'enable-comment-team-area',
                'type' => 'switch',
                'title' => __('Enable Comments Template on Single Team Post?', 'redux-framework-demo'), 
                'subtitle' => __('Enable/Disable Comments Template.', 'redux-framework-demo'),
                'desc' => '',
                'default' => 0
            ),
			array(
				'id' => 'team_rewrite_slug', 
				'type' => 'text', 
				'title' => __('Custom Slug', 'redux-framework-demo'),
				'subtitle' => __('If you want your team post type to have a custom slug in the url, please enter it here.<br/><br/>
								 <b>You will still have to refresh your permalinks after saving this!</b><br/><br/>
								 This is done by going to <b>Settings -> Permalinks</b> and clicking save.', 'redux-framework-demo'),
				'desc' => ''
			)                          
        )
    );

	// Blog Options
	$sections[] = array(
        'title' => __('Blog Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your blog.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'edit',
        'fields' => array(
            array(
                'id' => 'blog-social',
                'type' => 'switch',
                'title' => __('Social Media Sharing Buttons', 'redux-framework-demo'), 
                'subtitle' => __('Activate this to enable social sharing buttons on your blog posts.', 'redux-framework-demo'),
                'desc' => '',
                'default' => 0
            ),  
             array(
                'id' => 'blog-facebook-sharing',
                'type' => 'checkbox',
                'required' => array('blog-social','=','1'),
                'title' => __('Facebook', 'redux-framework-demo'), 
                'subtitle' => 'Share it.',
                'desc' => '',
                'default' => '1'
            ),
            array(
                'id' => 'blog-twitter-sharing',
                'type' => 'checkbox',
                'required' => array('blog-social','=','1'),
                'title' => __('Twitter', 'redux-framework-demo'), 
                'subtitle' => 'Tweet it.',
                'desc' => '',
                'default' => '1'
            ),
            array(
                'id' => 'blog-google-sharing',
                'type' => 'checkbox',
                'required' => array('blog-social','=','1'),
                'title' => __('Google Plus', 'redux-framework-demo'), 
                'subtitle' => 'Google it.',
                'desc' => '',
                'default' => '1'
            ),
            array(
                'id' => 'blog-pinterest-sharing',
                'type' => 'checkbox',
                'required' => array('blog-social','=','1'),
                'title' => __('Pinterest', 'redux-framework-demo'), 
                'subtitle' => 'Pin it.',
                'desc' => '',
                'default' => '1'
            ),

			array(
				'id' => 'blog_type',
				'type' => 'select',
				'title' => __('Blog Type', 'redux-framework-demo'), 
				'subtitle' => __('Please select your blog format here.', 'redux-framework-demo'),
				'desc' => '',
				'options' => array(
					'standard-blog' => 'Standard Blog',
					'masonry-blog' => 'Masonry Blog',
                    'center-blog' => 'Center Blog'
				),
				'default' => 'standard-blog'
			),
			array(
				'id' => 'blog_sidebar_layout',
				'type' => 'image_select',
				'required' => array('blog_type','=','standard-blog'),
				'title' => __('Standard Blog Layout', 'redux-framework-demo'), 
				'subtitle' => __('Select main content and sidebar alignment.', 'redux-framework-demo'),
				'desc' => '',
				'options' => array(
					'no_side' => array('title' => 'No Sidebar', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/no_side.png'),
					'left_side' => array('title' => 'Left Sidebar', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/left_side.png'),
					'right_side' => array('title' => 'Right Sidebar', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/right_side.png')
				),
				'default' => 'right_side'
			),
			array(
				'id' => 'masonry_layout',
				'type' => 'image_select',
				'required' => array('blog_type','=','masonry-blog'),
				'title' => __('Masonry Blog Layout', 'redux-framework-demo'), 
				'subtitle' => __('Select the column for masonry blog.', 'redux-framework-demo'),
				'desc' => '',
				'options' => array(
					'2' => array('title' => '2 Columns', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/2col.png'),
					'3' => array('title' => '3 Columns', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/3col.png'),
					'4' => array('title' => '4 Columns', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/4col.png')
				),
				'default' => '3'
			),
			array(
				'id' => 'blog_post_sidebar_layout',
				'type' => 'image_select',
				'title' => __('Single Post Blog Layout', 'redux-framework-demo'), 
				'subtitle' => __('Select main content and sidebar alignment for single post.', 'redux-framework-demo'),
				'desc' => '',
				'options' => array(
					'no_side' => array('title' => 'No Sidebar', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/no_side.png'),
					'left_side' => array('title' => 'Left Sidebar', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/left_side.png'),
					'right_side' => array('title' => 'Right Sidebar', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/right_side.png'),
                    'center_side' => array('title' => 'No Sidebar - Center Layout', 'img' => AZ_FRAMEWORK_DIRECTORY.'options/assets/img/center_side.png')
				),
				'default' => 'right_side'
			)
        )
    );
	
	// 404 Options
    $sections[] = array(
        'title' => __('404 Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your 404 page.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'map-marker',
        'fields' => array(
            array(
                'id' => '404-img',
                'type' => 'media',
                'title' => __('Background Image Upload', 'redux-framework-demo'), 
                'subtitle' => __('Please upload an image that will be used for background image.', 'redux-framework-demo'),
                'desc' => ''
            ),
            array(
                'id' => '404-title',
                'type' => 'text',
                'title' => __('Insert your 404 Title', 'redux-framework-demo'), 
                'subtitle' => __('Please Enter here your title for 404 Page.<br/><br/>
                                  <em>HTML is allowed.</em>', 'redux-framework-demo'),
                'desc' => ''
            ),
            array(
                'id' => '404-caption',
                'type' => 'textarea',
                'title' => __('Insert your 404 Caption', 'redux-framework-demo'), 
                'subtitle' => __('Please Enter here your caption for 404 Page.<br/><br/>
                                  <em>HTML is allowed.</em>', 'redux-framework-demo'),
                'desc' => ''
            )     
        )
    );

    // Contact Map Options
	$sections[] = array(
        'title' => __('Contact Map Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your contact and map page.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'map-marker',
        'fields' => array(
			array(
				'id' => 'title-marker',
				'type' => 'text',
				'title' => __('Insert your Title Marker', 'redux-framework-demo'), 
				'subtitle' => __('Please Enter here your text of Title Marker.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'zoom-level',
				'type' => 'text',
				'title' => __('Default Map Zoom Level', 'redux-framework-demo'), 
				'subtitle' => __('Value should be between 1-18, 1 being the entire earth and 18 being right at street level.', 'redux-framework-demo'),
				'desc' => '',
				'validate' => 'numeric'
			),
			array(
				'id' => 'center-lat',
				'type' => 'text',
				'title' => __('Map Center Latitude', 'redux-framework-demo'), 
				'subtitle' => __('Please enter the latitude for the maps center point.', 'redux-framework-demo'),
				'desc' => '',
				'validate' => 'numeric'
			),
			array(
				'id' => 'center-lng',
				'type' => 'text',
				'title' => __('Map Center Longitude', 'redux-framework-demo'), 
				'sub_desc' => __('Please enter the longitude for the maps center point.', 'redux-framework-demo'),
				'desc' => '',
				'validate' => 'numeric'
			),
			array(
				'id' => 'marker-img',
				'type' => 'media',
				'title' => __('Marker Icon Upload', 'redux-framework-demo'), 
				'subtitle' => __('Please upload an image that will be used for the marker on your map.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'map-info',
				'type' => 'textarea',
				'title' => __('Map Infowindow Text', 'redux-framework-demo'), 
				'subtitle' => __('If you would like to display any text in an info window for location, please enter it here.<br/><br/>
								  <em>HTML is allowed.</em>', 'redux-framework-demo'),
				'desc' => ''
			)		
        )
    );

	// Social Options
	$sections[] = array(
        'title' => __('Social Options', 'redux-framework-demo'),
        'desc' => __('Control and configure the general setup of your social profile. <br/>Will be visible in the footer area (if enabled) and the social profile widget.', 'redux-framework-demo'),
        'icon_class' => 'icon-large',
        'icon' => 'twitter',
        'fields' => array(
			array(
				'id' => '500px-url', 
				'type' => 'text', 
				'title' => __('500PX URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your 500PX URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'addthis-url', 
				'type' => 'text', 
				'title' => __('Add This URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Add This URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'behance-url', 
				'type' => 'text', 
				'title' => __('Behance URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Behance URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'bebo-url', 
				'type' => 'text', 
				'title' => __('Bebo URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Bebo URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'blogger-url', 
				'type' => 'text', 
				'title' => __('Blogger URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Blogger URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'deviant-art-url', 
				'type' => 'text', 
				'title' => __('Deviant Art URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Deviant Art URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'digg-url', 
				'type' => 'text', 
				'title' => __('Digg URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Digg URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'dribbble-url', 
				'type' => 'text', 
				'title' => __('Dribbble URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Dribbble URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'email-url', 
				'type' => 'text', 
				'title' => __('Email URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Email URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'envato-url', 
				'type' => 'text', 
				'title' => __('Envato URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Envato URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'evernote-url', 
				'type' => 'text', 
				'title' => __('Evernote URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Envernote URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'facebook-url', 
				'type' => 'text', 
				'title' => __('Facebook URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Facebook URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'flickr-url', 
				'type' => 'text', 
				'title' => __('Flickr URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Flickr URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'forrst-url', 
				'type' => 'text', 
				'title' => __('Forrst URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Forrst URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'github-url', 
				'type' => 'text', 
				'title' => __('Github URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Github URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'google-plus-url', 
				'type' => 'text', 
				'title' => __('Google Plus URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Google Plus URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'grooveshark-url', 
				'type' => 'text', 
				'title' => __('Grooveshark URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Grooveshark URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'instagram-url', 
				'type' => 'text', 
				'title' => __('Instagram URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Instagram URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'last-fm-url', 
				'type' => 'text', 
				'title' => __('Last FM URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Last FM URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'linkedin-url', 
				'type' => 'text', 
				'title' => __('Linked In URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Linked In URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'myspace-url', 
				'type' => 'text', 
				'title' => __('My Space URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your My Space URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'paypal-url', 
				'type' => 'text', 
				'title' => __('Paypal URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Paypal URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'photobucket-url', 
				'type' => 'text', 
				'title' => __('Photobucket URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Photobucket URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'pinterest-url', 
				'type' => 'text', 
				'title' => __('Pinterest URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Pinterest URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'quora-url', 
				'type' => 'text', 
				'title' => __('Quora URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Quora URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'share-this-url', 
				'type' => 'text', 
				'title' => __('Share This URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Share This URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'skype-url', 
				'type' => 'text', 
				'title' => __('Skype URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Skype URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'soundcloud-url', 
				'type' => 'text', 
				'title' => __('Soundcloud URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Soundcloud URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'stumbleupon-url', 
				'type' => 'text', 
				'title' => __('Stumble Upon URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Stumble Upon URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'tumblr-url', 
				'type' => 'text', 
				'title' => __('Tumblr URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Tumblr URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'twitter-url', 
				'type' => 'text', 
				'title' => __('Twitter URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Twitter URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'viddler-url', 
				'type' => 'text', 
				'title' => __('Viddler URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Viddler URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'vimeo-url', 
				'type' => 'text', 
				'title' => __('Vimeo URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Vimeo URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'virb-url', 
				'type' => 'text', 
				'title' => __('Virb URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Virb URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'wordpress-url', 
				'type' => 'text', 
				'title' => __('Wordpress URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Wordpress URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'yahoo-url', 
				'type' => 'text', 
				'title' => __('Yahoo URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Yahoo URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'yelp-url', 
				'type' => 'text', 
				'title' => __('Yelp URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Yelp URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'youtube-url', 
				'type' => 'text', 
				'title' => __('You Tube URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your You Tube URL.', 'redux-framework-demo'),
				'desc' => ''
			),
			array(
				'id' => 'zerply-url', 
				'type' => 'text', 
				'title' => __('Zerply URL', 'redux-framework-demo'),
				'subtitle' => __('Please enter in your Zerply URL.', 'redux-framework-demo'),
				'desc' => ''
			)
        )
    );
		
	$tabs = array();

	if (function_exists('wp_get_theme')){
	$theme_data = wp_get_theme();
	$theme_uri = $theme_data->get('ThemeURI');
	$description = $theme_data->get('Description');
	$author = $theme_data->get('Author');
	$version = $theme_data->get('Version');
	$tags = $theme_data->get('Tags');
	}else{
	$theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()).'style.css');
	$theme_uri = $theme_data['URI'];
	$description = $theme_data['Description'];
	$author = $theme_data['Author'];
	$version = $theme_data['Version'];
	$tags = $theme_data['Tags'];
	}	

	// Theme Info
	$theme_info = '<div class="redux-framework-section-desc">';
	$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'redux-framework-demo').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'redux-framework-demo').$author.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'redux-framework-demo').$version.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'redux-framework-demo').implode(', ', $tags).'</p>';
	$theme_info .= '</div>';

	// Documentation
    /*
	$item_info .= '<div class="redux-framework-section-desc">';
	$item_info .= '<h3>'.__('Documentation', 'redux-framework-demo').'</h3>';
	$item_info .= '<p class="redux-opts-item-data">' . __('You can find the high quality version of documentation inside the package. For view this docs you have to be logged in a google account.', 'redux-framework-demo') . '</p>';
	$item_info .= '<iframe src="http://docs.google.com/gview?url=themes.alessioatzeni.com/docs/klaus-documentation.pdf&embedded=true" style="width:100%; height:800px;" frameborder="0"></iframe>';
    $item_info .= '</div>';
    */
    
	if(file_exists(dirname(__FILE__).'/README.md')){
	$tabs['theme_docs'] = array(
				'icon' => REDUX_URL.'assets/img/glyphicons/glyphicons_071_book.png',
				'title' => __('Documentation', 'redux-framework-demo'),
				'content' => file_get_contents(dirname(__FILE__).'/README.md')
				);
	}//if

    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => 'icon-large',
        'title' => __('Theme Information', 'redux-framework-demo'),
        'content' => $item_info
    );
    /*
    if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
        $tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
            'title' => __('Documentation', 'redux-framework-demo'),
            'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
        );
    }*/

    global $ReduxFramework;
    $ReduxFramework = new ReduxFramework($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);


/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/*
	This is a test function that will let you see when the compiler hook occurs. 
	It only runs if a field	set with compiler=>true is changed.
*/
function testCompiler() {
	//echo "Compiler hook!";
}
add_action('redux-compiler-redux-sample-file', 'testCompiler');



/*
	Use this function to hide the activation notice telling users about a sample panel.
*/
function removeReduxAdminNotice() {
	delete_option('REDUX_FRAMEWORK_PLUGIN_ACTIVATED_NOTICES');
}
add_action('redux_framework_plugin_admin_notice', 'removeReduxAdminNotice');
