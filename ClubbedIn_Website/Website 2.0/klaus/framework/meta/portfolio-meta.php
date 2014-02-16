<?php

/*-----------------------------------------------------------------------------------*/
/*	Portfolio Meta
/*-----------------------------------------------------------------------------------*/


add_action('add_meta_boxes', 'az_metabox_portfolio');
function az_metabox_portfolio(){
    
	
/*-----------------------------------------------------------------------------------*/
/*	Thumbnails Setting
/*-----------------------------------------------------------------------------------*/

	$meta_box = array(
		'id' => 'az-metabox-portfolio-settings',
		'title' =>  __('Portfolio Item Settings', AZ_THEME_NAME),
		'description' => __('Here you can configure how your portfolio item appear.', AZ_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		array( 
				'name' => __('FancyBox Gallery Name (Optional)', AZ_THEME_NAME),
				'desc' => __('Please enter gallery name if you want create a gallery images/video between portfolio posts.', AZ_THEME_NAME),
				'id' => '_az_fancy_gallery',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('FancyBox PopUp Video (Optional)', AZ_THEME_NAME),
				'desc' => __('Please enter Video URL instead of Featured Image.', AZ_THEME_NAME),
				'id' => '_az_fancy_video',
				'type' => 'text',
				'std' => ''
			),
			array( 
				'name' => __('FancyBox Image PopUp (Optional)', AZ_THEME_NAME),
				'desc' => __('Please upload Image if you want a different image instead of Featured Image PopUp.', AZ_THEME_NAME),
				'id' => '_az_fancy_image_full',
				'type' => 'file',
				'std' => ''
			),
			array( 
				'name' => __('FancyBox Gallery Images (Optional)', AZ_THEME_NAME),
				'desc' => __('Please upload Images if you want a gallery images for this post.', AZ_THEME_NAME),
				'id' => '_az_fancy_image_gallery',
				'type' => 'images',
				'std' => ''
			),
		)
	);
	
	$callback = create_function( '$post,$meta_box', 'az_create_meta_box( $post, $meta_box["args"] );' );
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	

/*-----------------------------------------------------------------------------------*/
/*	Page Portfolio Header Setting Meta
/*-----------------------------------------------------------------------------------*/

global $wpdb;
  $rs = $wpdb->get_results( 
  	"
  	SELECT id, title, alias
  	FROM ".$wpdb->prefix."revslider_sliders
  	ORDER BY id ASC LIMIT 100
  	"
  );
  $revsliders = array();
  if ($rs) {
    foreach ( $rs as $slider ) {
      $revsliders[$slider->alias] = $slider->alias;
    }
  } else {
    $revsliders["No sliders found"] = 0;
  }

    $meta_box = array(
		'id' => 'az-metabox-page-header',
		'title' => __('Portfolio Page Header Settings', AZ_THEME_NAME),
		'description' => __('Here you can configure how your page header will appear.', AZ_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('Portfolio Page Header Settings', AZ_THEME_NAME),
					'desc' => __('Enable or Disable the Header Page Settings.', AZ_THEME_NAME),
					'id' => '_az_header_settings',
					'type' => 'select',
					'std' => 'enabled',
					'options' => array(
						"enabled" => "Enabled",
						"disabled" => "Disabled"
					)
				),
			array( 
					'name' => __('Portfolio Page Header Height', AZ_THEME_NAME),
					'desc' => __('Optional. Enter a number for your height (padding-top and padding-bottom) of page header. Default 100.<br/>
								  <strong>Not works if you use a slider</strong>.', AZ_THEME_NAME),
					'id' => '_az_header_height',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Page Header Image', AZ_THEME_NAME),
					'desc' => __('Upload your image should be between 1600px x 800px (or more) for best results.', AZ_THEME_NAME),
					'id' => '_az_header_bg',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Page Header Image Overlay', AZ_THEME_NAME),
					'desc' => __('Enable or Disable Overlay Background.', AZ_THEME_NAME),
					'id' => '_az_header_overlay',
					'type' => 'checkbox_fade',
					'std' => 'on'
				),
			array( 
					'name' => __('Portfolio Page Header Backgroun Opacity Overlay', AZ_THEME_NAME),
					'desc' => __('Optional. Enter a number 0 - 1 for your background color opacity. Default 0.70', AZ_THEME_NAME),
					'id' => '_az_header_overlay_bg_opacity',
					'type' => 'opacity',
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Page Header Background Color Overlay', AZ_THEME_NAME),
					'desc' => __('Optional. Choose a background color overlay for your title block.', AZ_THEME_NAME),
					'id' => '_az_header_overlay_bg_color',
					'type' => 'color',
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Page Header Image Background Attachment', AZ_THEME_NAME),
					'desc' => __('Background Image Attachment.', AZ_THEME_NAME),
					'id' => '_az_header_bg_attachment',
					'type' => 'select',
					'std' => 'fixed',
					'options' => array(
						"scroll" => "Scroll",
						"fixed" => "Fixed"
					)
				),
			array( 
					'name' => __('Revolution Slider Alias', AZ_THEME_NAME),
					'desc' => __('Select your Revolution Slider Alias for the slider that you want to show.', AZ_THEME_NAME),
					'id' => '_az_intro_slider_header',
					'type' => 'select_slider',
					'options' => $revsliders,
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Header Text', AZ_THEME_NAME),
					'desc' => __('Enable or Disable the Header Portfolio Text.', AZ_THEME_NAME),
					'id' => '_az_header_text',
					'type' => 'select',
					'std' => 'enabled',
					'options' => array(
						"enabled" => "Enabled",
						"disabled" => "Disabled"
					)
				),
			array( 
					'name' => __('Portfolio Page Title', AZ_THEME_NAME),
					'desc' => __('You can insert a custom page title instead of default page title.', AZ_THEME_NAME),
					'id' => '_az_page_title',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Page Caption', AZ_THEME_NAME),
					'desc' => __('You can insert a custom text caption instead of project attributes.', AZ_THEME_NAME),
					'id' => '_az_page_caption',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Portfolio Page Title and Caption Align', AZ_THEME_NAME),
					'desc' => __('You can align the text in three different ways.', AZ_THEME_NAME),
					'id' => '_az_page_text_align',
					'type' => 'select',
					'std' => 'textalignleft',
					'options' => array(
						"textalignleft" => "Left Align",
						"textaligncenter" => "Center Align",
						"textalignright" => "Right Align"
					)
				),
			array( 
					'name' => __('Portfolio Page Title and Caption Color', AZ_THEME_NAME),
					'desc' => __('Optional. Choose a text color for your title block.', AZ_THEME_NAME),
					'id' => '_az_page_text_color',
					'type' => 'color_text',
					'std' => ''
				),
		)
	);

	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
}