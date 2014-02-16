<?php
	if( is_page() ) {
		dynamic_sidebar( 'sidebar-page' );
	} else {
		dynamic_sidebar('sidebar-blog');
	}
?>
    
