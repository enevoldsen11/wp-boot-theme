<?php get_header(); ?>

<div class="row">
    <div id="content" class="site-content col-md-8" role="main">
        <?php if ( have_posts() ) { ?>
        <header class="page-header archive-header">
            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', boottheme ), get_search_query() ); ?></h1>
        </header>
        <?php /* The loop */ ?>
        <?php while ( have_posts() ) { the_post(); 
            ?>
            <?php get_template_part( 'content', 'search' ); ?>
            <?php } ?>
            <?php echo boot_pagination(); ?>
            <?php } else { ?>
            <?php get_template_part( 'content', 'none' ); ?>
            <?php } ?>
        </div><!-- #content -->
        <?php get_template_part( 'archive-sidebar' ) ?>
    </div>
    <?php get_footer(); ?>