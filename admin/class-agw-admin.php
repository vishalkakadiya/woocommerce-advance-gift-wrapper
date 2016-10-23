<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://profiles.wordpress.org/vishalkakadiya/
 * @since      1.0.0
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Gift_Wrapper
 * @subpackage Advanced_Gift_Wrapper/admin
 * @author     Vishal Kakadiya <vishalkakadiya123@gmail.com>
 */
class AGW_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since 	 1.0.0
	 * @access   private
	 * @var 	 string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 * @param   string    $plugin_name  The name of this plugin.
	 * @param   string    $version	    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Plugin backend CSS
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Plugin backend JS
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-gift-wrapper-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add backend settings page.
	 * 
	 * @since 1.0.0
	 */
	function admin_action() {
		add_menu_page( 
			'WC - Gift Wrap', 
			'WC - Gift Wrap', 
			'edit_pages', 
			'agw_gift_wrap', 
			array( 
			    $this, 
			    'display_settings' 
			) 
		);
	}

	/**
	 * Display all settings and save data in backend settings page.
	 * 
	 * @since 1.0.0
	 */
	function display_settings() { 
		/**
		 * Display backend options on settings page.
		 */
		include_once 'templates/display-options.php';
	}

	/**
	 * Save admin settings in options table.
	 * 
	 * @since 1.0.0
	 */
	function save_settings() {
		if ( isset( $_POST['vk_agw_save_gift_wrap'] ) ) {
			$enable_gift_wrap = $enable_gift_in_shop = $enable_image_upload = 0;

			if ( isset( $_POST['vk_agw_enable_gift_wrap'] ) )
				$enable_gift_wrap = 1;

			if ( isset( $_POST['vk_agw_enable_gift_in_shop'] ) )
				$enable_gift_in_shop = 1;

			if ( ! empty( $_POST['vk_agw_enable_image_upload'] ) )
				$enable_image_upload = 1;

			update_option( '_vk_agw_enable_gift_wrap', $enable_gift_wrap, 'no' );
			update_option( '_vk_agw_enable_gift_in_shop', $enable_gift_in_shop, 'no' );
			update_option( '_vk_agw_enable_image_upload', $enable_image_upload, 'no' );

			$agw_pic_price = intval( $_POST['vk_agw_pic_price'] );
			update_option( '_vk_agw_pic_price', $agw_pic_price, 'no' );
		}
	}

	/**
	 * Display gift form fields data which user enter on front-end side,
	 * while placing order.
	 * 
	 * @since   1.0.0
	 * 
	 * @param   int	    $item_id	Product ID
	 */
	function display_order_itemmeta( $item_id ) { 
		/**
		 * Display order item's metadata for gift wrapper item.
		 */
		include_once 'templates/display-order-itemmeta.php';
	}

}
