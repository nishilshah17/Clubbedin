<?php
/* Template Name: Portfolio Full */
?>

<?php get_header(); ?>

<?php az_page_header($post->ID); ?>

<div id="content" class="portfolio-full">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <?php //edit_post_link( __('Edit', AZ_THEME_NAME), '<span class="edit-post">[', ']</span>' ); ?>
        <?php the_content(); ?>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>