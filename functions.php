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

if( ! function_exists('pagination') ){
	
	function pagination() {
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

