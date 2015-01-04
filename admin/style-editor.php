<?php

add_action( 'admin_menu', 'style_editor_add_page' );

/**
 * Load up the menu page
 */
function style_editor_add_page() {
	add_theme_page( __( 'style.less Editor', 'boottheme' ), __( 'style.less Editor', 'boottheme' ), 'edit_theme_options', 'style_editor', 'style_editor_do_page' );
}

function read_less() {
   $file = get_template_directory().'/style.less';
   echo file_get_contents( $file );
}

/**
 * Create the options page
 */
function style_editor_do_page() {
	//Check if user has access
	if ( !current_user_can('edit_themes') ) {
		wp_die('<p>'.__('You do not have sufficient permissions to the style.less for this site.').'</p>');
	}
	
	//Save file content
	if(isset($_POST['newcontent']) ) {		
		
		if ( ! empty( $_POST ) && check_admin_referer( 'edit_style', 'less_content' ) ) {
   			$file = get_template_directory().'/style.less';
			$fp = fopen($file, "w");
			$data = $_POST["newcontent"];
			$data = stripslashes($data);
			fwrite($fp, $data);
			fclose($fp);
			echo '<script type="text/javascript">
				<!--
				window.location = \'themes.php?page=style_editor&saved=1\';
				//-->
			</script>';
		}
	}	
	
	?>
	<div class="wrap">
		<h2>
			<?php screen_icon(); echo _e('style.less Editor', 'boottheme' )?>
		</h2>
				
		<?php if(isset($_GET['saved'])){ ?>
		<div class="updated fade"><p><strong><?php _e( 'Style.less updated', 'boottheme' ); ?></strong></p></div>
		<?php } ?>
		
		<p>
			<?php _e( 'Update the style.less file. When style.less is updated the compilation is automatically done next time a page is loaded.', 'boottheme' ); ?>
		</p>
				
		<form method="post" action="themes.php?page=style_editor">			
			<?php wp_nonce_field( 'edit_style','less_content'); ?>
			<p>
				<textarea id="newcontent" class="large-text" cols="50" rows="25" name="newcontent"><?php read_less(); ?></textarea>
			</p>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Update style.less', 'boottheme ' ); ?>" />
			</p>
		</form>
	</div>
	<?php
	
}
