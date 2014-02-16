<?php if( !is_single() ) { ?>

<div class="video-thumb">
	<?php az_post_video(get_the_ID()); ?>
</div>

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

<div class="video-thumb">
    <?php az_post_video(get_the_ID()); ?>
</div>

<div class="entry-content">
    <?php the_content( __("Continue Reading...", AZ_THEME_NAME) );?>
</div>

<?php get_template_part( 'content', 'meta-footer' ); ?>

<?php } ?>