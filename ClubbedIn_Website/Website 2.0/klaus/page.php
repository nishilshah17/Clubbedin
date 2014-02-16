<?php get_header(); ?>

<?php az_page_header($post->ID); ?>

<div id="content">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <?php //edit_post_link( __('Edit', AZ_THEME_NAME), '<span class="edit-post">[', ']</span>' ); ?>
        <?php the_content(); ?>
        <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', AZ_THEME_NAME).'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>