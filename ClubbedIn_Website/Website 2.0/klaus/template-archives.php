<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<?php az_page_header($post->ID); ?>

<div id="content">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        
        <section class="main-content default-padding shadow-off">
            <div class="container">
                <div class="row">
                	<div class="col-md-9 entry-content-archives">
                		<?php //edit_post_link( __('Edit', AZ_THEME_NAME), '<span class="edit-post">[', ']</span>' ); ?>
        				<?php the_content(); ?>
                    
                    <section class="widget widget_archives">
                        <div class="widget_title">
                            <h4><?php _e('Latest 30 Posts', AZ_THEME_NAME); ?></h4>
                        </div>
                       <ul><?php wp_get_archives('type=postbypost&limit=30&show_post_count=1'); ?></ul> 
                    </section>
                    
                    <section class="widget widget_archives">
                        <div class="widget_title">
                            <h4><?php _e('Archives by Month', AZ_THEME_NAME); ?></h4>
                        </div>
                       <ul><?php wp_get_archives('type=monthly&limit=12'); ?></ul> 
                    </section>
                    
                    <section class="widget widget_archives">
                        <div class="widget_title">
                            <h4><?php _e('Archives by Subject', AZ_THEME_NAME); ?></h4>
                        </div>
                       <ul><?php wp_list_categories('title_li='); ?></ul> 
                    </section>
                    
                    </div>
                    
                    <div class="col-md-3">
                        <aside id="sidebar">
                            <?php get_sidebar(); ?>
                        </aside>
                    </div>
                    
                </div>
            </div>
        </section>
        
    <?php endwhile; endif; ?>
</div>
    
<?php get_footer(); ?>