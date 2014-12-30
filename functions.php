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
?>

