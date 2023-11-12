<?php
/**
 * Kayo sidebars
 *
 * Register default sidebar for the theme with the kayo_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Kayo
 * @since 1.0.0
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register blog and page sidebar and footer widget area.
 */
function kayo_sidebars_init() {

	/* Blog Sidebar */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'kayo' ),
			'id'            => 'sidebar-main',
			'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'kayo' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		/* Page Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Page Sidebar', 'kayo' ),
				'id'            => 'sidebar-page',
				'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	} elseif ( class_exists( 'Wolf_Core' ) ) {
		/* Page Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Page Sidebar', 'kayo' ),
				'id'            => 'sidebar-page',
				'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/**
	 * Filters the side panel presence
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_allow_side_panel', true ) ) {
		/* Side Panel Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Side Panel Sidebar', 'kayo' ),
				'id'            => 'sidebar-side-panel',
				'description'   => esc_html__( 'Add widgets here to appear in your side panel if enabled.', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Footer Sidebar */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'kayo' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'kayo' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	/* Discography sidebar */
	if ( class_exists( 'Wolf_Discography' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Discography Sidebar', 'kayo' ),
				'id'            => 'sidebar-discography',
				'description'   => esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Videos sidebar */
	if ( class_exists( 'Wolf_Videos' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Videos Sidebar', 'kayo' ),
				'id'            => 'sidebar-videos',
				'description'   => esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Albums sidebar */
	if ( class_exists( 'Wolf_Albums' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Albums Sidebar', 'kayo' ),
				'id'            => 'sidebar-albums',
				'description'   => esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Photos sidebar */
	if ( class_exists( 'Wolf_Photos' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Photo Sidebar', 'kayo' ),
				'id'            => 'sidebar-attachment',
				'description'   => esc_html__( 'Appears before the image details on single photo pages', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Photo Sidebar Secondary', 'kayo' ),
				'id'            => 'sidebar-attachment-secondary',
				'description'   => esc_html__( 'Appears after the image details on single photo pages', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Events sidebar */
	if ( class_exists( 'Wolf_Events' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Events Sidebar', 'kayo' ),
				'id'            => 'sidebar-events',
				'description'   => esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* MP Timetable sidebar */
	if ( class_exists( 'Mp_Time_Table' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Timetable Event Sidebar', 'kayo' ),
				'id'            => 'sidebar-mp-event',
				'description'   => esc_html__( 'Appears on the single event pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Timetable Column Sidebar', 'kayo' ),
				'id'            => 'sidebar-mp-column',
				'description'   => esc_html__( 'Appears on the single column pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Artists sidebar */
	if ( class_exists( 'Wolf_Artists' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Artists Sidebar', 'kayo' ),
				'id'            => 'sidebar-artists',
				'description'   => esc_html__( 'Appears on the artists pages if a layout with sidebar is set', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* WooCommerce sidebar */
	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'kayo' ),
				'id'            => 'sidebar-shop',
				'description'   => esc_html__( 'Add widgets here to appear in your shop page if a sidebar is visible.', 'kayo' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'kayo_sidebars_init' );
