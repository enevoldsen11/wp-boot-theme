<?php
// Include the class (unless you are using the script as a plugin)
require_once(get_template_directory().'/lib/wp-less/wp-less.php');

// enqueue a .less style sheet
if ( ! is_admin() ){
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.less' );
}  

// Register Navigation Walker
require_once(get_template_directory().'/lib/wp_bootstrap_navwalker.php');

// Register Menu
register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'boottheme' ),
) );

// Registering widgets
register_sidebar(array(
  'name' => __( 'Header', boottheme ),
  'id' => 'header',
  'description' => __( 'Widgets in this area will be shown after header in the home page.' , boottheme),
  'before_title' => '<h3>',
  'after_title' => '</h3>',
  'before_widget' => '<div >',
  'after_widget' => '</div>'
  )
);

register_sidebar(array(
  'name' => __( 'Sidebar', boottheme ),
  'id' => 'sidebar',
  'description' => __( 'Widgets in this area will be shown on right side.', boottheme ),
  'before_title' => '<h3>',
  'after_title' => '</h3>',
  'before_widget' => '<div>',
  'after_widget' => '</div>'
  )
);

register_sidebar(array(
  'name' => __( 'Bottom', boottheme ),
  'id' => 'bottom',
  'description' => __( 'Widgets in this area will be shown before footer.' , boottheme),
  'before_title' => '<h3>',
  'after_title' => '</h3>',
  'before_widget' => '<div class="col-sm-3 col-xs-6">',
  'after_widget' => '</div>'
  )
);

register_sidebar(array(
  'name' => __( 'Footer', boottheme ),
  'id' => 'footer',
  'description' => __( 'Widgets in this area will be shown in the footer' , boottheme),
  'before_title' => '<h4>',
  'after_title' => '</h4>',
  'before_widget' => '<div class="col-sm-3 col-xs-6">',
  'after_widget' => '</div>'
  )
);

//Add theme support for thumbnails
add_theme_support( 'post-thumbnails' ); 

// Functions

