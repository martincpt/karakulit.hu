<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until the main cotent
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 * @since Kayo 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php
	/**
	 * Body tag attributes hook
	 *
	 * Used to add data attributes or others.
	 *
	 * @since Kayo 1.0
	 */
	do_action( 'kayo_body_atts' );
?>
>
<?php

	wp_body_open();

	/**
	 * Body start theme hook
	 *
	 * Used to add a top anchor or other usefull stuff
	 *
	 * @see in/frontend/hooks.php kayo_output_top_anchor functions
	 * @since Kayo 1.0
	 */
	do_action( 'kayo_body_start' );

	/**
	 * Body start theme hook
	 *
	 * Hook dedicated to plugins
	 * Allows plugins to add content right after the body tag
	 *
	 * @since Kayo 1.0
	 */
	do_action( 'wolf_body_start' );
?>
<div class="site-container">
	<div id="page" class="hfeed site">
		<div id="page-content">
		<header id="masthead" class="site-header clearfix" itemscope itemtype="http://schema.org/WPHeader">

			<p class="site-name" itemprop="headline"><?php bloginfo( 'name' ); ?></p><!-- .site-name -->
			<p class="site-description" itemprop="description"><?php bloginfo( 'description' ); ?></p><!-- .site-description -->

			<div id="header-content">
				<?php
					/**
					 * Top bar block hook
					 *
					 * @since Kayo 1.0
					 */
					do_action( 'kayo_top_bar_block' );
				?>
				<?php
					/**
					 * Main Navigation hook
					 *
					 * @see inc/frontend/hooks/navigation.php
					 * @since Kayo 1.0
					 */
					do_action( 'kayo_main_navigation' );
				?>
			</div><!-- #header-content -->

		</header><!-- #masthead -->

		<div id="main" class="site-main clearfix">
			<?php
				/**
				 * Main content start hook
				 *
				 * Used to add stuff that will be included in the main content area
				 *
				 * @see in/frontend/hooks.php
				 * @since Kayo 1.0
				 */
				do_action( 'kayo_main_content_start' );
			?>
			<div class="site-content">
				<?php
					/**
					 * Hero
					 *
					 * Hero hook
					 *
					 * @see inc/frontend/hooks/site kayo_output_hero_content function
					 * @since Kayo 1.0
					 */
					do_action( 'kayo_hero' );
				?>
				<?php
					/**
					 * After header block hook
					 *
					 * @since Kayo 1.0
					 */
					do_action( 'kayo_after_header_block' );
				?>
				<div class="content-inner section wvc-row wolf-core-row">
					<div class="content-wrapper">
