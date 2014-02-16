<?php header("Content-type: text/css; charset=utf-8"); 

$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

require_once( $path_to_wp . '/wp-load.php' );

$options = get_option('klaus'); 

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

$rgb = implode(',', hex2rgb($options['accent-color']));
?>
/* Accent Color */

a,
header #logo a:hover,
header #logo a:focus,
header #logo a:active,
#latest-posts .post-name .entry-title a:hover,
.entry-meta.entry-header a:hover,
.entry-meta.entry-header a:active,
.entry-meta.entry-header a:focus,
.standard-blog .post-name .entry-title a:hover,
.masonry-blog .post-name .entry-title a:hover,
.center-blog .post-name .entry-title a:hover,
.comment-author cite a:hover,
.comment-meta a:hover,
#commentform span.required,
#footer-credits p a,
.social_widget a i,
.dropmenu-active ul li a:hover,
.color-text,
.dropcap-color,
.social-icons li a:hover i,
.counter-number .count-number-icon {
	color: <?php echo $options['accent-color']; ?>;
}

#menu ul .sub-menu li a:hover {
	color: <?php echo $options['accent-color']; ?> !important;
}

.overlay-bg,
.overlay-bg-fill,
.item-project i,
.standard-blog .post-link,
.standard-blog .post-quote,
.masonry-blog .post-link,
.masonry-blog .post-quote,
.center-blog .post-link,
.center-blog .post-quote,
.badge_author,
#error-page .error-btn,
.social_widget a:hover,
.tooltip-inner,
.highlight-text,
.progress-bar .bar,
.pricing-table.selected .price,
.pricing-table.selected .confirm,
.mejs-overlay:hover .mejs-overlay-button,
.mejs-controls .mejs-time-rail .mejs-time-current,
.mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-current,
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
#jpreOverlay,
#jSplash,
#jprePercentage,
.tp-bullets.simplebullets.round .bullet:hover,
.tp-bullets.simplebullets.round .bullet.selected,
.tp-bullets.simplebullets.navbar .bullet:hover,
.tp-bullets.simplebullets.navbar .bullet.selected {
	background-color: <?php echo $options['accent-color']; ?>;
}

.navigation-projects ul li.prev a:hover,
.navigation-projects ul li.next a:hover,
.navigation-projects ul li.back-page a:hover {
	background-color: <?php echo $options['accent-color']; ?>;
	border-color: <?php echo $options['accent-color']; ?>;
}

.wpcf7 .wpcf7-submit:hover,
.wpcf7 .wpcf7-submit:focus,
.wpcf7 .wpcf7-submit:active,
#commentform #submit:hover,
.button-main:hover,
.button-main:active,
.button-main:focus,
.button-main.inverted {
	background-color: <?php echo $options['accent-color']; ?>;
    border-color: <?php echo $options['accent-color']; ?>;
}

.wpcf7-form.invalid input.wpcf7-not-valid,
.wpcf7-form.invalid textarea.wpcf7-not-valid,
.wpcf7-form input:focus:invalid:focus,
.wpcf7-form textarea:focus:invalid:focus,
.social_widget a {
	border-color: <?php echo $options['accent-color']; ?>;
}

.tagcloud a {
	border-color: <?php echo $options['accent-color']; ?>;
	color: <?php echo $options['accent-color']; ?>;
}

.tagcloud a:hover,
.tagcloud a:active,
.tagcloud a:focus {
	background-color: <?php echo $options['accent-color']; ?>;
}

.tooltip.top .tooltip-arrow {
    border-top-color: <?php echo $options['accent-color']; ?>;
}

.tooltip.right .tooltip-arrow {
    border-right-color: <?php echo $options['accent-color']; ?>;
}

.tooltip.left .tooltip-arrow {
    border-left-color: <?php echo $options['accent-color']; ?>;
}

.tooltip.bottom .tooltip-arrow {
    border-bottom-color: <?php echo $options['accent-color']; ?>;
}

.box .icon.circle-mode-box {
	border-color: rgba(<?php echo $rgb; ?>, 0.5);
}

.box:hover .icon.circle-mode-box,
.box:active .icon.circle-mode-box,
.box:focus .icon.circle-mode-box {
	border-color: <?php echo $options['accent-color']; ?>;
	background-color: <?php echo $options['accent-color']; ?>;
}

