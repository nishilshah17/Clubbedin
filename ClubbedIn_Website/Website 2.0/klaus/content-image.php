<?php if( !is_single() ) { ?>

<?php /* if the post has a WP 2.9+ Thumbnail */
if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
?>
<div class="post-thumb">
	<a title="<?php the_title(); ?>" href="<?php echo $featured_image[0]; ?>" class="hover-wrap fancybox">
		<?php the_post_thumbnail('blog-post-thumb'); /* post thumbnail settings configured in functions.php */ ?>
		<span class="overlay"><span class="circle"><i class="font-icon-search"></i></span></span>
    </a>
</div>
<?php } ?>

<div class="post-name">
	<h2 class="entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?></a>
	</h2>
	<?php get_template_part( 'content' , 'meta-header' ); ?>
</div>

<div class="entry-content">
    <?php the_content( __("Continue Reading...", AZ_THEME_NAME) );?>
</div>

<?php } ?>

<?php if( is_single() ) { ?>

<?php /* if the post has a WP 2.9+ Thumbnail */
if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { 
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
?>
<div class="post-thumb">
	<a title="<?php the_title(); ?>" href="<?php echo $featured_image[0]; ?>" class="hover-wrap fancybox">
		<?php the_post_thumbnail('blog-post-thumb'); /* post thumbnail settings configured in functions.php */ ?>
		<span class="overlay"><span class="circle"><i class="font-icon-search"></i></span></span>
    </a>
</div>
<?php } ?>

<div class="entry-content">
    <?php the_content( __("Continue Reading...", AZ_THEME_NAME) );?>
</div>

<?php get_template_part( 'content', 'meta-footer' ); ?>

<?php } ?>