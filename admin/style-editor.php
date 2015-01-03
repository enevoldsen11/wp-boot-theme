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
	
	//save file content
	if(isset($_POST['newcontent'])){		
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
	
	?>
	<div class="wrap">
		<h2>
			<?php screen_icon(); echo _e('style.less Editor', 'boottheme' )?>
		</h2>
				
		<?php if(isset($_GET['saved'])){ ?>
		<div class="updated fade"><p><strong><?php _e( 'Style.less updated', 'boottheme' ); ?></strong></p></div>
		<?php } ?>
		
		<p>
			Update the style.less file.
		</p>
				
		<form method="post" action="themes.php?page=style_editor">			
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
