<?php get_header(); ?>

<?php az_post_header($post->ID); ?>

<?php $options = get_option('klaus'); 
    $sectionpadding = null;
    $blog_type = $options['blog_type'];

    if($blog_type == 'standard-blog' || $blog_type == 'masonry-blog'){
        $sectionpadding = 'default-padding';
    }

    else if($blog_type == 'center-blog'){
        $sectionpadding = 'default-padding-mod-center';
    }
?>

<div id="content">
	<section id="blog" class="<?php echo $sectionpadding; ?> single-post">
		<div class="container">
			<div class="row">

			<?php
                        
            $alignment = (!empty($options['blog_post_sidebar_layout'])) ? $options['blog_post_sidebar_layout'] : 'no_side' ;
            
            switch ($alignment) {
            case 'right_side' :
                $align_sidebar = 'right_side';
                $align_main = 'left_side';
            break;
            
            case 'left_side' :
                $align_sidebar = 'left_side';
                $align_main = 'right_side';
            break;
            }
            
            if($alignment == 'no_side') {
                echo '<div id="post-area" class="col-md-12">';
            }
            else if($alignment == 'left_side' || $alignment == 'right_side') {
                echo '<div id="post-area" class="col-md-9 '.$align_main.'">';
            }
            else if($alignment == 'center_side') {
                echo '<div id="post-area" class="col-md-8 col-md-offset-2">';
            }

            ?>          
  
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">	
				<?php 
                    $format = get_post_format(); 
                    get_template_part( 'content', $format );
                ?>
			</article>

            <?php if( !empty($options['blog-social']) && $options['blog-social'] == 1 ) { 
                                   
                   echo '<div class="az-social-share single-post">';
                   
                    //facebook
                    if(!empty($options['blog-facebook-sharing']) && $options['blog-facebook-sharing'] == 1) { 
                        echo '<div class="fb-like" data-href="'.get_permalink( $post->ID ).'" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div>';
                    }
                    //twitter
                    if(!empty($options['blog-twitter-sharing']) && $options['blog-twitter-sharing'] == 1) {
                        echo '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.get_permalink( $post->ID ).'">Tweet</a>';
                    }
                    //google plus
                    if(!empty($options['blog-google-sharing']) && $options['blog-google-sharing'] == 1) {
                        echo '<div class="g-plusone" data-size="medium" data-action="share" data-annotation="bubble"></div>';
                    }
                    //Pinterest
                    if(!empty($options['blog-pinterest-sharing']) && $options['blog-pinterest-sharing'] == 1) {
                        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
                        echo '<a class="pinterest-share" href="//www.pinterest.com/pin/create/button/?url='.get_permalink( $post->ID ).'&media='. esc_attr( $thumbnail[0] ).'&description='.get_the_title().'" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';
                    }
                  echo '</div>';

                }
            ?>

			<?php comments_template('', true); ?>

			<?php endwhile; endif; ?>

			</div><!-- End Container Span -->

			<?php
            if($alignment == 'left_side' || $alignment == 'right_side') { ?>
              
            <div class="col-md-3 <?php echo $align_sidebar; ?>">
                <aside id="sidebar">
                    <?php get_sidebar(); ?>
                </aside>
            </div>
            <?php } ?>
                
			</div> 
		</div>
	</section>
</div>

<?php get_footer(); ?>