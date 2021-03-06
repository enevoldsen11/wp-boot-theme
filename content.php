<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>    	
	<header class="entry-header">		
        <?php if ( is_single() ) { ?>
        <h1 class="entry-title">
            <?php the_title(); ?>
            <?php edit_post_link( __( 'Edit', boottheme ), '<small class="edit-link pull-right">', '</small>' ); ?>
        </h1>
        <?php } else { ?>
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            <?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
            <sup class="featured-post"><?php _e( 'Sticky', boottheme ) ?></sup>
            <?php } ?>
            <?php edit_post_link( __( 'Edit', boottheme ), '<small class="edit-link pull-right">', '</small>' ); ?>
        </h2>
        <?php } //.entry-title ?>
        <?php if ( get_post_type( $post ) != 'page'){ ?>
		<div class="entry-meta">
            <ul>
                <li class="date"><?php echo __('Posted On', boottheme ); ?> <time class="entry-date" datetime="<?php the_time( 'c' ); ?>"><?php the_time('j M Y'); ?></time></li>
                <li class="author"><?php echo __('By', boottheme ); ?> <?php the_author_posts_link() ?></li>
                <li class="category"><?php echo __('In', boottheme ); ?> <?php echo get_the_category_list(', '); ?></li> 
                <?php if ( comments_open() && ! is_single() ) { ?>
                <li class="comments-link">
                    <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', boottheme ) . '</span>', __( 'One comment so far', boottheme ), __( 'View all % comments', boottheme ) ); ?>
                </li>
                <?php } //.comment-link ?>                       
            </ul>
        </div><!--/.entry-meta -->
		<?php } ?>
    </header><!--/.entry-header -->
	<?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php } //.entry-thumbnail ?>
    <?php if ( is_search() ) { ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div> <!--/.entry-summary -->
    <?php } else { ?>
		<div class="entry-content">
			<?php if ( has_excerpt( get_the_ID() ) && is_home()){			
				the_excerpt();			
			}else{
				the_content();
			}
			?>		
		</div>
    <?php } //.entry-content ?>
    <div>
        <?php boot_link_pages(); ?>
    </div>
</article><!--/#post-->
