<?php get_header(); ?>
<div id="content" class="site-content" role="main">
    <div id="error" class="container">
        <h1><?php _e( '404, Page not found', boottheme );?> </h1>
        <p><?php _e( 'The page you are looking for doesnt exist or an other error occurred', boottheme );?> </p>
        <a class="btn btn-primary" href="<?php echo home_url(); ?>"><?php _e( 'Back to the homepage', boottheme );?></a>
    </div><!--/#error-->
</div><!-- #content -->
<?php get_footer();