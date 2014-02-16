<?php $options = get_option('klaus'); ?>
</div>
<!-- End Main -->

<?php if( !empty($options['enable-back-to-top']) && $options['enable-back-to-top'] == 1) { ?>
<!-- Back To Top -->
<a id="back-to-top" href="#">
    <i class="font-icon-arrow-up-simple-thin"></i>
</a>
<!-- End Back to Top -->
<?php } ?>

<footer>
<?php if ( is_home() || is_search() || is_404() ) {
	// Blog Page and Search Page
	az_footer_widget(get_option('page_for_posts'));
}
else {
	// All Other Pages and Posts
	az_footer_widget(get_the_ID());
}
?>

<!-- Start Footer Credits -->
<section id="footer-credits">
	<div class="container">
		<div class="row">

			<?php if( !empty($options['enable-footer-social-area']) && $options['enable-footer-social-area'] == 1) { ?>
            
            <div class="col-md-6">
                <p class="copyright">&copy; <?php _e('Copyright ', AZ_THEME_NAME); echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a> / <?php _e('Powered by', AZ_THEME_NAME) ?> <a href="http://wordpress.org/" target="_blank">WordPress</a></p>
                <?php if(!empty($options['footer-copyright-text'])) { ?> <p class="credits"><?php echo $options['footer-copyright-text']; ?></p> <?php } ?>
            </div>
            
            <div class="col-md-6">
            <!-- Social Icons -->
            <nav id="social-footer">
                <ul>
                    <?php
                        global $socials_profiles;
                        
                        foreach($socials_profiles as $social_profile):
                            if( $options[$social_profile.'-url'] )
                            {
                                echo '<li><a href="'.$options[$social_profile.'-url'].'" target="_blank"><i class="font-icon-social-'.$social_profile.'"></i></a></li>';
                            }
                        endforeach;
                    ?>
                </ul>
            </nav>
            <!-- End Social Icons -->
            </div>
            <?php } else { ?>
            
            <div class="col-md-12">
                <p class="copyright">&copy; <?php _e('Copyright ', AZ_THEME_NAME); echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a> / <?php _e('Powered by', AZ_THEME_NAME) ?> <a href="http://wordpress.org/" target="_blank">WordPress</a></p>
                <?php if(!empty($options['footer-copyright-text'])) { ?><p class="credits"><?php echo $options['footer-copyright-text']; ?></p> <?php } ?>
            </div>
    
            <?php } ?>
            
		</div>
	</div>
</section>
<!-- Start Footer Credits -->

</footer>

</div>
<!-- End Wrap All -->


<?php if(!empty($options['tracking-code'])) echo $options['tracking-code']; ?> 

<?php 	
	wp_register_script('main', get_template_directory_uri() . '/_include/js/main.js', array('jquery'), NULL, true);
	wp_enqueue_script('main');
	
	wp_localize_script(
		'main', 
		'theme_objects',
		array(
			'base' => get_template_directory_uri()
		)
	);

	wp_footer();  
?>	

</body>
</html>