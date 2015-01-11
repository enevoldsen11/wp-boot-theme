<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name');?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri() ?>/js/html5shiv.js"></script>
			<script src="<?php echo get_template_directory_uri() ?>/js/respond.min.js"></script>
		<![endif]-->      
		<link rel="shortcut icon" href="<?php echo esc_url( get_theme_mod( 'boot_favicon' ) ); ?>"/>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class() ?>>
	  <header id="header" class="navbar navbar-default navbar-fixed-top" role="navigation">		
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if ( get_theme_mod( 'boot_logo' ) ) { ?>
					 <a class="navbar-brand" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'boot_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
				<?php } else { ?>
					<a class="navbar-brand" href="<?php bloginfo('url'); ?>">
						<?php bloginfo('name'); ?>
					</a>
				<?php } 
				
				
			?>

			</div>			
			<?php wp_nav_menu( array(
					'menu'              => 'primary',
					'theme_location'    => 'primary',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
					'menu_class'        => 'nav navbar-nav',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker())
				);
			?>
		</div>
	</header><!--/#header-->
		
	<?php 
		if( is_home() ) {			 
			dynamic_sidebar( 'header' );
		}
	?>
	
	<?php if( ! is_page() ) { ?>
	  <section id="main">
		<div class="container">
		  <div class="row">
			<div class="col-lg-12">
			  <div id="primary" class="content-area">
				<?php } ?>

