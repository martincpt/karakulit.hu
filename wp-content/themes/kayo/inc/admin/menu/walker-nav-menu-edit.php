<?php
/**
 * Custom Walker for Nav Menu Editor
 *
 * We're separating this class from the plugin file because Walker_Nav_Menu_Edit
 * is only loaded on the wp-admin/nav-menus.php page.
 *
 * @package Menu_Item_Custom_Fields
 * @version 0.1.1
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 */

/**
 * Menu item custom fields walker
 *
 * Based on {@link https://twitter.com/westonruter Weston Ruter}'s {@link https://gist.github.com/3802459 gist}
 *
 * @since 0.1.0
 */
class Menu_Item_Custom_Fields_Walker extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 *
	 * We're injecting our custom fields after the div.submitbox
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 0.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Menu item args.
	 * @param int    $id     Nav menu ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args, $id );

		$html_tag = 'p';

		if ( version_compare( get_bloginfo( 'version' ), '4.6.1', '>' ) ) {
			$html_tag = 'fieldset';
		}

		$output .= preg_replace(
			'/(?=<' . $html_tag . '[^>]+class="[^"]*field-move)/',
			$this->get_fields( $item, $depth, $args ),
			$item_output
		);
	}


	/**
	 * Get custom fields
	 *
	 * @since 0.1.0
	 * @uses add_action() Calls 'menu_item_custom_fields' hook
	 *
	 * @param object $item  Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args  Menu item args.
	 * @param int    $id    Nav menu ID.
	 *
	 * @return string Form fields
	 */
	protected function get_fields( $item, $depth, $args = [], $id = 0 ) {
		ob_start();

		/**
		 * Get menu item custom fields from plugins/themes
		 *
		 * @since 0.1.0
		 *
		 * @param object $item  Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args  Menu item args.
		 * @param int    $id    Nav menu ID.
		 *
		 * @return string Custom fields
		 */
		do_action( 'menu_item_custom_fields', $item, $depth, $args, $id );

		return ob_get_clean();
	}
}