<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) { ?>
    <h2 class="comments-title">
        <?php
        printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', boottheme ),
            number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
        </h2>

        <ul class="comment-list">
            <?php
            wp_list_comments( 
                array(
                    'style'       => 'li',
                    'short_ping'  => true,
                    'avatar_size' => 74,
                    'callback'    => 'boot_comments_list'
                    ) );
                    ?>
                </ul><!-- .comment-list -->


                <?php
        } // have_comments()

            // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
        <nav class="navigation comment-navigation" role="navigation">
            <ul class="pager  comment-navigation">
                <li class="previous"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;<?php previous_comments_link( __( 'Older comments', boottheme ) ); ?></li>
                <li class="next"><?php next_comments_link( __( 'Newer comments', boottheme ) ); ?>&nbsp;&nbsp;<i class="fa fa-chevron-left"></i></li>
            </ul>

        </nav><!-- .comment-navigation -->

        <?php } // Check for comment navigation ?>

        <?php if ( ! comments_open() && get_comments_number() ) { ?>
        <div class="alert alert-warning no-comments"><?php _e( 'Comments are closed.' , boottheme ); ?></div>
        <?php } else { 

            boot_comment_form();
        }

        ?>
</div><!-- #comments -->