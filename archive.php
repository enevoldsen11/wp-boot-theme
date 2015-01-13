<?php get_header(); ?>

<div class="row">
    <div id="content" class="site-content col-sm-8" role="main">

        <?php if ( have_posts() ) { ?>
			<header class="page-header archive-header">
				<?php
					the_archive_title( '<h1 class="archive-title">', '</h1>' );
					the_archive_description( '<div>', '</div>' );
				?>
			</header><!-- .archive-header --> 
		
			<?php while ( have_posts() ) { the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php } ?>

			<?php echo boot_pagination(); ?>

        <?php } else { ?>
			<?php get_template_part( 'content-none', 'none' ); ?>
        <?php } ?>

    </div><!-- #content -->
    <?php get_template_part( 'archive-sidebar' ) ?>
    </div>

</div>

<?php get_footer();