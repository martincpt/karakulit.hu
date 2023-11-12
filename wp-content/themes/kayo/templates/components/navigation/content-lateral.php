<?php
/**
 * Displays lateral navigation type
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<div class="lateral-menu-panel" data-menu-layout="lateral">
	<?php
		/**
		 * lateral_menu_panel_start hook
		 */
		do_action( 'kayo_lateral_menu_panel_start' );
	?>
	<div class="lateral-menu-panel-inner">
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				kayo_logo();
			?>
		</div><!-- .logo-container -->
		<nav class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				kayo_primary_vertical_navigation();
			?>
		</nav>
		<?php if ( function_exists( 'wvc_socials' ) ) : ?>
			<div class="lateral-menu-socials">
				<?php
				echo wvc_socials(
					array(
						'alignment' => 'left',
						// 'size' => 'fa-1x',
						'services'  => kayo_get_inherit_mod(
							'menu_socials',
							'facebook,twitter,instagram'
						),
					)
				);
				?>
			</div><!-- .lateral-menu-socials -->
		<?php elseif ( function_exists( 'wolf_core_social_icons' ) ) : ?>
			<div class="lateral-menu-socials">
				<?php
				echo wolf_core_social_icons(
					array(
						'alignment' => 'left',
						// 'size' => 'fa-1x',
						'services'  => kayo_get_inherit_mod(
							'menu_socials',
							'facebook,twitter,instagram'
						),
					)
				);
				?>
			</div><!-- .lateral-menu-socials -->
		<?php endif; ?>
	</div><!-- .lateral-menu-panel-inner -->
</div><!-- .lateral-menu-panel -->
