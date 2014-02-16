<?php get_header(); ?>
<?php $options = get_option('klaus'); 

$error_image = null;
if( !empty($options['404-img']['url'])) {
    $error_image = ' class="error-404-image" style="background-image: url('.$options['404-img']['url'].');"';
}
?>

<div id="content">
    <section id="error-page"<?php echo $error_image; ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12 textaligncenter">
                    <a class="error-btn" href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                        <?php if( !empty($options['404-title'])) { ?>
                            <span class="error-title"><?php echo $options['404-title']; ?></span>
                        <?php } else { ?>
                            <span class="error-title"><?php echo __('404', AZ_THEME_NAME); ?></span>
                        <?php } ?>

                        <?php if( !empty($options['404-caption'])) { ?>
                            <span class="error-caption"><?php echo $options['404-caption']; ?></span>
                        <?php } else { ?>
                            <span class="error-caption"><?php echo __('Not Found', AZ_THEME_NAME); ?></span>
                        <?php } ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
	
<?php get_footer(); ?>