if( ! function_exists('boot_scripts') ){	

    function boot_scripts() {

		// Javascripts
        wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('application-js', get_template_directory_uri().'/js/application.js', array('jquery'));
				
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
            'nextpagelink' => __('Next page', boottheme),
            'previouspagelink' => __('Previous page', boottheme), 
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
					<?php previous_post_link( '%link', _x( '<i class="icon-long-arrow-left"></i> %title', 'Previous post link', boottheme ) ); ?>
				</li>
				<?php } ?>

				<?php if ( $next ) { ?>
				<li class="next"><?php next_post_link( '%link', _x( '%title <i class="icon-long-arrow-right"></i>', 'Next post link', boottheme ) ); ?></li>
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
				<p><?php _e( 'Pingback:', boottheme ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', boottheme ), '<span class="edit-link">', '</span>' ); ?></p>
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
							$avatar_img = boot_get_avatar_url($get_avatar);
								 //Comment author avatar 
							?>
							<img class="avatar img-circle" src="<?php echo $avatar_img ?>" alt="">
						</div>

						<div class="media-body">

							<div class="well">

								<div class="comment-meta media-heading">
									<span class="author-meta">
										<span class="author-name">
											<?php _e('By', boottheme); ?> <strong><?php echo get_comment_author(); ?></strong>
										</span>
										-
										<time datetime="<?php echo get_comment_date(); ?>">
											<?php echo get_comment_date(); ?> <?php echo get_comment_time(); ?>										
										</time>
									</span>
									<span class="pull-right">
										<?php edit_comment_link( __( 'Edit', boottheme ), '<small class="edit-link">', '</small>') ?>
									</span>
									<span class="reply pull-right">
										<?php comment_reply_link( array_merge( $args, array( 'reply_text' =>  sprintf( __( '%s Reply', boottheme ), '<i class="fa fa-reply"></i> ' ) , 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
									</span><!-- .reply -->
								</div>

								<?php if ( '0' == $comment->comment_approved ) {  //Comment moderation ?>
								<div class="alert alert-warning"><?php _e( 'Your comment is awaiting moderation.', boottheme ); ?></div>
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

if( ! function_exists('boot_get_avatar_url') ){
	/**
	 * Get avatar url
	 * @param  [string] $get_avatar [Avater image link]
	 * @return [string]             [image link]
	 */
	function boot_get_avatar_url($get_avatar){
		preg_match("/src='(.*?)'/i", $get_avatar, $matches);
		return $matches[1];
	}
}

//Comments On Pages
if (!function_exists("comments_page")) {
    function comments_page(){
        if(is_page()){
            comments_template();
        }
    }
}

//Comments On Blog
if (!function_exists("comments_post")) {
    function comments_post(){
        if(is_single()){
            comments_template();
        }
    }
}

if( ! function_exists('boot_comment_form') ){

/**
 * Comment form
 */

function boot_comment_form($args = array(), $post_id = null ){


    if ( null === $post_id )
        $post_id = get_the_ID();
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    if ( ! isset( $args['format'] ) )
        $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';


    $req      = get_option( 'require_name_email' );

    $aria_req = ( $req ? " aria-required='true'" : '' );

    $html5    = 'html5' === $args['format'];

    $fields   =  array(
        'author' => '
        <div class="form-group">
        <div class="col-sm-6 comment-form-author">
        <input   class="form-control"  id="author" 
        placeholder="' . __( 'Name', ZEETEXTDOMAIN ) . '" name="author" type="text" 
        value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
        </div>',


        'email'  => '<div class="col-sm-6 comment-form-email">
        <input id="email" class="form-control" name="email" 
        placeholder="' . __( 'Email', ZEETEXTDOMAIN ) . '" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' 
        value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
        </div>
        </div>',
        
        );

$required_text = sprintf( ' ' . __('Required fields are marked %s', ZEETEXTDOMAIN), '<span class="required">*</span>' );

$defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),

    'comment_field'        => '
    <div class="form-group comment-form-comment">
    <div class="col-sm-12">
    <textarea class="form-control" id="comment" name="comment" placeholder="' . _x( 'Comment', 'noun', ZEETEXTDOMAIN ) . '" rows="8" aria-required="true"></textarea>
    </div>
    </div>
    ',

    'must_log_in'          => '


    <div class="alert alert-danger must-log-in">' 
    . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) 
    . '</div>',

    'logged_in_as'         => '<div class="alert alert-warning logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', ZEETEXTDOMAIN ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</div>',

    'comment_notes_before' => '<div class="alert alert-warning comment-notes">' . __( 'Your email address will not be published.', ZEETEXTDOMAIN ) . ( $req ? $required_text : '' ) . '</div>',

    'comment_notes_after'  => '<div class="alert alert-warning form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', ZEETEXTDOMAIN ), ' <code>' . allowed_tags() . '</code>' ) . '</div>',

    'id_form'              => 'commentform',

    'id_submit'            => 'submit',

    'title_reply'          => __( 'Leave a Reply', ZEETEXTDOMAIN ),

    'title_reply_to'       => __( 'Leave a Reply to %s', ZEETEXTDOMAIN ),

    'cancel_reply_link'    => __( 'Cancel reply', ZEETEXTDOMAIN ),

    'label_submit'         => __( 'Post Comment', ZEETEXTDOMAIN ),

    'format'               => 'xhtml',
    );


$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

if ( comments_open( $post_id ) ) { ?>

<?php do_action( 'comment_form_before' ); ?>

<div id="respond" class="comment-respond">

    <h3 id="reply-title" class="comment-reply-title">
        <?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> 
        <span class="pull-right"><small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></span>
    </h3>

    <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) { ?>

    <?php echo $args['must_log_in']; ?>

    <?php do_action( 'comment_form_must_log_in_after' ); ?>

    <?php } else { ?>

    <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" 
        class="form-horizontal comment-form"<?php echo $html5 ? ' novalidate' : ''; ?> role="form">
        <?php do_action( 'comment_form_top' ); ?>

        <?php if ( is_user_logged_in() ) { ?>

        <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>

        <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>

        <?php } else { ?>

        <?php echo $args['comment_notes_before']; ?>

        <?php

        do_action( 'comment_form_before_fields' );

        foreach ( (array) $args['fields'] as $name => $field ) {
            echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
        }

        do_action( 'comment_form_after_fields' );

    } 

    echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); 

    echo $args['comment_notes_after']; ?>

    <div class="form-submit">
        <button class="btn btn-primary" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>">
			<?php echo esc_attr( $args['label_submit'] ); ?>
			<i class="fa fa-send"></i>
		</button>
        <?php comment_id_fields( $post_id ); ?>
    </div>

    <?php do_action( 'comment_form', $post_id ); ?>

</form>

<?php } ?>

</div><!-- #respond -->
<?php do_action( 'comment_form_after' ); ?>
<?php } else { ?>
<?php do_action( 'comment_form_comments_closed' ); ?>
<?php } ?>
<?php


}

}

function new_content_more($more) {
       global $post;
       return ' <a href="' . get_permalink() . "#more-{$post->ID}\" class=\"btn btn-primary\">Read More  <i class=\"fa fa-chevron-right\"></i></a>";
}   
add_filter( 'the_content_more_link', 'new_content_more' );

function new_excerpt_more($more) {
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

function the_excerpt_more_link( $excerpt ){
    $post = get_post();
    $excerpt .= '<a href="'. get_permalink($post->ID) . '" class="btn btn-primary">Read More...</a>';
    return $excerpt;
}
add_filter( 'the_excerpt', 'the_excerpt_more_link');

/*
	Theme customizer
*/
function boot_theme_customizer( $wp_customize ) {
    // Fun code will go here
	$wp_customize->add_section( 'boot_logo_section' , array(
    'title'       => __( 'Logo', 'boot' ),
    'priority'    => 30,
    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );

	$wp_customize->add_setting( 'boot_logo' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'boot_logo', array(
    'label'    => __( 'Logo', 'boot' ),
    'section'  => 'boot_logo_section',
    'settings' => 'boot_logo',
	) ) );
	
	//Favicon
	$wp_customize->add_section( 'boot_favicon_section' , array(
    'title'       => __( 'Favicon', 'boot' ),
    'priority'    => 31,
    'description' => 'Upload a favicon',
	) );

	$wp_customize->add_setting( 'boot_favicon' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'boot_favicon', array(
		'label'    => __( 'Favicon', 'boot' ),
		'section'  => 'boot_favicon_section',
		'settings' => 'boot_favicon',
	) ) );
}
add_action('customize_register', 'boot_theme_customizer');

/*
	Theme options
*/

require_once ( get_template_directory() . '/admin/style-editor.php' );

?>

