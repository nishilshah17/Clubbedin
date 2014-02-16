<?php $link_url = get_post_meta($post->ID, '_az_link', true); ?>

<?php if( !is_single() ) { ?>

<div class="post-link">

<h2 class="entry-title">
	<a href="<?php echo $link_url; ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a>
</h2>

<p class="link-source">
	<a href="<?php echo $link_url; ?>" target="_blank"><?php echo $link_url; ?></a>
	<a href="<?php  the_permalink(); ?>" title="<?php printf(__('Permanent Link to %s', AZ_THEME_NAME), get_the_title()); ?>">#</a>
</p>

</div>

<?php } ?>

<?php if( is_single() ) { ?>

<div class="post-link">

<h2 class="entry-title">
	<?php the_title(); ?>
</h2>

<p class="link-source">
	<a href="<?php echo $link_url; ?>" target="_blank"><?php echo $link_url; ?></a>
</p>

</div>

<div class="entry-content">
    <?php the_content( __("Continue Reading...", AZ_THEME_NAME) );?>
</div>

<?php get_template_part( 'content', 'meta-footer' ); ?>

<?php } ?>