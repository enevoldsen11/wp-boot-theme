<?php
// Include the class (unless you are using the script as a plugin)
require_once(get_template_directory().'/lib/wp-less/wp-less.php');

// enqueue a .less style sheet
if ( ! is_admin() ){
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.less' );
}  

// you can also use .less files as mce editor style sheets
add_editor_style( 'editor-style.less' );

// Register Navigation Walker
require_once(get_template_directory().'/lib/wp_bootstrap_navwalker.php');

// Register Menu
register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'BOOTTHEME' ),
) );


// Functions

if( ! function_exists('boot_scripts') ){	

    function boot_scripts() {

		// Javascripts
        wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'));
       		
		// Inline css
        //wp_add_inline_style( 'style',       zee_style_options() );
    }
	
	// Adding scripts
    add_action('wp_enqueue_scripts', 'boot_scripts');
}

if( ! function_exists('boot_link_pages') ){

    function boot_link_pages($args = '') {
        $defaults = array(
            'before' => '' ,
            'after' => '',
            'link_before' => '', 
            'link_after' => '',
            'next_or_number' => 'number', 
            'nextpagelink' => __('Next page', BOOTTHEME),
            'previouspagelink' => __('Previous page', BOOTTHEME), 
            'pagelink' => '%',
            'echo' => 1
            );

        $r = wp_parse_args( $args, $defaults );
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';
        if ( $multipage ) {
            if ( 'number' == $next_or_number ) {
                $output .= $before . '<ul class="pagination">';
                $laquo = $page == 1 ? 'class="disabled"' : '';
                $output .= '<li ' . $laquo .'>' . _wp_link_page($page -1) . '&laquo;</li>';
                for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
                    $j = str_replace('%',$i,$pagelink);

                    if ( ($i != $page) || ((!$more) && ($page==1)) ) {
                        $output .= '<li>';
                        $output .= _wp_link_page($i) ;
                    }
                    else{
                        $output .= '<li class="active">';
                        $output .= _wp_link_page($i) ;
                    }
                    $output .= $link_before . $j . $link_after ;

                    $output .= '</li>';
                }
                $raquo = $page == $numpages ? 'class="disabled"' : '';
                $output .= '<li ' . $raquo .'>' . _wp_link_page($page +1) . '&raquo;</li>';
                $output .= '</ul>' . $after;
            } else {
                if ( $more ) {
                    $output .= $before . '<ul class="pager">';
                    $i = $page - 1;
                    if ( $i && $more ) {
                        $output .= '<li class="previous">' . _wp_link_page($i);
                        $output .= $link_before. $previouspagelink . $link_after . '</li>';
                    }
                    $i = $page + 1;
                    if ( $i <= $numpages && $more ) {
                        $output .= '<li class="next">' .  _wp_link_page($i);
                        $output .= $link_before. $nextpagelink . $link_after . '</li>';
                    }
                    $output .= '</ul>' . $after;
                }
            }
        }

        if ( $echo ){
            echo $output;
        } else {
            return $output;
        } 
    }
}

if( ! function_exists('boot_pagination') ){
	
	function boot_pagination() {
		global $wp_query;
		if ($wp_query->max_num_pages > 1) {
				$big = 999999999; // need an unlikely integer
				$items =  paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'prev_next' => true,
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'type'=>'array'
					) );

				$pagination ="<ul class='pagination'>\n\t<li>";
				$pagination .=join("</li>\n\t<li>", $items);
				$pagination ."</li>\n</ul>\n";
				
				return $pagination;
			}
		return;
	}  
}

if ( ! function_exists( 'boot_post_nav' ) ) {

	/**
	 * Display post nav
	 * @return [type] [description]
	 */

	function boot_post_nav() {
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next and ! $previous ){
			return;
		} 
		?>
		<nav class="navigation post-navigation" role="navigation">
			<div class="pager">
				<?php if ( $previous ) { ?>
				<li class="previous">
					<?php previous_post_link( '%link', _x( '<i class="icon-long-arrow-left"></i> %title', 'Previous post link', ZEETEXTDOMAIN ) ); ?>
				</li>
				<?php } ?>

				<?php if ( $next ) { ?>
				<li class="next"><?php next_post_link( '%link', _x( '%title <i class="icon-long-arrow-right"></i>', 'Next post link', ZEETEXTDOMAIN ) ); ?></li>
				<?php } ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}
	
if( ! function_exists("boot_comments_list") ){

	/**
	 * Comments link
	 * @param   $comment [comments]
	 * @param   $args    [arguments]
	 * @param   $depth   [depth]
	 * @return void          
	 */
	function boot_comments_list($comment, $args, $depth) {

		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
			?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', BOOTTHEME ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', BOOTTHEME ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
				default :
				// Proceed with normal comments.
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>" class="comment media">
						<div class="pull-left comment-author vcard">
							<?php 
							$get_avatar = get_avatar( $comment, 48 );
							$avatar_img = zee_get_avatar_url($get_avatar);
								 //Comment author avatar 
							?>
							<img class="avatar img-circle" src="<?php echo $avatar_img ?>" alt="">
						</div>

						<div class="media-body">

							<div class="well">

								<div class="comment-meta media-heading">
									<span class="author-name">
										<?php _e('By', BOOTTHEME); ?> <strong><?php echo get_comment_author(); ?></strong>
									</span>
									-
									<time datetime="<?php echo get_comment_date(); ?>">
										<?php echo get_comment_date(); ?> <?php echo get_comment_time(); ?>
										<?php edit_comment_link( __( 'Edit', BOOTTHEME ), '<small class="edit-link">', '</small>' ); //edit link ?>
									</time>

									<span class="reply pull-right">
										<?php comment_reply_link( array_merge( $args, array( 'reply_text' =>  sprintf( __( '%s Reply', BOOTTHEME ), '<i class="icon-repeat"></i> ' ) , 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
									</span><!-- .reply -->
								</div>

								<?php if ( '0' == $comment->comment_approved ) {  //Comment moderation ?>
								<div class="alert alert-info"><?php _e( 'Your comment is awaiting moderation.', BOOTTHEME ); ?></div>
								<?php } ?>

								<div class="comment-content comment">
									<?php comment_text(); //Comment text ?>
								</div><!-- .comment-content -->

							</div><!-- .well -->


						</div>
					</div><!-- #comment-## -->
					<?php
					break;
		} // end comment_type check

	}
}
?>

