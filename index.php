<?php 
	get_header();
	$col= 'col-md-12';
	if ( is_active_sidebar( 'sidebar' ) ) {
		$col = 'col-md-8';
	}
?>
<div class="row">
    <div id="content" class="site-content <?php echo $col; ?>" role="main">
        <?php 
			if ( have_posts() ) {        
				while ( have_posts() ) { 
					the_post();
					get_template_part( 'content', get_post_format() );
				}

				echo boot_pagination();

			} else {
				get_template_part( '/content', 'none' );
			} 
		?>
    </div><!-- #content -->
    <?php get_sidebar(); ?>
</div>
<?php get_footer();