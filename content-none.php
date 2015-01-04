<header class="page-header archive-header">
    <h1 class="page-title"><?php _e( 'Nothing Found', boottheme ); ?></h1>
</header>

<div class="page-content">
    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

    <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', boottheme ), admin_url( 'post-new.php' ) ); ?></p>

    <?php } elseif ( is_search() ) { ?>

    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', boottheme ); ?></p>
   
    <?php } else { ?>

    <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', boottheme ); ?></p>
    <?php get_search_form(); ?>

    <?php } ?>
</div><!-- .page-content -->