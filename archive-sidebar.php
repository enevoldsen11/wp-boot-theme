<div id="sidebar" class="col-md-4 archive-sidebar" role="complementary">
        <div class="sidebar-inner">
            
			<h3><?php _e( 'Search in archive', boottheme );?></h3>			
			<?php get_search_form(  ); ?>
			
			<h3><?php _e( 'Categories', boottheme );?></h3>
			<?php 
				$args = array(
				'show_option_all'    => '',
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'list',
				'show_count'         => 0,
				'hide_empty'         => 1,
				'use_desc_for_title' => 1,
				'child_of'           => 0,
				'feed'               => '',
				'feed_type'          => '',
				'feed_image'         => '',
				'exclude'            => '',
				'exclude_tree'       => '',
				'include'            => '',
				'hierarchical'       => 1,
				'title_li'           => '',
				'show_option_none'   => __( 'No categories', boottheme ),
				'number'             => null,
				'echo'               => 1,
				'depth'              => 0,
				'current_category'   => 0,
				'pad_counts'         => 0,
				'taxonomy'           => 'category',
				'walker'             => null
				);
				wp_list_categories( $args ); 
			?>
			
			<h3><?php _e( 'Tags', boottheme );?></h3>			
			<div class="tags">
				<?php $args = array(
					'smallest'                  => 8, 
					'largest'                   => 22,
					'unit'                      => 'pt', 
					'number'                    => 45,  
					'format'                    => 'flat',
					'separator'                 => "\n",
					'orderby'                   => 'name', 
					'order'                     => 'ASC',
					'exclude'                   => null, 
					'include'                   => null, 
					'topic_count_text_callback' => default_topic_count_text,
					'link'                      => 'view', 
					'taxonomy'                  => 'post_tag', 
					'echo'                      => true,
					'child_of'                  => null, // see Note!
				); ?>
				<?php wp_tag_cloud( $args ); ?>			
			</div>
			
			<h3><?php _e( 'Authors', boottheme );?></h3>
			<div class="authors">
				<?php $args = array(
					'orderby'       => 'name', 
					'order'         => 'ASC', 
					'number'        => null,
					'optioncount'   => false, 
					'exclude_admin' => true, 
					'show_fullname' => false,
					'hide_empty'    => true,
					'echo'          => true,
					'feed'          => '', 
					'feed_image'    => '',
					'feed_type'     => '',
					'style'         => 'list',
					'html'          => true,
					'exclude'       => '',
					'include'       => '' ); ?> 
				<?php wp_list_authors( $args ); ?>
			</div>
        </div>