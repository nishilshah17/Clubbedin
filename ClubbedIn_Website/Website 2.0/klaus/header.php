<?php $options = get_option('klaus'); 

$animation_options = null;
if( !empty($options['enable-animation']) && $options['enable-animation'] == 1) { 
	$animation_options = 'animation-enabled'; 
} else { 
	$animation_options = 'no-animation';
}

$animation_effects_options = null;
if( !empty($options['enable-animation-effects']) && $options['enable-animation-effects'] == 1) { 
	$animation_effects_options = 'animation-effects-enabled'; 
} else { 
	$animation_effects_options = 'no-animation-effects';
} 

?>
<!DOCTYPE html>
<!--[if gte IE 9]>
<html class="no-js lt-ie9 animated-content no-animation no-animation-effects" lang="en-US">     
<![endif]-->
<html <?php language_attributes(); ?> class="<?php echo $animation_options; ?> <?php echo $animation_effects_options; ?>">
<head>

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<!-- Mobile Specifics -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Mobile Internet Explorer ClearType Technology -->
<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on"><![endif]-->

<?php

if( !empty($options['use-logo'])) {
	$logo = $options['logo'];
	$retina_logo = $options['retina-logo'];
	$width = $options['logo']['width'];
	$height = $options['logo']['height'];

	if ($retina_logo == "") {
		$retina_logo = $logo;
	}
}

?>

<?php if(!empty($options['favicon']['url'])) { ?>
<!--Shortcut icon-->
<link rel="shortcut icon" href="<?php echo $options['favicon']['url']; ?>" />
<?php } ?>

<!-- Title -->
<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); ?></title>

<!-- RSS & Pingbacks -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<!-- Start Wrap All -->
<?php
$boxed = null;
if(!empty($options['enable-boxed-layout']) && $options['enable-boxed-layout'] == '1') { 
    $boxed = ' boxed'; 
} 
?>
<div class="wrap_all<?php echo $boxed; ?>">

<!-- Header -->
<?php
$header_class = null;
$main_class = null;
$headerStyle = (!empty($options['header-layout'])) ? $options['header-layout'] : 'normal-header';

if($headerStyle == 'normal-header'){
    $header_class = 'normal-header';
    $main_class = 'normal-header-enabled';
} 
else if($headerStyle == 'sticky-header'){
    $header_class = 'sticky-header';
    $main_class = 'sticky-header-enabled';
}
?>
<header class="<?php echo $header_class; ?>">
	<div class="container">
    	<div class="row">
        
		<div class="col-md-3">
		<div id="logo">
			<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
				<?php
				if( !empty($options['use-logo'])) { ?>
					<img class="standard" src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
					<img class="retina" src="<?php echo $retina_logo['url']; ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
				<?php } else { ?>
					<?php bloginfo('name'); ?>                            
				<?php } ?>
			</a>
		</div>
		</div>
            
        <div class="col-md-9">
            <!-- Mobile Menu -->
            <a id="mobile-nav" class="menu-nav" href="#menu-nav"><span class="menu-icon"></span></a>
                
            <!-- Standard Menu -->
            <div id="menu">
                <ul id="menu-nav">
                <?php 
                    if(has_nav_menu('primary_menu')) {
						wp_nav_menu( array('theme_location' => 'primary_menu', 'menu' => 'Primary Menu', 'container' => '', 'items_wrap' => '%3$s' ) ); 
                    }
                    else {
						echo '<li><a href="#">No menu assigned!</a></li>';
                    }
                ?>	
                </ul>
            </div>
        </div>
      
        </div>
    </div>
</header>
<!-- End Header -->

<!-- Mobile Navigation Mobile Menu -->
<div id="navigation-mobile">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	<ul id="menu-nav-mobile">
                <?php 
                    if(has_nav_menu('primary_menu')) {
						wp_nav_menu( array('theme_location' => 'primary_menu', 'menu' => 'Primary Menu', 'container' => '', 'items_wrap' => '%3$s' ) ); 
                    }
                    else {
						echo '<li><a href="#">No menu assigned!</a></li>';
                    }
                ?>	
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Navigation Mobile Menu -->

<!-- Start Main -->
<div id="main" class="<?php echo $main_class; ?>">