.box .icon.circle-mode-box i,
.box.boxed-version .icon-boxed i,
.box .icon.icon-only-mode-box {
	color: <?php echo $options['accent-color']; ?>;
}

<?php
if(!empty($options['enable-header-color']) && $options['enable-header-color'] == '1') {
echo '
/* Header Colors */

header {
	background-color: '.$options["header-background"].';
}

header #logo a {
	color: '.$options["header-logo-font-color"].';
}

#menu ul a {
	color: '.$options["header-font-color"].';
}

#menu > ul > li:after {
    border-color: '.$options["header-separator-color"].';
}

#menu ul a:hover,
#menu ul li.sfHover a,
#menu ul li.current-cat a,
#menu ul li.current_page_item a,
#menu ul li.current-menu-item a,
#menu ul li.current-page-ancestor a,
#menu ul li.current-menu-ancestor a {
    color: '.$options["header-font-color-hover"].';
}

#menu ul ul {
	background-color: '.$options["header-dropdown-background"].';
}

#menu ul .sub-menu li a {
	color: '.$options["header-dropdown-font-color"].' !important;
	border-color: '.$options["header-dropdown-separator-color"].';
}';
} ?>

<?php
if(!empty($options['enable-mobile-color']) && $options['enable-mobile-color'] == '1') {
echo '
/* Mobile Dropdown Colors */

#navigation-mobile {
	background-color: '.$options["mobile-dropdown-background"].';
}

#navigation-mobile li a,
#menu-nav-mobile .sub-menu li a {
	color: '.$options["mobile-dropdown-font-color"].';
}

#navigation-mobile li.has-ul.open > a,
#navigation-mobile li a:hover,
#menu-nav-mobile .sub-menu li a:hover,
#navigation-mobile li.has-ul.open a i,
#navigation-mobile .sub-menu li.has-ul.open a i {
	color: '.$options["mobile-dropdown-font-color-hover"].';
}

#menu-nav-mobile li,
#menu-nav-mobile ul.sub-menu li {
	border-color: '.$options["mobile-dropdown-separator-color"].';
}

#navigation-mobile li.has-ul a i,
#navigation-mobile .sub-menu li.has-ul a i {
	color: '.$options["mobile-dropdown-icon-color"].';
}';
} ?>

<?php
if(!empty($options['enable-typography-color']) && $options['enable-typography-color'] == '1') {
echo '
/* Typography Colors */

body,
a:hover,
a:active,
a:focus,
.entry-meta.entry-header a,
.comment-meta, 
.comment-meta a,
#twitter-feed .tweet_list li .tweet_time a,
.box p,
.dropmenu-active ul li a {
	color: '.$options["body-typo-color"].';
}

h1,
h2,
h3,
h4,
h5,
h6,
#latest-posts .post-name .entry-title a,
.standard-blog .post-name .entry-title a,
.masonry-blog .post-name .entry-title a,
.center-blog .post-name .entry-title a,
.comment-author cite, 
.comment-author cite a,
.dropmenu p,
.accordion-heading .accordion-toggle,
.nav > li > a,
.nav-tabs > li.active > a, 
.nav-tabs > li.active > a:hover, 
.nav-tabs > li.active > a:focus,
.dropcap,
.easyPieChart,
.pricing-table .price,
.counter-number .number-value {
	color: '.$options["heading-typo-color"].';
}';
} ?>

<?php
if(!empty($options['enable-back-top-color']) && $options['enable-back-top-color'] == '1') {
echo '
/* Back To Top Colors */

#back-to-top {
	background-color: '.$options["back-top-background"].';
}

#back-to-top i {
	color: '.$options["back-top-color"].';
}';
} ?>

<?php
if(!empty($options['enable-footer-color']) && $options['enable-footer-color'] == '1') {
echo '
/* Footer Colors */

footer {
	background-color: '.$options["footer-widget-background"].';
}

.footer-widgets h3,
.footer-widgets .tweet_timestamp > a {
	color: '.$options["footer-widget-heading-color"].' !important;
}

.footer-widgets {
	color: '.$options["footer-widget-font-color"].';
}

#footer-credits {
	background-color: '.$options["footer-credits-background"].';
}

#footer-credits p {
	color: '.$options["footer-credits-font-color"].';
}';
} ?>