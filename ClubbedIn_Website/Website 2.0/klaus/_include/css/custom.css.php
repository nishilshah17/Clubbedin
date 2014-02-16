<?php header("Content-type: text/css; charset=utf-8"); 

$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

require_once( $path_to_wp . '/wp-load.php' );

$options = get_option('klaus'); 

echo $options['custom-css'];

?>

<?php
if(!empty($options['enable-boxed-layout']) && $options['enable-boxed-layout'] == '1') {
		
$attachment = $options["boxed-background-attachment"];
$position = $options["boxed-background-position"];
$repeat = $options["boxed-background-repeat"];
$background_color = $options["boxed-background-color"];

echo '
body {
	background-position: '.$position.';
	background-repeat: '.$repeat.';
	background-color: '.$background_color.';
	background-attachment: '.$attachment.';';
	if(!empty($options["boxed-background-image"])){
	echo '
	background-image: url("'.$options["boxed-background-image"]["url"].'");';
	}
	if(!empty($options["boxed-background-cover"]) && $options["boxed-background-cover"] == '1') {
	echo '
	background-size: cover;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;';
	}
 echo '
}';
}
?>