<?php $quote = get_post_meta($post->ID, '_az_quote', true); ?>

<?php if( !is_single() ) { ?>

<div class="post-quote">

<h2 class="entry-title">
	<?php echo $quote; ?>
</h2>

<p class="quote-source"><a href="<?php the_permalink(); ?>" title="<?php printf(__('Permanent Link to %s', AZ_THEME_NAME), get_the_title()); ?>"><?php the_title(); ?> #</a></p>
</div>

<?php } ?>

<?php if( is_single() ) { ?>

<div class="post-quote">

<h2 class="entry-title">
	<?php echo $quote; ?>
</h2>

<p class="quote-source"><?php the_title(); ?></p>
</div>

<div class="entry-content">
    <?php the_content( __("Continue Reading...", AZ_THEME_NAME) );?>
</div>

<?php get_template_part( 'content', 'meta-footer' ); ?>

<?php } ?>