<?php get_header(); ?>

<?php az_page_header(get_option('page_for_posts')); ?>

<?php $options = get_option('klaus'); 
	
	$sectionpadding = null;
	$blog_type = $options['blog_type'];

	if($blog_type == 'standard-blog' || $blog_type == 'masonry-blog'){
		$sectionpadding = 'default-padding-mod';
	}

	else if($blog_type == 'center-blog'){
		$sectionpadding = 'default-padding-mod-center';
	} 
?>

<div id="content">
<section id="blog" class="<?php echo $sectionpadding; ?> <?php echo $options['blog_type']; ?>">
<div class="container">
<div class="row">
            
	<?php
				
	$alignment = (!empty($options['blog_sidebar_layout'])) ? $options['blog_sidebar_layout'] : 'no_side' ;
				
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
				
	$cols = (!empty($options['masonry_layout'])) ? $options['masonry_layout'] : '3' ;

	switch ($cols) {
	case '4' :
		$span_num = '3';
	break;
	case '3' :
		$span_num = '4';
	break;
	case '2' :
		$span_num = '6';
	break;
	}
				
	$blog_type = $options['blog_type'];
		if($blog_type == null) $blog_type = 'standard-blog';
				
			$masonry_class = null;
			$masonry_class = 'masonry-area';
				
			if($blog_type == 'standard-blog'){
				if($alignment == 'no_side') {
					echo '<div id="post-area" class="col-md-12">';
				}
				else if($alignment == 'left_side' || $alignment == 'right_side') {
					echo '<div id="post-area" class="col-md-9 '.$align_main.'">';
				}
			}
				 
			else if($blog_type == 'masonry-blog'){
				echo '<div id="post-area" class="'.$masonry_class.'">';
			}

			else if($blog_type == 'center-blog'){
				echo '<div id="post-area" class="col-md-8 col-md-offset-2">';
			}
                
		?>
                
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                
        <?php if($blog_type == 'standard-blog'){ ?>
				
		<article <?php post_class('item-blog'); ?> id="post-<?php the_ID(); ?>">	
        	<div class="post-container">
        	<?php 
            	$format = get_post_format(); 
                get_template_part( 'content', $format );
            ?>
            </div>
		</article>
                                
		<?php } 
				  
			else if($blog_type == 'masonry-blog'){ 
				$span_clm = $span_num;
		?>
                
		<article <?php post_class('item-blog col-md-'.$span_clm.''); ?> id="post-<?php the_ID(); ?>">	
        	<div class="post-container">
			<?php 
				$format = get_post_format(); 
				get_template_part( 'content', $format );
			?>
            </div>
		</article>
                
		<?php } 

			else if($blog_type == 'center-blog'){ 

		?>

		<article <?php post_class('item-blog'); ?> id="post-<?php the_ID(); ?>">	
        	<div class="post-container">
			<?php 
				$format = get_post_format(); 
				get_template_part( 'content', $format );
			?>
            </div>
		</article>

		<?php } ?>
                
		<?php endwhile; endif; ?>
              
		</div><!-- End Container Span -->
            
		<?php
			if($blog_type == 'standard-blog'){
				if($alignment == 'left_side' || $alignment == 'right_side') { ?>
					  
					<div class="col-md-3 <?php echo $align_sidebar; ?>">
						<aside id="sidebar">
                            <?php get_sidebar(); ?>
                        </aside>
                    </div>
			<?php	}
			}
		?>
</div> 
</div>
</section>

	<?php az_pagination(); ?>
    
</div>
    
<?php get_footer(); ?>